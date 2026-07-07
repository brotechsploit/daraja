<?php
namespace Brotechsploit\Daraja;
use Exception;
use Error;
use InvalidArgumentException;

class Daraja{
    private string $consumerkey;
    private string $consumersecret;
    private string $passkey;
    private string $shortcode;
    private string $baseurl;
    private string $callbackurl;
    private string $apiusername;
    private string $apipassword;
    private string $timeoutUrl;
    private string $resultUrl;
    public function __construct(array $config=[])
    {
        if(empty($config)){
            $config = require __DIR__.'/../configs/classconnect.php';
        }
        $required = [
            'consumerkey',
            'consumersecret',
            'shortcode',
            'passkey',
            'callbackurl',
            'sandbox',
            'apiusername',
            'apipassword',
            'timeouturl',
            'resulturl'
        ];
        foreach($required as $key){
            if(!array_key_exists($key, $config)){
                throw new InvalidArgumentException("Missing configuration key : {$key}");
            }
        }
      
        $this->consumerkey = $config['consumerkey'];
        $this->consumersecret = $config['consumersecret'];
        $this->passkey = $config['passkey'];
        $this->shortcode = $config['shortcode'];
        $this->callbackurl =  $config['callbackurl'];
        $this->baseurl = $config['sandbox'] ? 'https://sandbox.safaricom.co.ke': 'https://api.safaricom.co.ke';
        $this->apiusername = $config['apiusername'];
        $this->apipassword = $config['apipassword'];
        $this->timeoutUrl = $config['timeouturl'];
        $this->resultUrl = $config['resulturl'];
    }
    public function getAccessToken() : string{
        $apikey = base64_encode($this->consumerkey . ":" . $this->consumersecret);
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => [
                "Authorization: Basic {$apikey}"
            ],
            CURLOPT_RETURNTRANSFER=> true,
            CURLOPT_URL => $this->baseurl . '/oauth/v1/generate?grant_type=client_credentials'
        ]);
        $response = curl_exec($ch);
        if($response === false){
            throw new Exception(curl_errno($ch));
        }
        curl_close($ch);
        $data = json_decode($response);
        if(!$data || !isset($data -> access_token)){
            throw  new Error("failed to generate token");
        }
        $accesstoken = date('Y-m-d H:i:s', time()) .PHP_EOL;
        $accesstoken .= $data->access_token . PHP_EOL;
        $accesstoken .="================================================================" . PHP_EOL;
        file_put_contents('debug.log', "AccessToken: $accesstoken\n", FILE_APPEND);
        return $data->access_token;
    }
    public function sendRequest(string $endpoint, array $payload):array
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$this->getAccessToken()}",
                "Content-Type: application/json"
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => $this->baseurl . $endpoint 
        ]);
        $response = curl_exec($ch);
        if($response === false){
            throw new Exception(curl_errno($ch));
        }
        $data = json_decode($response, true);
        file_put_contents('stkpush_data.txt', "".print_r($data, true)."\n", FILE_APPEND);
        return $data;
    }
    public function stkPush(string $phonenumber, float $amount, string $reference, string $description = 'payment'):array
    {
        $timestamp = date('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);
        $payload = [
            "BusinessShortCode" => $this->shortcode,
            "Password" => $password,
            "Timestamp" => $timestamp,
            "TransactionType"=>  "CustomerPayBillOnline",
            "Amount" => $amount,
            "PartyA"=> $phonenumber,
            "PartyB"=> $this->shortcode,
            "PhoneNumber"=> $phonenumber,
            "CallBackURL"=> $this->callbackurl,
            "AccountReference"=> $reference,
            "TransactionDesc"=> $description
        ];

        return $this->sendRequest('/mpesa/stkpush/v1/processrequest',$payload);
    }

    public function disBursePayments(string $endpoint, array $payload): array
    {
        $ch = curl_init();
        
        curl_setopt_array($ch, [
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$this->getAccessToken()}",
                "Content-Type: application/json"
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_SSL_VERIFYPEER =>true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $this->baseurl . $endpoint,
            CURLOPT_TIMEOUT => 30
        ]);
        $response = curl_exec($ch);

        if($response === false){
            throw new Exception(curl_errno($ch));
        }
        curl_close($ch);
        $result = json_decode($response, true);
        file_put_contents('stkpush_data.txt', "".print_r($result, true)."\n", FILE_APPEND);
        return $result;
    }

    public function B2C(string $phonenumber, float $amount, string $reference = "remarked"):array
    {
        $payload = [
            "InitiatorName" => $this->apiusername,
            "SecurityCredential" => $this->apipassword,
            "CommandID" => "BusinessPayment",
            "Amount"=> $amount,
            "PartyA" => $this->shortcode,
            "PartyB" => $phonenumber,
            "Remarks" =>  $reference,
            "QueueTimeOutURL"=> $this->timeoutUrl ,
            "ResultURL"=> $this->resultUrl,
            "Occassion"=> "payment payout"
        ];

        return $this->disBursePayments('/mpesa/b2c/v3/paymentrequest',$payload);

    }

    public function B2Pochi(string $phonenumber, float $amount, string $reference = 'payoutpochi'):array
    {
        $payload = [
            "InitiatorName" => $this->apiusername,
            "SecurityCredential"=> $this->apipassword,
            "CommandID" => "BusinessPayToPochi",
            "Amount"=> $amount,
            "PartyA" => $this->shortcode,
            "PartyB" => $phonenumber,
            "Remarks" =>  $reference,
            "QueueTimeOutURL" => $this->timeoutUrl,
            "ResultURL" => $this->resultUrl,
            "Occassion" => "payment payout"

        ];
        return $this->disBursePayments('/mpesa/b2pochi/v1/paymentrequest',$payload);
    }

    public function B2Btillnumber(string $storenumber, float $amount, string $reference):array
    {
        $payload = [
            "Initiator" => $this->apiusername,
            "SecurityCredential" => $this -> apipassword,
            "Command ID" => "BusinessBuyGoods",
            "SenderIdentifierType" => "4",
            "RecieverIdentifierType" =>"4",
            "Amount" => $amount,
            "PartyA" => $storenumber,
            "PartyB" => $this ->shortcode,
            "AccountReference" => $reference,
            "Remarks" => "OK",
            "QueueTimeOutURL" => $this->timeoutUrl,
            "ResultURL"=> $this -> resultUrl

        ];

        return $this->disBursePayments('mpesa/b2b/v1/paymentrequest',$payload);
    }
    public function AccountBalance(): array
    {
        $payload = [
            "Initiator" => $this->apiusername,
            "SecurityCredential"=> $this->apipassword,
            "CommandID"=> "AccountBalance",
            "PartyA" => $this->shortcode,
            "IdentifierType"=> "4",
            "Remarks"=> "ok",
            "QueueTimeOutURL"=> $this->timeoutUrl,
            "ResultURL"=> $this->resultUrl
        ];

        return $this->disBursePayments('/mpesa/accountbalance/v1/query', $payload);
    }


}