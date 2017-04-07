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
echo '<hr>BTCE Started<hr>';
$btce_data = getData('https://btc-e.com/api/3/ticker/btc_usd-btc_eur-ltc_usd-ltc_btc-nmc_usd-nmc_btc-nvc_usd-nvc_btc-eur_usd-ppc_usd-ppc_btc-dsh_btc-eth_btc-eth_usd-eth_ltc?ignore_invalid=1');
$bcount = count($btce_data);
$btrack = 1;
foreach ($btce_data as $key => $value) {
  $pair = $key;
  $val = $value['last'];
  $vol = $value['vol_cur'];
  if($btrack < $bcount){
  $btrack++;
  $query .= '(null,"btce","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}else{
  $query .= '(null,"btce","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00")';
}
}
echo '<br>QUERY:<br>'.$query.'<hr>';
$con = new mysqli($host,$user,$pass,$db);
$con->query($query);
$con->close();
$time = microtime(true) - $time_start;
echo '<hr>Script completed in '.$time.' seconds<hr>';
?>
