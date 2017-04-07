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
echo '<hr>BTSP Started<hr>';
$btsp_pairs = array('btc_usd' => 'btcusd','btc_eur' => 'btceur','eur_usd' => 'eurusd','xrp_usd' => 'xrpusd','xrp_eur' => 'xrpeur','xrp_btc' => 'xrpbtc');
$btsp_url = 'https://www.bitstamp.net/api/v2/ticker/';
foreach($btsp_pairs as $us => $them){
  $pair = $us;
  $tmpdata = getData($btsp_url.$them);
  $bcount = count($tmpdata);
  $btrack = 1;
  $val = $tmpdata['last'];
  $vol = $tmpdata['volume'];
  if($btrack < $bcount){
    $btrack++;
    $query .= '(null,"btsp","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
  }else{
    $query .= '(null,"btsp","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00")';
  }
  echo '<br>QUERY:<br>'.$query.'<hr>';
  $con->query($query);
}
$con->close();
$time = microtime(true) - $time_start;
echo '<hr>Script completed in '.$time.' seconds<hr>';
?>
