<?php

require __DIR__ . "/inc/bootstrap.php";
 
$requestMethod = $_SERVER["REQUEST_METHOD"];
 
if (strtoupper($requestMethod) != 'POST') {

    header("HTTP/1.1 404 Not Found");
    echo 'Method not Allowed';
    exit();
}

require PROJECT_PATH . "/Controller/Api/SmsClass.php";


$responseSmsRequest = new SmsCLass();
$responseSmsRequest->callBackUrl(); //method to process the request

?>