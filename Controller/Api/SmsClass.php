<?php

//use Contracts\SmsContract as SmsContract;
require_once PROJECT_PATH . "/Contracts/SmsContract.php";

class SmsCLass extends BaseClass implements SmsContract 
{

    public function createRequest()
    {
        //this method receives parameters of message type and creates a sms request

        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'POST') {

            $client = $this->checkNumber($_REQUEST['to']);
            $msg = $_REQUEST['content'];

            if(empty($msg) && $client){

                var_dump('this one');
                exit();
            }

            try {

                $smsModel = new SmsModel();

                $to = $_REQUEST['to'];
                $content = $_REQUEST['content'];

                $data = array(
                    'to' => $to,
                    'content' => $content
                );
 
                $arrUsers = $smsModel->storeSmsRequest($data);

                if(!$arrUsers){

                    $strErrorDesc = 'Error trying to send your Sms. Ensure you have provided correct details';
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }

            } catch (Error $e) {

                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';

            }

        } else {

            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';

        }
 
        // send output
        if (!$strErrorDesc) {

            $this->sendOutput(
                json_encode(array('message' => 'Success message was sent to user with contact +'.$to)),
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );

        } else {

            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );

        }
    }

    public function callBackUrl()
    {

        //this method recives the call back url request from clickatell and makes necessary updates

        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        // var_dump($arrQueryStringParams);
        // exit();
 
        if (strtoupper($requestMethod) == 'POST') {

            try {

                $smsModel = new SmsModel();

                $data = array(
                    'meesageid' => $_REQUEST['messageId'],
                    'requestid' => $_REQUEST['requestId'],
                    'clietmsgid' => $_REQUEST['clientMessageId'],
                    'statuscode' => $_REQUEST['statusCode'],
                    'status_s' => $_REQUEST['status'],
                    'statusdesc' => $_REQUEST['statusDescription'],
                    'timestamp_s' => $_REQUEST['timestamp'],
                );
 
                $arrUsers = $smsModel->updateSms($data);

                if(!$arrUsers){

                    $strErrorDesc = 'Error trying to update Sms';
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }

            } catch (Error $e) {

                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';

            }

        } else {

            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';

        }
 
        // send output
        if (!$strErrorDesc) {

            $this->sendOutput(
                json_encode(array('message' => 'Record saved')),
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );

        } else {

            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );

        }

        $this->sendOutput(
            ' the callback url was arrived at',
            array('Content-Type: application/json', 'HTTP/1.1 200 OK')
        );
    }

    public function test_input($data) 
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function checkNumber($number)
    {
        if(preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $number)) {
            return true;
          }
    }
}