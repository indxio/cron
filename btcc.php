<?php
require 'creds.php';
$con = new mysqli($host,$user,$pass,$db);
date_default_timezone_set("UTC");
$timeStamp = date('Y-m-d H:i:s');
$url = "https://data.btcchina.com/data/ticker?market=ltcbtc";
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_ENCODING, '');
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36');
  $response=curl_exec($ch);
$data = json_decode($response,true);
$info = $data['ticker'];
		$query = 'INSERT IGNORE INTO `btcc` VALUES("","ltc_btc","'.$info['high'].'","'.$info['low'].'","'.$info['vol'].'","'.$info['last'].'","'.$info['buy'].'","'.$info['sell'].'","'.$timeStamp.'")';
		//echo $query.'<hr />';
		$con->query($query);
$con->close();
?>
