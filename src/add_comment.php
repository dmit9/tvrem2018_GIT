<?php
require("phpMQTT.php");
$brouser = $_SERVER['HTTP_USER_AGENT'];
$ref = $_SERVER['HTTP_REFERER'];
$url = $_SERVER['REQUEST_URI'];
$date = date('d.m.y');
$time = date('H:i:s');
$referer = isset($_SERVER['HTTP_REFERER']) ? strtolower($_SERVER['HTTP_REFERER']) : '�������� ����...';
$ref = parse_url(urldecode($referer));
$site = $ref['host'];

function getRealIpAddr() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))        // Определяем IP
    { $ip=$_SERVER['HTTP_CLIENT_IP']; }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    { $ip=$_SERVER['HTTP_X_FORWARDED_FOR']; }
    else { $ip=$_SERVER['REMOTE_ADDR']; }
    return $ip;}
$IP = getRealIpAddr();
	
$server = "apte9a.noip.me";     // change if necessary
$port = 1883;                     // change if necessary
$username = "test";                   // set your username
$password = "test";                   // set your password
$client_id = "phpMQTT-publisher"; // make sure this is unique for connecting to sever - you could use uniqid()

$name = $_POST['name'];
$comment = $_POST['comment'];

$url = 'OTZIV';

$mqtt = new phpMQTT($server, $port, $client_id);

if ($mqtt->connect(true,NULL,$username,$password)) {
	 $mqtt->publish("name",$name , 0);
     $mqtt->publish("comment",$comment , 0);
     $mqtt->publish("time",$time , 0);
     $mqtt->publish("IP",$IP  , 0);
     $mqtt->publish("page","OtziV"  , 0);
     $mqtt->publish("site",$site  , 0);
     $mqtt->publish("url",$url  , 0);
	 $mqtt->publish("brouser",$brouser  , 0);
     $mqtt->close();
}else{
     echo "Fail or time out\n";
}
?>