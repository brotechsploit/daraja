<?php
header("Content-Type: application/json");
echo json_encode([
    'ReponseCode' => 0,
    'ResultDesc' => 'Accepted'
]);
http_response_code(200);
$response = file_get_contents('php://input');
file_put_contents("callback.log", "".print_r($response, true)."\n".PHP_EOL, FILE_APPEND);
$callback = json_decode($response, true);

$data = $callback['Body']['stkCallback'] ?? null;

if($data){
    $ResultCode = $callback['CallbackMetadata']['ResultCode'];
    $amount =  null;
    $mpesareceipt = null;
    $phone = null;
    if($ResultCode === 0){
        $Items = $callback['CallbackMetadata']['Item'];
        foreach($Items as $Item){
            if($Item['Name'] === 'Amount'){
                $amount = $Item['Value'];
            }
            if($Item['Name'] === 'PhoneNumber'){
                $phone = $Item['PhoneNumber'];

            }
            if($Item['Name'] === 'MpesaReceiptNumber'){
                $mpesareceipt = $Item['Value'];
            }
        }
        //here run your update to the database
    } 
}

