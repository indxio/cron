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
echo '<hr>KRKN Started<hr>';
$tmpData = getData('https://api.kraken.com/0/public/Ticker?pair=xbtusd,xbteur,ltcusd,ltceur,ethxbt,etheur,ethusd');
$krkn = $tmpData['result'];
$bcount = count($krkn);
$btrack = 1;
$plist = array('XETHXXBT'=>'eth_btc','XETHZEUR'=>'eth_eur','XETHZUSD'=>'eth_usd','XLTCZEUR'=>'ltc_eur',
  'XXBTXLTC'=>'btc_ltc','XXBTZEUR'=>'btc_eur','XXBTZUSD'=>'btc_usd','XLTCZUSD'=>'ltc_usd');
  //echo var_dump($krkn);
foreach ($krkn as $kpair => $kdata) {
  $pair = $plist[$kpair];
  $val = $kdata['c'][0];
  $vol = $kdata['v'][1];
  if($btrack < $bcount){
    $btrack++;
    $query .= '(null,"krkn","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
  }else{
    $query .= '(null,"krkn","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00")';
  }
}
echo '<br>QUERY:<br>'.$query.'<hr>';
$con = new mysqli($host,$user,$pass,$db);
$con->query($query);
$con->close();
$time = microtime(true) - $time_start;
echo '<hr>Script completed in '.$time.' seconds<hr>';
?>
