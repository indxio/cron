<?php
require getdata_begin.php;
echo '<hr>BTSP Started<hr>';
$btsp_pairs = array('btc_usd' => 'btcusd','btc_eur' => 'btceur','eur_usd' => 'eurusd','xrp_usd' => 'xrpusd','xrp_eur' => 'xrpeur','xrp_btc' => 'xrpbtc');
$btsp_url = 'https://www.bitstamp.net/api/v2/ticker/';
foreach($btsp_pairs as $us => $them){
  $pair = $us;
  $tmpdata = getData($btsp_url.$them);
  $val = $tmpdata['last'];
  $vol = $tmpdata['volume'];
  $query .= '(null,"btsp","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
require getdata_end.php;
?>
