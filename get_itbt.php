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
echo '<hr>ITBT Started<hr>';
$itbt_pairs = array('btc_usd' => 'XBTUSD', 'btc_eur' => 'XBTEUR');
$itbt_url = 'https://api.itbit.com/v1/markets/';
foreach($itbt_pairs as $us => $them){
  $tmpdata = getData($itbt_url.$them.'/ticker');
  $bcount = count($tmpdata);
$btrack = 1;
  $pair = $us;
  $val = $tmpdata['lastPrice'];
  $vol = $tmpdata['volume24h'];
  if($btrack < $bcount){
  $btrack++;
  $query .= '(null,"itbt","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}else{
  $query .= '(null,"itbt","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00")';
}
echo '<br>QUERY:<br>'.$query.'<hr>';

$con->query($query);
}
$con->close();
$time = microtime(true) - $time_start;
echo '<hr>Script completed in '.$time.' seconds<hr>';
?>
