<?php
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
echo '<hr>BTRX Started<hr>';
$btrx_pairs = array('blk_btc'=>'btc-blk','cann_btc'=>'btc-cann','ccn_btc'=>'btc-ccn','doge_btc'=>'btc-doge','drk_btc'=>'btc-dash','ltc_btc'=>'btc-ltc','myr_btc'=>'btc-myr','nxt_btc'=>'btc-nxt','pot_btc'=>'btc-pot','via_btc'=>'btc-via');
$btrx_url = 'https://bittrex.com/api/v1.1/public/getmarketsummary?market=';
foreach($btrx_pairs as $us => $them){
  $pair = $us;
  $tmpdata = getData($btrx_url.$them);
  $val = $tmpdata['result'][0]['Last'];
  $vol = $tmpdata['result'][0]['Volume'];
  $query = 'INSERT INTO `current` VALUES(null,"btrx","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00")';
  echo '<br>QUERY:<br>'.$query.'<hr>';
  $con->query($query);
}
$con->close();
$time = microtime(true) - $time_start;
echo '<hr>Script completed in '.$time.' seconds<hr>';
?>
