<?php
//Alexcounter
//Autor: TruLander
//version 3.7b
$v = $HTTP_GET_VARS['v'];
switch ($v)
{
case 'png':
include './counter/online.php';
include"./counter/gdcounter.php";
break;
case 'login':
$url = './counter/admin.php';
$duration = 1200;
//���������� ���������� 
$frt = fopen ("./counter/password", 'r');
$setpassword = fread ($frt, filesize("./counter/password"));
flock($frt,3);
fclose ($frt);
list($setlogin,$setpass)=explode("|",$setpassword);
// �����|������
$members = array(
$setlogin=>$setpass
);
if ( isset($_POST['login']) && isset($_POST['username']) && isset($_POST['password']) ) {
$username = get_magic_quotes_gpc() ? stripslashes($_POST['username']) : $_POST['username'];
$password = get_magic_quotes_gpc() ? stripslashes($_POST['password']) : $_POST['password'];
if ( array_key_exists($username, $members) && $members[$username] === $password ) {
setcookie('username', $username, time()+$duration);
setcookie('password', $password, time()+$duration);
}
header('Location: ' . $url);
exit;
} elseif ( isset($_POST['logout']) ) {
setcookie('username');
setcookie('password');
header('Location: ' . $url);
exit;
}
$registred_user = false;
if ( isset($_COOKIE['username']) && isset($_COOKIE['password']) ) {
$username = get_magic_quotes_gpc() ? stripslashes($_COOKIE['username']) : $_COOKIE['username'];
$password = get_magic_quotes_gpc() ? stripslashes($_COOKIE['password']) : $_COOKIE['password'];
if ( array_key_exists($username, $members) && $members[$username] === $password ) {
$registred_user = $username;
echo'<form action="stat.php" method="post"><input type="hidden" name="logout" value="true">';
echo'<input type="submit" value="Logout"></form>';
}
}
echo'<center>���� � ����� ������<br>�������������';
echo'<form action="stat.php?v=login" method="post">';
echo'Username:<br>';
echo'<input type="text" name="username" value="">';
echo'<br>Password:<br>';
echo'<input type="password" name="password" value=""><br>';
echo'<input type="hidden" name="login" value="true">';
echo'<input type="submit" value="Login"></form></center>';
//include"./counter/gdcounter.php";                                                                                                    
break;                                                                                                                                   

default:                                                                                                                                   

//Autor: Trulander
//version 4.1 WIN-1251 for alexcounter

$Domain = strtolower($_SERVER['SERVER_NAME']);
if (is_int(strpos($_SERVER['SERVER_NAME'], "www.", 0))) {
$Domain =  substr($_SERVER['SERVER_NAME'], 4);
}
define('StatFileName', "./counter/key");

$ip=getenv("REMOTE_ADDR");
$date=date('d.m.Y',time());

//���������� ����������
$fo = fopen ("./counter/ip", 'r');
flock($fo,1);
$data = fread ($fo, filesize("./counter/ip"));
flock($fo,3);
fclose ($fo);

//���������� ���������� 
$f = fopen ("./counter/stat", 'r');
flock($f,1);
$counts = fread ($f, filesize("./counter/stat"));
flock($f,3);
fclose ($f);
list($d,$total,$hits,$hosts,$thosts,$ghosts,$tghosts,$bezref,$tbezref)=explode("|",$counts);
// ����|����|�����|� �����|� ������|� ������|� � ������

//�������� �� ����
if ($d!=$date)
{
include "./counter/zip.php";

$fyy = fopen ("./counter/statday", 'r');
$countsww = fread ($fyy, filesize("./counter/statday"));
flock($fyy,3);
list($d11,$d10,$d9,$d8,$d7,$d6,$d5,$d4,$d3,$d2,$d1,$s11,$s10,$s9,$s8,$s7,$s6,$s5,$s4,$s3,$s2,$s1,$gh11,$gh10,$gh9,$gh8,$gh7,$gh6,$gh5,$gh4,$gh3,$gh2,$gh1,$bz11,$bz10,$bz9,$bz8,$bz7,$bz6,$bz5,$bz4,$bz3,$bz2,$bz1)=explode("|",$countsww);


$wfile=fopen("./counter/statday",'w+');
fputs($wfile,$d10."|".$d9."|".$d8."|".$d7."|".$d6."|".$d5."|".$d4."|".$d3."|".$d2."|".$d1."|".$date."|".$s10."|".$s9."|".$s8."|".$s7."|".$s6."|".$s5."|".$s4."|".$s3."|".$s2."|".$s1."|".$hosts."|".$gh10."|".$gh9."|".$gh8."|".$gh7."|".$gh6."|".$gh5."|".$gh4."|".$gh3."|".$gh2."|".$gh1."|".$ghosts."|".$bz10."|".$bz9."|".$bz8."|".$bz7."|".$bz6."|".$bz5."|".$bz4."|".$bz3."|".$bz2."|".$bz1."|".$bezref);
fclose($wfile);    

$d=$date;
$hits=0;
$hosts=0;
$ghosts=0;
$bezref=0;
$erase=fopen("./counter/ip",'w+');
$resetkey=fopen(StatFileName,'w+');
fputs($erase,"");
fclose($erase);
fputs($resetkey,"");
fclose($resetkey);

}
              
//������� �������������
function utf8_win($s) {
$s=strtr($s,array("\xD0\xB0"=>"�", "\xD0\x90"=>"�", "\xD0\xB1"=>"�", "\xD0\x91"=>"�",
 "\xD0\xB2"=>"�", "\xD0\x92"=>"�", "\xD0\xB3"=>"�", "\xD0\x93"=>"�", "\xD0\xB4"=>"�",
 "\xD0\x94"=>"�", "\xD0\xB5"=>"�", "\xD0\x95"=>"�", "\xD1\x91"=>"�", "\xD0\x81"=>"�",
 "\xD0\xB6"=>"�", "\xD0\x96"=>"�", "\xD0\xB7"=>"�", "\xD0\x97"=>"�", "\xD0\xB8"=>"�",
 "\xD0\x98"=>"�", "\xD0\xB9"=>"�", "\xD0\x99"=>"�", "\xD0\xBA"=>"�", "\xD0\x9A"=>"�",
 "\xD0\xBB"=>"�", "\xD0\x9B"=>"�", "\xD0\xBC"=>"�", "\xD0\x9C"=>"�", "\xD0\xBD"=>"�",
 "\xD0\x9D"=>"�", "\xD0\xBE"=>"�", "\xD0\x9E"=>"�", "\xD0\xBF"=>"�", "\xD0\x9F"=>"�",
 "\xD1\x80"=>"�", "\xD0\xA0"=>"�", "\xD1\x81"=>"�", "\xD0\xA1"=>"�", "\xD1\x82"=>"�",
 "\xD0\xA2"=>"�", "\xD1\x83"=>"�", "\xD0\xA3"=>"�", "\xD1\x84"=>"�", "\xD0\xA4"=>"�",
 "\xD1\x85"=>"�", "\xD0\xA5"=>"�", "\xD1\x86"=>"�", "\xD0\xA6"=>"�", "\xD1\x87"=>"�",
 "\xD0\xA7"=>"�", "\xD1\x88"=>"�", "\xD0\xA8"=>"�", "\xD1\x89"=>"�", "\xD0\xA9"=>"�",
 "\xD1\x8A"=>"�", "\xD0\xAA"=>"�", "\xD1\x8B"=>"�", "\xD0\xAB"=>"�", "\xD1\x8C"=>"�",
 "\xD0\xAC"=>"�", "\xD1\x8D"=>"�", "\xD0\xAD"=>"�", "\xD1\x8E"=>"�", "\xD0\xAE"=>"�",
 "\xD1\x8F"=>"�", "\xD0\xAF"=>"�"));
return $s;
}

//������ �������
function GetSearchText() {
global $Resultkey;
$Resultkey = '';
if (isset($_SERVER['HTTP_REFERER'])) {
$Ref= $_SERVER['HTTP_REFERER'];
if (!(empty($Ref))) {
$UrlArray = parse_url($Ref);
if ( $UrlArray['scheme'] == 'http' ) {
$RefHost = $UrlArray['host'];

$IsGoogle = strpos($RefHost, 'www.google.');
if (($RefHost == 'search.msn.com')  ||
( is_int($IsGoogle) && ($IsGoogle == 0) )) {
parse_str($UrlArray['query']);
$Resultkey = utf8_win($q);

} elseif (($RefHost == 'images.google.')||($RefHost == 'video.google.')||($RefHost == 'news.google.')) {
parse_str($UrlArray['query']);
$Resultkey = utf8_win($q);

} elseif (($RefHost == 'www.bing.com')||($RefHost == 'bing.com')) {
parse_str($UrlArray['query']);
$Resultkey = utf8_win($q);

} elseif (($RefHost == 'www.rambler.ru')||($RefHost == 'nova.rambler.ru')||($RefHost == 'news.rambler.ru')) {
parse_str($UrlArray['query']);
$Resultkey = utf8_win($query);

} elseif ($RefHost == 'top100.rambler.ru') {
parse_str($UrlArray['query']);
$Resultkey = $query;

} elseif (($RefHost == 'go.mail.ru')||($RefHost == 'mail.ru')||($RefHost == 'soft.mail.ru')) {
parse_str($UrlArray['query']);
$Resultkey = $q;

} elseif (($RefHost == 'yandex.ru')||($RefHost == 'www.yandex.ru')||($RefHost == 'www.ya.ru')||($RefHost == 'ya.ru')||($RefHost == 'images.yandex.ru')||($RefHost == 'news.yandex.ru')||($RefHost == 'blogs.yandex.ru')||($RefHost == 'video.yandex.ru')||($RefHost == 'm.yandex.ru')) {
parse_str($UrlArray['query']);
$Resultkey = utf8_win($text);

} elseif (($RefHost == 'yandex.kz')||($RefHost == 'www.yandex.kz')||($RefHost == 'www.ya.kz')||($RefHost == 'ya.kz')||($RefHost == 'images.yandex.kz')||($RefHost == 'news.yandex.kz')||($RefHost == 'blogs.yandex.kz')||($RefHost == 'video.yandex.kz')||($RefHost == 'm.yandex.kz')) {
parse_str($UrlArray['query']);
$Resultkey = utf8_win($text);

} elseif (($RefHost == 'yandex.ua')||($RefHost == 'www.yandex.ua')||($RefHost == 'www.ya.ua')||($RefHost == 'ya.ua')||($RefHost == 'images.yandex.ua')||($RefHost == 'news.yandex.ua')||($RefHost == 'blogs.yandex.ua')||($RefHost == 'video.yandex.ua')||($RefHost == 'm.yandex.ua')) {
parse_str($UrlArray['query']);
$Resultkey = utf8_win($text);

} elseif (($RefHost == 'nigma.ru')||($RefHost == 'www.nigma.ru')) {
parse_str($UrlArray['query']);
$Resultkey = utf8_win($s);

} elseif (($RefHost == 'qip.ru')||($RefHost == 'search.qip.ru')) {
parse_str($UrlArray['query']);
$Resultkey = utf8_win($query);

} elseif (($RefHost == 'aport.ru')||($RefHost == 'sm.aport.ru')) {
parse_str($UrlArray['query']);
$Resultkey = $r;

} elseif (($RefHost == 'pics.aport.ru')||($RefHost == 'audio.aport.ru')||($RefHost == 'video.aport.ru')) {
parse_str($UrlArray['query']);
$Resultkey = utf8_win($r);
}
}}} 

//�������� ���� �� ���� �� ���� ������
// ���� ��� �������� ���� ���� 1
// ���� � ��������� �� ���� ���� 2

$frro = fopen ("./counter/siteurl", 'r');
$siteurl = fread ($frro, filesize("./counter/siteurl"));
fclose ($frro);

if( $UrlArray["host"] != $siteurl ){
if( $UrlArray["host"] != "" ){
global $keyn;$keyn=2;

// ��������� ���� ������� ���� � ���� �� �� ���������� ���
$kek = fopen( StatFileName , 'r');
$datake = join($kek, file(StatFileName));
fclose ($kek);
if (!stristr($datake,$_SERVER["HTTP_REFERER"]))
{

$Resultkey = " $Resultkey</a>\r\n";
if( $fgh = fopen(StatFileName,"a")  )
    {
fwrite($fgh,'<br><search><a href="'. $_SERVER["HTTP_REFERER"] .'">'. $RefHost . '</a></search> <a href="http://'.$_SERVER['SERVER_NAME']. $_SERVER[REQUEST_URI].'">to page'.$Resultkey.'');
fclose($fgh);
}}}
else{global $keyn;$keyn=1;}
}}
$SearchText = GetSearchText();
$fd = fopen(StatFileName, "a" );
fputs ($fd , "$SearchText"); 
fclose( $fd );


//�������� �� ip �����
if (!stristr($data,$ip))
{
//$d,$total,$hits,$hosts,$thosts,$ghosts,$tghosts,$bezref,$tbezref
//����|����|�����|� �����|� ������|� ������|� � ������|� ���|� � ���
global $keyn;
switch ($keyn)
{
case '2':
//echo '���������� � ����������� ������ +1<br>';
$ghosts++;
$tghosts++;
$bezref--;
$tbezref--;
//echo '��� ��������<br>���������� ��� ��� +1';
case '1':
$bezref++;
$tbezref++;
default:
//echo"���������� � ����� +1<br>���������� � ������ +1<br>";
$file=fopen("./counter/ip",'a');
flock($file,2);
fputs($file,$ip."\r\n");
flock($file,3);
fclose($file);
$total++;
$hits++;
$hosts++;
$thosts++;
}
}
else
{
//echo'�� ���������� ����������<br>���������� � ����� +1<br>';
$total++;
$hits++;
}
//���������� ������
$wfile=fopen("./counter/stat",'w+');
flock($wfile,2);
fputs($wfile,$d."|".$total."|".$hits."|".$hosts."|".$thosts."|".$ghosts."|".$tghosts."|".$bezref."|".$tbezref);
flock($wfile,3);
fclose($wfile);                                                                                                 
}                                                                                                                                              
?>