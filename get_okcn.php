<?php
$query = 'INSERT INTO `current` VALUES';
$time_start = microtime(true);

require 'creds.php';
date_default_timezone_set("UTC");

function timeStamp(){ return date('Y-m-d H:i'); };

function getData($url){
  $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36');
  $response=curl_exec($ch);
  $data = json_decode($response,true);
  return $data;
};
$con = new mysqli($host,$user,$pass,$db);
echo '<hr>OKCN Started<hr>';
$okcnPairs = array('btc','ltc');
$usdurl = 'https://www.okcoin.com/api/v1/ticker.do?symbol=';
$cnyurl = 'https://www.okcoin.cn/api/v1/ticker.do?symbol=';
foreach ($okcnPairs as $key => $coin) {
  $tmpusd = getData($usdurl.$coin.'_usd');
  $okcnD1 = $tmpusd['ticker'];
  $query .= '(null,"okcn","'.$coin.'_usd'.'",'.$okcnD1['last'].','.$okcnD1['vol'].',"'.timeStamp().':00"),';
  $tmpcny = getData($cnyurl.$coin.'_cny');
  $okcnD2 = $tmpcny['ticker'];
  $query .= '(null,"okcn","'.$coin.'_cny'.'",'.$okcnD2['last'].','.$okcnD2['vol'].',"'.timeStamp().':00")';
  echo '<br>QUERY:<br>'.$query.'<hr>';

  $con->query($query);
}

$con->close();
$time = microtime(true) - $time_start;
echo '<hr>Script completed in '.$time.' seconds<hr>';
?>
