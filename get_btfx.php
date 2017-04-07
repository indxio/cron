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
echo '<hr>BTFX Started<hr>';
$btfx_pairs = array('btc_usd' => 'btcusd','ltc_usd' => 'ltcusd','ltc_btc' => 'ltcbtc','eth_usd' => 'ethusd',
  'eth_btc' => 'ethbtc','etc_btc' => 'etcbtc','etc_usd' => 'etcusd','bfx_usd' => 'bfxusd','bfx_btc' => 'bfxbtc',
  'zec_usd' => 'zecusd','zec_btc' => 'zecbtc','xmr_usd' => 'xmrusd','xmr_btc' => 'xmrbtc');
  $btfx_url = 'https://api.bitfinex.com/v1/pubticker/';
foreach ($btfx_pairs as $us => $them) {
  $tmpdata = getData($btfx_url.$them);
  $pair = $us;
  $val = $tmpdata['last_price'];
  $vol = $tmpdata['volume'];
  $query = 'INSERT INTO `current` VALUES(null,"btfx","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00")';
  echo '<br>QUERY:<br>'.$query.'<hr>';
  $con->query($query);
}
$con->close();
$time = microtime(true) - $time_start;
echo '<hr>Script completed in '.$time.' seconds<hr>';
?>
