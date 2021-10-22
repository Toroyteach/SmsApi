<?php
define("PROJECT_PATH", __DIR__ . "/../");
 
// include main configuration file
require_once PROJECT_PATH . "/inc/config.php";
 
// include the base controller file
require_once PROJECT_PATH . "/Controller/Api/BaseClass.php";
 
// include the use model file
require_once PROJECT_PATH . "/Model/SmsModel.php";
?>