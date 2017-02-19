<?php
require 'creds.php';

// BTCC
function btcc(){
  $con = new mysqli($host,$user,$pass,$db);
  date_default_timezone_set("UTC");
  $timeStamp = date('Y-m-d H:i:s');
  $url = "https://data.btcchina.com/data/ticker?market=ltcbtc";
  $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36');
  $response=curl_exec($ch);
  $data = json_decode($response,true);
  $info = $data['ticker'];
  $query = 'INSERT IGNORE INTO `btcc` VALUES("","ltc_btc",'.$info['vol'].','.$info['last'].',"'.$timeStamp.'")';
  $con->query($query);
  $con->close();
  echo "BTCC Completed: "+date('Y-m-d H:i:s')+"<br>";
}
// BTCE
function btce(){
  $con = new mysqli($host,$user,$pass,$db);
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
  $query .= 'INSERT IGNORE INTO `btce` VALUES("","'.$pair.'",'.$pairData['vol_cur'].','.$pairData['last'].',"'.$timeStamp.'");';
  }
  $con->multi_query($query);
  $con->close();
  echo "BTCE Completed: "+date('Y-m-d H:i:s')+"<br>";
}
// BTFX
function btfx(){
  $con = new mysqli($host,$user,$pass,$db);
  date_default_timezone_set("UTC");
  $timeStamp = date('Y-m-d H:i:s');
  function getData($url){
  	$ch = curl_init();
  	$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
  	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
  	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  	curl_setopt($ch, CURLOPT_URL,$url);
  	$response=curl_exec($ch);
  	curl_close($ch);
  	return json_decode($response,true);
  }
  $btfxPairs = array('ltc_btc'=>'LTCBTC','btc_usd'=>'BTCUSD','ltc_usd'=>'LTCUSD');
  $url = 'https://api.bitfinex.com/v1/pubticker/';
  foreach ($btfxPairs as $pair=>$bPair){$temp = getData($url.$bPair);
  	if(isset($query)){
  	$query .= 'INSERT IGNORE INTO `btfx` VALUES("","'.$pair.'",'.$temp['volume'].','.$temp['last_price'].',"'.$timeStamp.'");';
  	}else{
  	$query = 'INSERT IGNORE INTO `btfx` VALUES("","'.$pair.'",'.$temp['volume'].','.$temp['last_price'].',"'.$timeStamp.'");';
  	}
  }
  $con->multi_query($query);
  $con->close();
  echo 'BTFX Complete';
}
// BTSP
function btsp(){
  $con = new mysqli($host,$user,$pass,$db);
  date_default_timezone_set("UTC");
  $timeStamp = date('Y-m-d H:i:s');
  $url = 'https://www.bitstamp.net/api/ticker/';
  $ch = curl_init();
  $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
  curl_setopt($ch, CURLOPT_USERAGENT, $agent);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_URL,$url);
  $response=curl_exec($ch);
  curl_close($ch);
  $temp = json_decode($response,true);
  $query = 'INSERT IGNORE INTO `btsp` VALUES("","btc_usd",'.$temp['volume'].','.$temp['last'].',"'.$timeStamp.'");';
  $con->query($query);
  $con->close();
  echo 'BTSP Complete';
}
// CEXO
function cexo(){
  $con = new mysqli($host,$user,$pass,$db);
  date_default_timezone_set("UTC");
  $timeStamp = date('Y-m-d H:i:s');
  $url = "https://cex.io/api/tickers/USD/EUR/BTC";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_URL,$url);
  $response=curl_exec($ch);
  curl_close($ch);
  $data = json_decode($response,true);
  $pairs = array(
  	'btc_eur'=>'BTC:EUR',
  	'ltc_btc'=>'LTC:BTC',
  	'ltc_usd'=>'LTC:EUR',
  	'ltc_usd'=>'LTC:USD',
  	'btc_usd'=>'BTC:USD'
  );
  foreach($data['data'] as $id=>$info){
  	if(in_array($info['pair'],$pairs)){
  		$ipair = array_search($info['pair'],$pairs);
  		$query = 'INSERT IGNORE INTO `cexo` VALUES("","'.$ipair.'",'.$info['volume'].','.$info['last'].',"'.$timeStamp.'")';
  		$con->query($query);
  	}
  }
  $con->close();
  echo 'CEXO Complete';
}
// GMNI
function gmni(){
  $con = new mysqli($host,$user,$pass,$db);
  date_default_timezone_set("UTC");
  $timeStamp = date('Y-m-d H:i:s');
  function getData($url){
  	$ch = curl_init();
  	$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
  	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
  	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  	curl_setopt($ch, CURLOPT_URL,$url);
  	$response=curl_exec($ch);
  	curl_close($ch);
  	return json_decode($response,true);
  }
  $data = getData('https://api.gemini.com/v1/pubticker/btcusd');
  $query = 'INSERT IGNORE INTO `gmni` VALUES("","btc_usd",'.$data['volume']['BTC'].','.$data['last'].',"'.$timeStamp.'");';
  $con->multi_query($query);
  $con->close();
  echo 'GMNI Complete';
}
// HBTC
function hbtc(){
  $con = new mysqli($host,$user,$pass,$db);
  date_default_timezone_set("UTC");
  $timeStamp = date('Y-m-d H:i:s');
  function getData($url){
  	$ch = curl_init();
  	$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
  	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
  	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  	curl_setopt($ch, CURLOPT_URL,$url);
  	$response=curl_exec($ch);
  	curl_close($ch);
  	return json_decode($response,true);
  }
  $hbtcPairs = array('doge_btc'=>'DOGEBTC','ltc_btc'=>'LTCBTC','btc_usd'=>'BTCUSD','eur_usd'=>'EURUSD','ltc_usd'=>'LTCUSD','btc_eur'=>'BTCEUR','ltc_eur'=>'LTCEUR');
  $url = 'https://api.hitbtc.com/api/1/public/';$urlEnd = '/ticker';
  foreach ($hbtcPairs as $pair=>$bPair){$temp = getData($url.$bPair.$urlEnd);
  if(isset($query)){
  	$query .= 'INSERT IGNORE INTO `hbtc` VALUES("","'.$pair.'",'.$temp['volume'].','.$temp['last'].',"'.$timeStamp.'");';
  }else{
  	$query = 'INSERT IGNORE INTO `hbtc` VALUES("","'.$pair.'",'.$temp['volume'].','.$temp['last'].',"'.$timeStamp.'");';
  }
  }
  $con->multi_query($query);
  $con->close();
  echo 'HBTC Complete';
}
// ITBT
function itbt(){
  $con = new mysqli($host,$user,$pass,$db);
  date_default_timezone_set("UTC");
  $timeStamp = date('Y-m-d H:i:s');
  function getData($url){
  	$ch = curl_init();
  	$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
  	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
  	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  	curl_setopt($ch, CURLOPT_URL,$url);
  	$response=curl_exec($ch);
  	curl_close($ch);
  	return json_decode($response,true);
  }
  $itbtPairs = array('btc_usd' => 'XBTUSD', 'btc_eur' => 'XBTEUR');
  $url = 'https://api.itbit.com/v1/markets/';$urlEnd = '/ticker';
  foreach ($itbtPairs as $pair =>$iPair){
  	$tmp = getData($url.$iPair.$urlEnd);
  	$q = 'INSERT IGNORE INTO `itbt` VALUES("","'.$pair.'",'.$tmp['volume24h'].','.$tmp['lastPrice'].',"'.$timeStamp.'");';
  	$con->query($q);
  }
  $con->close();
  echo 'ITBT Complete';
}
// KRKN
function krkn(){
  $con = new mysqli($host,$user,$pass,$db);
  date_default_timezone_set("UTC");
  $timeStamp = date('Y-m-d H:i:s');
  $url = "https://api.kraken.com/0/public/Ticker?pair=xbtusd,xbteur,ltcusd,ltceur,ethxbt,etheur,ethusd";
  $pairs = array(
  	'XETHXXBT'=>'eth_btc',
  	'XETHZEUR'=>'eth_eur',
  	'XETHZUSD'=>'eth_usd',
  	'XLTCZEUR'=>'ltc_eur',
  	'XXBTXLTC'=>'btc_ltc',
  	'XXBTXNMC'=>'btc_nmc',
  	'XXBTZEUR'=>'btc_eur',
  	'XXBTZUSD'=>'btc_usd',
  	'XLTCZUSD'=>'ltc_usd'
  );
  $ch = curl_init();
  $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
  curl_setopt($ch, CURLOPT_USERAGENT, $agent);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_URL,$url);
  $response=curl_exec($ch);
  curl_close($ch);
  $data = json_decode($response,true);
  if($data['error'] == null){
  	foreach($data['result'] as $kPair=>$kData){
  		$query = 'INSERT IGNORE INTO `krkn` VALUES("","'.$pairs[$kPair].'",'.$kData['v'][1].','.$kData['c'][0].',"'.$timeStamp.'")';
  		$con->query($query);
  	}
  }else{ echo 'ERROR: '.$data['error']; }
  $con->close();
  echo 'KRKN Complete';
}
// OKCN
function okcn(){
  $con = new mysqli($host,$user,$pass,$db);
  date_default_timezone_set("UTC");
  $timeStamp = date('Y-m-d H:i:s');
  function getData($url){
  	$ch = curl_init();
  	$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
  	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
  	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  	curl_setopt($ch, CURLOPT_URL,$url);
  	$response=curl_exec($ch);
  	curl_close($ch);
  	return json_decode($response,true);
  }
  $url = 'https://www.okcoin.com/api/ticker.do?ok=1';$temp = getData($url);
  $query = 'INSERT IGNORE INTO `okcn` VALUES("","btc_usd",'.$temp['ticker']['vol'].','.$temp['ticker']['last'].',"'.$timeStamp.'");';
  $con->multi_query($query);
  $con->close();
  echo 'OKCN Complete';
}
// POLX
function polx(){
  $con = new mysqli($host,$user,$pass,$db);
  date_default_timezone_set("UTC");
  $timeStamp = date('Y-m-d H:i:s');
  $url = "https://poloniex.com/public?command=returnTicker";
  $pairs = array(
  	'eth_btc'=>'BTC_ETH',
  	'ltc_btc'=>'BTC_LTC',
  	'eth_usd'=>'USDT_ETH',
  	'ltc_usd'=>'USDT_LTC',
  	'btc_usd'=>'USDT_BTC',
  	'dash_usd'=>'USDT_DASH'
  );
  $ch = curl_init();
  $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
  curl_setopt($ch, CURLOPT_USERAGENT, $agent);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_URL,$url);
  $response=curl_exec($ch);
  curl_close($ch);
  $data = json_decode($response,true);
  	foreach($data as $kPair=>$kData){
  		if(in_array($kPair,$pairs)){
  			$ipair = array_search($kPair,$pairs);
  			$query = 'INSERT IGNORE INTO `polx` VALUES("","'.$ipair.'",'.$kData['quoteVolume'].','.$kData['last'].',"'.$timeStamp.'")';
  			$con->query($query);
  		}
  	}
    $con->close();
    echo 'POLX Complete';
}

btcc();
btce();
btfx();
btsp();
cexo();
gmni();
hbtc();
itbt();
krkn();
okcn();
polx();

?>
