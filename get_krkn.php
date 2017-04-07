<?php
require getdata_begin.php;
echo '<hr>KRKN Started<hr>';
$tmpData = getData('https://api.kraken.com/0/public/Ticker?pair=xbtusd,xbteur,ltcusd,ltceur,ethxbt,etheur,ethusd');
$krkn = $tmpData['result'];
$plist = array('XETHXXBT'=>'eth_btc','XETHZEUR'=>'eth_eur','XETHZUSD'=>'eth_usd','XLTCZEUR'=>'ltc_eur',
  'XXBTXLTC'=>'btc_ltc','XXBTZEUR'=>'btc_eur','XXBTZUSD'=>'btc_usd','XLTCZUSD'=>'ltc_usd');
  //echo var_dump($krkn);
foreach ($krkn as $kpair => $kdata) {
  $pair = $plist[$kpair];
  $val = $kdata['c'][0];
  $vol = $kdata['v'][1];
  $query .= '(null,"krkn","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
require getdata_end.php;
?>
