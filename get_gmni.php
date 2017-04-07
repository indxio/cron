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
echo '<hr>GMNI Started<hr>';
$gmni_pairs = array('btc_usd'=>'btcusd','eth_usd'=>'ethusd','eth_btc'=>'ethbtc');
$gmni_url = 'https://api.gemini.com/v1/pubticker/';
foreach($gmni_pairs as $us => $them){
  $pair = $us;
  $tmpdata = getData($gmni_url.$them);
  $val = $tmpdata['last'];
  $bs = explode('_',$pair);
  switch ($bs[0]) {
    case 'btc':
      $vol = $tmpdata['volume']['BTC'];
      break;
    case 'eth':
      $vol = $tmpdata['volume']['ETH'];
      break;
    default:
      break;
  }
  $query = 'INSERT INTO `current` VALUES(null,"gmni","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00")';
  echo '<br>QUERY:<br>'.$query.'<hr>';
  $con->query($query);
}
$con->close();
$time = microtime(true) - $time_start;
echo '<hr>Script completed in '.$time.' seconds<hr>';
?>
