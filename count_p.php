<?php
$IP = $_SERVER['REMOTE_ADDR'];
$brouser=$_SERVER['HTTP_USER_AGENT'];
$ref=$_SERVER['HTTP_REFERER'];
$url=$_SERVER['REQUEST_URI'];
$date = date("d.m.y");
$time = date("H:i:s");
$words = "1";
$referer = isset($_SERVER['HTTP_REFERER']) ? strtolower($_SERVER['HTTP_REFERER']) : 'Реферера нету...';
$bots = array("5.255.210.93", "37.9.118.28", "66.249.64.25", "66.249.66.8", "66.249.66.40", "77.122.28.197", "87.250.246.129", "93.158.155.137",
"95.108.129.196", "95.108.129.207", "95.108.129.196", "95.108.158.234", "95.108.241.251", "130.193.51.55", "141.8.132.32", "141.8.142.38", 
"157.55.32.112", "157.55.33.31", "178.154.165.250", "178.154.224.114", "178.154.224.118", "213.180.206.197", "213.180.206.205");
if (06 < date("H")){
	if ( date("H") < 22){
		foreach ($bots as &$i) {
		    if ($i == $IP){
		    	$fb = fopen( "bots.txt","a" );
		  	  	fwrite($fb, $IP);
		  	  	fwrite($fb, "	$time	$date $brouser \r\n");
		  	 	fclose( $fb );
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

                if (in_array ("$k", $value)) {

                    $words = $v;

                break;

                }

            }

            elseif ("$k" == $value) {

                $words = $v;

                break;

            }

            else {

                $words = "0";

                break;

                }

            }

            break;

        }

    }

		$fd = fopen( "count.txt","a" );
		fwrite($fd, $IP);
		fwrite($fd, "p	$time $words	$site	$url	$brouser \r\n");
		fclose( $fd );
	}
}
echo "$time";
?>
