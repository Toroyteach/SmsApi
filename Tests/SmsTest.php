<?php

require 'Sms.php';
 
class SmsTests extends PHPUnit\Framework\TestCase
{
    private $sms;
 
    protected function setUp() : void
    {
        $this->sms = new Sms();
    }
 
    protected function tearDown() : void
    {
        $this->sms = NULL;
    }
 
    public function testAdd() : void
    {
        $result = $this->sms->add(1, 2);
        $this->assertEquals(3, $result);
    }
 
}