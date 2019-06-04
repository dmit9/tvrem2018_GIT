<?php
require("phpMQTT.php");
/*$IP = $_SERVER['REMOTE_ADDR'];*/
$brouser = $_SERVER['HTTP_USER_AGENT'];
$ref = $_SERVER['HTTP_REFERER'];
$url = $_SERVER['REQUEST_URI'];
$date = date("Y.m.d");
$time = date("H:i:s");
$words = "1";
$referer = isset($_SERVER['HTTP_REFERER']) ? strtolower($_SERVER['HTTP_REFERER']) : '???????? ????...';
$bots = array("5.45.207.1", "5.45.207.48", "5.255.210.93", "5.255.253.12", "5.255.253.17", "37.9.113.11", "37.9.113.36", "37.9.113.131", "37.9.118.28",
    "37.9.118.29", "42.236.54.2", "42.236.99.65", "42.236.99.218", "46.229.168.136", "46.229.168.139", "54.37.234.58", "54.37.234.59", "66.249.64.13",
	"66.249.64.25", "66.249.64.152", "66.249.66.8", "66.249.66.40", "66.249.87.153", "66.249.89.87", "66.249.89.89", "66.249.89.213", "66.249.89.215", 
	"66.249.89.217", "66.249.90.111", "66.249.90.113", "77.122.28.197", "87.250.224.75", "87.250.246.129", "93.158.155.137", "93.158.166.3",
	"93.158.166.9", "93.158.166.12", "95.108.129.196", "95.108.129.207", "95.108.129.196", "95.108.129.200", "95.108.158.234", "95.108.181.80",
	"95.108.213.35", "95.108.213.43", "95.108.241.251", "95.163.255.244", "130.193.51.55", "141.8.132.32", "141.8.142.6", "141.8.142.37", "141.8.142.38",
	"141.8.142.74", "141.8.142.81", "141.8.142.98", "141.8.142.111", "141.8.142.147", "141.8.142.160", "141.8.183.17", "141.8.183.24", "141.8.183.25",
	"141.8.183.36", "157.55.32.112", "157.55.33.31", "176.99.6.254", "178.154.165.250", "178.154.171.30", "178.154.171.60", "178.154.200.7",
	"178.154.200.21", "178.154.200.65", "178.154.200.71", "178.154.244.31", "178.154.244.53", "178.154.244.66i", "178.154.224.114", "178.154.224.118", 
	"178.154.246.2", "178.154.246.7", "178.255.215.94", "180.76.15.19", "180.76.15.17", "180.76.15.25", "180.76.15.136", "180.76.15.142", "180.76.15.151",
	"188.40.102.169", "207.46.13.107", "207.46.13.117", "207.46.13.143", "213.180.203.35", "213.180.203.44", "213.180.206.197", "213.180.203.21",
	"213.180.203.41", "213.180.203.66", "213.180.206.205");

/**/
function getRealIpAddr() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))        // Определяем IP
    { $ip=$_SERVER['HTTP_CLIENT_IP']; }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    { $ip=$_SERVER['HTTP_X_FORWARDED_FOR']; }
    else { $ip=$_SERVER['REMOTE_ADDR']; }
    return $ip;}

$IP = getRealIpAddr();

if ((06 < date("H"))&& !preg_match("/bot|bots|adsbot|AdsBot|metrika|crawl|crawler|slurp|spider|link|checker|script|robot|discovery|preview/i", $_SERVER['HTTP_USER_AGENT'])){
    if (date("H") < 24) {
        foreach ($bots as &$i) {
            if ($i == $IP) {
                $fb = fopen("bots.txt", "a");
                fwrite($fb, $IP);
                fwrite($fb, "	$time	$date $brouser \r\n");
                fclose($fb);
                return;
            }
        }
        unset($i);


        $searchEngines = array(

            'google.' => array('q', 'prev'),

            'yandex.' => array('text', 'query')

        );
        $ref = parse_url(urldecode($referer));

        $site = $ref['host'];

        $text = $ref['query'];

        parse_str($text, $arr);

        foreach ($searchEngines as $key => $value) {

            if (substr_count($site, $key)) {

                foreach ($arr as $k => $v) {

                    if (is_array($value)) {

                        if (in_array("$k", $value)) {

                            $words = $v;

                            break;

                        }

                    } elseif ("$k" == $value) {

                        $words = $v;

                        break;

                    } else {

                        $words = "0";

                        break;

                    }

                }

                break;

            }

        }

        $fd = fopen("count.txt", "a");
        fwrite($fd, $IP);
        fwrite($fd, "lg	$time	$site	$url	$brouser  \r\n");
        fclose($fd);

        $server = "apte9a.noip.me";     // change if necessary
        $port = 1883;                     // change if necessary
        $username = "test";                   // set your username
        $password = "test";                   // set your password
        $client_id = "phpMQTT-publisher"; // make sure this is unique for connecting to sever - you could use uniqid()

        $mqtt = new phpMQTT($server, $port, $client_id);

        if ($mqtt->connect(true,NULL,$username,$password)) {
		   $mqtt->publish("date",$date , 0);
           $mqtt->publish("time",$time , 0);
           $mqtt->publish("IP",$IP  , 0);
           $mqtt->publish("page","LG"  , 0);
           $mqtt->publish("site",$site  , 0);
           $mqtt->publish("url",$url  , 0);
		   $mqtt->publish("brouser",$brouser  , 0);
           $mqtt->close();
        }else{
            echo "Fail or time out\n";
        }
    }
}
echo "$time";
if (06 == date("H")) {
    $fb = fopen("bots.txt", "w");
    fwrite($fb, "");
    fclose($fb);
    $fb = fopen("count.txt", "w");
    fwrite($fb, "");
    fclose($fb);
}

?>
