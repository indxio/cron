<?php
$debug = 2;
require 'creds.php';
$time_start = microtime(true);
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
$query = 'INSERT INTO `current` VALUES';

$btcc_data = getData('https://data.btcchina.com/data/ticker?market=all');
foreach ($btcc_data as $key => $value) {
  $pr = explode('_',$key);
  $tpr = str_split($pr[1]);
  $pair = $tpr[0].$tpr[1].$tpr[2].'_'.$tpr[3].$tpr[4].$tpr[5];
  $val = $value['last'];
  $vol = $value['vol'];
  if($debug == 2){echo 'btcc | '.$pair.'<br>value: '.$val.' <br>volume: '.$vol.' <br>timestamp: '.timeStamp().':00<hr>';}
  $query .= '(null,"btcc","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
if($debug == 1 || $debug == 2){ echo '<br>QUERY:<br>'.$query.'<hr>'; }

$btce_data = getData('https://btc-e.com/api/3/ticker/btc_usd-btc_eur-ltc_usd-ltc_btc-nmc_usd-nmc_btc-nvc_usd-nvc_btc-eur_usd-ppc_usd-ppc_btc-dsh_btc-eth_btc-eth_usd-eth_ltc?ignore_invalid=1');
foreach ($btce_data as $key => $value) {
  $pair = $key;
  $val = $value['last'];
  $vol = $value['vol_cur'];
  if($debug == 2){echo 'btce | '.$pair.'<br>value: '.$val.' <br>volume: '.$vol.' <br>timestamp: '.timeStamp().':00<hr>';}
  $query .= '(null,"btce","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
if($debug == 1 || $debug == 2){ echo '<br>QUERY:<br>'.$query.'<hr>'; }



$time_end = microtime(true);
$time = $time_end - $time_start;

echo '<hr>Script completed in '.$time.' seconds<hr>';

$data = array(
  'btfx' => array(),
  'btrx' => array(),
  'btsp' => array(),
  'cexo' => array(),
  'gdax' => array(),
  'gmni' => array(),
  'hbtc' => array(),
  'itbt' => array(),
  'krkn' => array(),
  'okcn' => array(),
  'polx' => array()
);
