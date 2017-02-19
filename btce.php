<?php
date_default_timezone_set("UTC");
$timeStamp = date('Y-m-d H:i:s');
$query = "";
$url = "https://btc-e.com/api/3/ticker/btc_usd-btc_eur-ltc_usd-ltc_btc-nmc_usd-nmc_btc-nvc_usd-nvc_btc-eur_usd-ppc_usd-ppc_btc-dsh_btc-eth_btc-eth_usd-eth_ltc?ignore_invalid=1";
$ch = curl_init();
$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);
$response=curl_exec($ch);
curl_close($ch);
$data = json_decode($response,true);
foreach($data as $pair=>$pairData){
$query .= 'INSERT IGNORE INTO `btce` VALUES("","'.$pair.'",'.$pairData['high'].','.$pairData['low'].','.$pairData['vol_cur'].','.$pairData['last'].',"'.$timeStamp.'");';
}
require 'creds.php';
$con = new mysqli($host,$user,$pass,$db);
$con->multi_query($query);
echo $query;
$con->close();
?>
