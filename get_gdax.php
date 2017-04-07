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
echo '<hr>GDAX Started<hr>';
$gdax_pairs = array('btc_usd' => 'btc-usd','ltc_btc' => 'ltc-btc','ltc_usd' => 'ltc-usd',
  'eth_btc' => 'eth-btc','eth_usd' => 'eth-usd','btc_eur' => 'btc-eur','btc_gbp' => 'btc-gbp');
$gdax_url = 'https://api.gdax.com/products/';
foreach($gdax_pairs as $us => $them){
  $tmpdata = getData($gdax_url.$them.'/ticker');
  $pair = $us;
  $val = $tmpdata['price'];
  $vol = $tmpdata['volume'];
  $query = 'INSERT INTO `current` VALUES(null,"gdax","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00")';

echo '<br>QUERY:<br>'.$query.'<hr>';

$con->query($query);
}

$con->close();
$time = microtime(true) - $time_start;
echo '<hr>Script completed in '.$time.' seconds<hr>';
?>
