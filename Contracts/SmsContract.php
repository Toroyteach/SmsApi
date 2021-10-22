<?php

interface SmsContract
{

    public function createRequest();

    public function callBackUrl();
}

?>