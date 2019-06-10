<?php
// show error reporting
error_reporting(E_ALL);
 
// set your default time-zone
date_default_timezone_set('Asia/Manila');
 
// variables used for jwt
$key = "example_key";
$iss = "http://localhost";
$aud = "http://localhost";
$initDate = new DateTime();
$iat = $initDate->getTimeStamp();
$nbf = $initDate->getTimeStamp();
$endDate = $initDate;
$endDate->add(new DateInterval('P10D'));
$exp = $endDate->getTimeStamp();
?>