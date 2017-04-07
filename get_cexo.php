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
echo '<hr>CEXO Started<hr>';
$cexo_data = getData('https://cex.io/api/tickers/USD/EUR/BTC');
$bcount = count($cexo_data);
$btrack = 1;
foreach ($cexo_data['data'] as $key => $value) {
  $tmp = explode(':',$cexo_data['data'][$key]['pair']);
  $pair = strtolower($tmp[0].'_'.$tmp[1]);
  $val = $cexo_data['data'][$key]['last'];
  $vol = $cexo_data['data'][$key]['volume'];
  if($btrack < $bcount){
  $btrack++;
  $query .= '(null,"cexo","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}else{
  $query .= '(null,"cexo","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00")';
}

}
echo '<br>QUERY:<br>'.$query.'<hr>';
$con = new mysqli($host,$user,$pass,$db);
$con->query($query);
$con->close();
$time = microtime(true) - $time_start;
echo '<hr>Script completed in '.$time.' seconds<hr>';
?>
