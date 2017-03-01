<?php
$debug = 0;  // 0 - production  1 -  debug
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

if($debug == 1){ echo '<hr>BTCC Started<hr>'; }
$btcc_data = getData('https://data.btcchina.com/data/ticker?market=all');
foreach ($btcc_data as $key => $value) {
  $pr = explode('_',$key);
  $tpr = str_split($pr[1]);
  $pair = $tpr[0].$tpr[1].$tpr[2].'_'.$tpr[3].$tpr[4].$tpr[5];
  $val = $value['last'];
  $vol = $value['vol'];
  if($debug == 1){echo $pair.'<br>value: '.$val.' <br>volume: '.$vol.' <br>timestamp: '.timeStamp().':00<hr>';}
  $query .= '(null,"btcc","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
if($debug == 1){ $time = microtime(true) - $time_start; echo '<hr>BTCC completed in '.$time.' seconds<hr>'; }
if($debug == 1){ echo '<hr>BTCE Started<hr>'; }
$btce_data = getData('https://btc-e.com/api/3/ticker/btc_usd-btc_eur-ltc_usd-ltc_btc-nmc_usd-nmc_btc-nvc_usd-nvc_btc-eur_usd-ppc_usd-ppc_btc-dsh_btc-eth_btc-eth_usd-eth_ltc?ignore_invalid=1');
foreach ($btce_data as $key => $value) {
  $pair = $key;
  $val = $value['last'];
  $vol = $value['vol_cur'];
  if($debug == 1){echo $pair.'<br>value: '.$val.' <br>volume: '.$vol.' <br>timestamp: '.timeStamp().':00<hr>';}
  $query .= '(null,"btce","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
if($debug == 1){ $time = microtime(true) - $time_start; echo '<hr>BTCE completed in '.$time.' seconds<hr>'; }
if($debug == 1){ echo '<hr>BTFX Started<hr>'; }
$btfx_pairs = array('btc_usd' => 'btcusd','ltc_usd' => 'ltcusd','ltc_btc' => 'ltcbtc','eth_usd' => 'ethusd',
  'eth_btc' => 'ethbtc','etc_btc' => 'etcbtc','etc_usd' => 'etcusd','bfx_usd' => 'bfxusd','bfx_btc' => 'bfxbtc',
  'zec_usd' => 'zecusd','zec_btc' => 'zecbtc','xmr_usd' => 'xmrusd','xmr_btc' => 'xmrbtc');
  $btfx_url = 'https://api.bitfinex.com/v1/pubticker/';
foreach ($btfx_pairs as $us => $them) {
  $tmpdata = getData($btfx_url.$them);
  $pair = $us;
  $val = $tmpdata['last_price'];
  $vol = $tmpdata['volume'];
  if($debug == 1){echo $pair.'<br>value: '.$val.' <br>volume: '.$vol.' <br>timestamp: '.timeStamp().':00<hr>';}
  $query .= '(null,"btfx","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
if($debug == 1){ $time = microtime(true) - $time_start; echo '<hr>BTFX completed in '.$time.' seconds<hr>'; }
if($debug == 1){ echo '<hr>BTRX Started<hr>'; }
$btrx_pairs = array('blk_btc'=>'btc-blk','cann_btc'=>'btc-cann','ccn_btc'=>'btc-ccn','doge_btc'=>'btc-doge','drk_btc'=>'btc-dash','ltc_btc'=>'btc-ltc','myr_btc'=>'btc-myr','nxt_btc'=>'btc-nxt','pot_btc'=>'btc-pot','via_btc'=>'btc-via');
$btrx_url = 'https://bittrex.com/api/v1.1/public/getmarketsummary?market=';
foreach($btrx_pairs as $us => $them){
  $pair = $us;
  $tmpdata = getData($btrx_url.$them);
  $val = $tmpdata['result'][0]['Last'];
  $vol = $tmpdata['result'][0]['Volume'];
  if($debug == 1){echo $pair.'<br>value: '.$val.' <br>volume: '.$vol.' <br>timestamp: '.timeStamp().':00<hr>';}
  $query .= '(null,"btrx","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
if($debug == 1){ $time = microtime(true) - $time_start; echo '<hr>BTRX completed in '.$time.' seconds<hr>'; }
if($debug == 1){ echo '<hr>BTSP Started<hr>'; }
$btsp_pairs = array('btc_usd' => 'btcusd','btc_eur' => 'btceur','eur_usd' => 'eurusd','xrp_usd' => 'xrpusd','xrp_eur' => 'xrpeur','xrp_btc' => 'xrpbtc');
$btsp_url = 'https://www.bitstamp.net/api/v2/ticker/';
foreach($btsp_pairs as $us => $them){
  $pair = $us;
  $tmpdata = getData($btsp_url.$them);
  $val = $tmpdata['last'];
  $vol = $tmpdata['volume'];
  if($debug == 1){echo $pair.'<br>value: '.$val.' <br>volume: '.$vol.' <br>timestamp: '.timeStamp().':00<hr>';}
  $query .= '(null,"btsp","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
if($debug == 1){ $time = microtime(true) - $time_start; echo '<hr>BTSP completed in '.$time.' seconds<hr>'; }
if($debug == 1){ echo '<hr>CEXO Started<hr>'; }
$cexo_data = getData('https://cex.io/api/tickers/USD/EUR/BTC');
foreach ($cexo_data['data'] as $key => $value) {
  $tmp = explode(':',$cexo_data['data'][$key]['pair']);
  $pair = strtolower($tmp[0].'_'.$tmp[1]);
  $val = $cexo_data['data'][$key]['last'];
  $vol = $cexo_data['data'][$key]['volume'];
  if($debug == 1){echo $pair.'<br>value: '.$val.' <br>volume: '.$vol.' <br>timestamp: '.timeStamp().':00<hr>';}
  $query .= '(null,"cexo","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
if($debug == 1){ $time = microtime(true) - $time_start; echo '<hr>CEXO completed in '.$time.' seconds<hr>'; }
if($debug == 1){ echo '<hr>GDAX Started<hr>'; }
$gdax_pairs = array('btc_usd' => 'btc-usd','ltc_btc' => 'ltc-btc','ltc_usd' => 'ltc-usd',
  'eth_btc' => 'eth-btc','eth_usd' => 'eth-usd','btc_eur' => 'btc-eur','btc_gbp' => 'btc-gbp');
$gdax_url = 'https://api.gdax.com/products/';
foreach($gdax_pairs as $us => $them){
  $tmpdata = getData($gdax_url.$them.'/ticker');
  $pair = $us;
  $val = $tmpdata['price'];
  $vol = $tmpdata['volume'];
  if($debug == 1){echo $pair.'<br>value: '.$val.' <br>volume: '.$vol.' <br>timestamp: '.timeStamp().':00<hr>';}
  $query .= '(null,"gdax","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
if($debug == 1){ $time = microtime(true) - $time_start; echo '<hr>GDAX completed in '.$time.' seconds<hr>'; }
if($debug == 1){ echo '<hr>GMNI Started<hr>'; }
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
  if($debug == 1){echo $pair.'<br>value: '.$val.' <br>volume: '.$vol.' <br>timestamp: '.timeStamp().':00<hr>';}
  $query .= '(null,"gmni","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
if($debug == 1){ $time = microtime(true) - $time_start; echo '<hr>GMNI completed in '.$time.' seconds<hr>'; }
if($debug == 1){ echo '<hr>HBTC Started<hr>'; }
$hbtc_pairs =array('doge_btc'=>'DOGEBTC','ltc_btc'=>'LTCBTC','btc_usd'=>'BTCUSD',
  'ltc_usd'=>'LTCUSD','btc_eur'=>'BTCEUR','ltc_eur'=>'LTCEUR');
$hbtc_url = 'https://api.hitbtc.com/api/1/public/';
foreach($hbtc_pairs as $us => $them){
  $pair = $us;
  $tmpdata = getData($hbtc_url.$them.'/ticker');
  $val = $tmpdata['last'];
  $vol = $tmpdata['volume'];
  if($debug == 1){echo $pair.'<br>value: '.$val.' <br>volume: '.$vol.' <br>timestamp: '.timeStamp().':00<hr>';}
  $query .= '(null,"hbtc","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
if($debug == 1){ $time = microtime(true) - $time_start; echo '<hr>HBTC completed in '.$time.' seconds<hr>'; }
if($debug == 1){ echo '<hr>ITBT Started<hr>'; }
$itbt_pairs = array('btc_usd' => 'XBTUSD', 'btc_eur' => 'XBTEUR');
$itbt_url = 'https://api.itbit.com/v1/markets/';
foreach($itbt_pairs as $us => $them){
  $tmpdata = getData($itbt_url.$them.'/ticker');
  $pair = $us;
  $val = $tmpdata['lastPrice'];
  $vol = $tmpdata['volume24h'];
  if($debug == 1){echo $pair.'<br>value: '.$val.' <br>volume: '.$vol.' <br>timestamp: '.timeStamp().':00<hr>';}
  $query .= '(null,"itbt","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
if($debug == 1){ $time = microtime(true) - $time_start; echo '<hr>ITBT completed in '.$time.' seconds<hr>'; }
if($debug == 1){ echo '<hr>KRKN Started<hr>'; }
$tmpData = getData('https://api.kraken.com/0/public/Ticker?pair=xbtusd,xbteur,ltcusd,ltceur,ethxbt,etheur,ethusd');
$krkn = $tmpData['result'];
$plist = array('XETHXXBT'=>'eth_btc','XETHZEUR'=>'eth_eur','XETHZUSD'=>'eth_usd','XLTCZEUR'=>'ltc_eur',
  'XXBTXLTC'=>'btc_ltc','XXBTZEUR'=>'btc_eur','XXBTZUSD'=>'btc_usd','XLTCZUSD'=>'ltc_usd');
  //echo var_dump($krkn);
foreach ($krkn as $kpair => $kdata) {
  $pair = $plist[$kpair];
  $val = $kdata['c'][0];
  $vol = $kdata['v'][1];
  if($debug == 1){echo $pair.'<br>value: '.$val.' <br>volume: '.$vol.' <br>timestamp: '.timeStamp().':00<hr>';}
  $query .= '(null,"krkn","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
if($debug == 1){ $time = microtime(true) - $time_start; echo '<hr>KRKN completed in '.$time.' seconds<hr>'; }
if($debug == 1){ echo '<hr>OKCN Started<hr>'; }
$okcnPairs = array('btc','ltc');
$usdurl = 'https://www.okcoin.com/api/v1/ticker.do?symbol=';
$cnyurl = 'https://www.okcoin.cn/api/v1/ticker.do?symbol=';
foreach ($okcnPairs as $key => $coin) {
  $tmpusd = getData($usdurl.$coin.'_usd');
  $okcnD1 = $tmpusd['ticker'];
  $query .= '(null,"okcn","'.$coin.'_usd'.'",'.$okcnD1['last'].','.$okcnD1['vol'].',"'.timeStamp().':00"),';
  if($debug == 1){echo $coin.'_usd'.'<br>value: '.$okcnD1['last'].' <br>volume: '.$okcnD1['vol'].' <br>timestamp: '.timeStamp().':00<hr>';}
  $tmpcny = getData($cnyurl.$coin.'_cny');
  $okcnD2 = $tmpcny['ticker'];
  $query .= '(null,"okcn","'.$coin.'_cny'.'",'.$okcnD2['last'].','.$okcnD2['vol'].',"'.timeStamp().':00"),';
  if($debug == 1){echo $coin.'_cny'.'<br>value: '.$okcnD2['last'].' <br>volume: '.$okcnD2['vol'].' <br>timestamp: '.timeStamp().':00<hr>';}
}
if($debug == 1){ $time = microtime(true) - $time_start; echo '<hr>OKCN completed in '.$time.' seconds<hr>'; }
if($debug == 1){ echo '<hr>POLX Started<hr>'; }
$polx_data = getData('https://poloniex.com/public?command=returnTicker');
$pcount = count($polx_data);
$count = 0;
foreach($polx_data as $key => $value){
  $count++;
  $tpair = strtolower($key);
  $tmp = explode('_',$tpair);
  $pair = $tmp[1].'_'.$tmp[0];
  $val = $value['last'];
  $vol = $value['quoteVolume'];
  if($debug == 1){echo $pair.'<br>value: '.$val.' <br>volume: '.$vol.' <br>timestamp: '.timeStamp().':00<hr>';}
  if($count == $pcount){
    $query .= '(null,"polx","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00");';
  }else{
    $query .= '(null,"polx","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
  }
}
if($debug == 1){ $time = microtime(true) - $time_start; echo '<hr>POLX completed in '.$time.' seconds<hr>'; }

echo '<br>QUERY:<br>'.$query.'<hr>';
$con = new mysqli($host,$user,$pass,$db);
$con->query($query);
$con->close();
$time = microtime(true) - $time_start;
echo '<hr>Script completed in '.$time.' seconds<hr>';
