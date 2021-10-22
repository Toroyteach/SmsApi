<?php

//this file contains a model(database) representation of the SmsModel table

require_once PROJECT_PATH . "/Model/Database.php";
 
class SmsModel extends Database
{

    //stores the sms request that gets created
    public function storeSmsRequest($dataRequest)
    {
        

            $url = "https://platform.clickatell.com/messages/http/send";

            $postRequest = array(
                'apiKey' => $this->key,
                'to' => $dataRequest['to'],
                'content' => $dataRequest['content']
            );

            $data = http_build_query($postRequest);

            $clientUrl = $url."?".$data;

            $cURLConnection = curl_init();
            curl_setopt($cURLConnection, CURLOPT_URL, $clientUrl);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cURLConnection, CURLOPT_HEADER  , true);

            $apiResponse = curl_exec($cURLConnection);
            $httpcode = curl_getinfo($cURLConnection, CURLINFO_HTTP_CODE);
            $header_size = curl_getinfo($cURLConnection, CURLINFO_HEADER_SIZE);
            curl_close($cURLConnection);

            // $apiResponse - available data from the API request
            $jsonArrayResponse = json_decode($apiResponse);
            
            
            if($httpcode == '202'){
                
                $body = substr($apiResponse, $header_size);

                $bodyRaw = json_decode($body, true);


                $item = (json_decode($body));

                $smsid = $item->messages[0]->apiMessageId;
                $number = $item->messages[0]->to;
                $content = $postRequest['content'];


                return $this->storeSms("INSERT INTO sms (sms_id, number, content) VALUES ('$smsid','$number','$content')");

                
            } else {

                 return false;

            }


        
        //return $this->storeSms(""); //if returns true from the response. create the curl request to the website to send sms
    }

    //updates the sms request with request from callback
    public function updateSms($data)
    {

        $messageid = $data['messageid'];
        $requestid = $data['requestid'];
        $clientmsgid = $data['clietmsgid'];
        $statuscode = $data['statuscode'];
        $status_s = $data['status_s'];
        $statusdesc = $data['statusdesc'];
        $times = $data['timestamp_s'];
        
        $result = $this->storeSmsFromCallback("UPDATE sms SET message_id = '$messageid', request_id = '$requestid', client_msg_id = '$clientmsgid', status_code = '$statuscode', status_s = '$status_s', status_desc = '$statusdesc', timestamp_s = '$times' Where sms_id = '$messageid'");

        if($result){

            return true;
            
        } else {

            return false;

        }

    }
}

?>