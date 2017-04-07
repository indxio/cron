<?php
require getdata_begin.php;
echo '<hr>GDAX Started<hr>';
$gdax_pairs = array('btc_usd' => 'btc-usd','ltc_btc' => 'ltc-btc','ltc_usd' => 'ltc-usd',
  'eth_btc' => 'eth-btc','eth_usd' => 'eth-usd','btc_eur' => 'btc-eur','btc_gbp' => 'btc-gbp');
$gdax_url = 'https://api.gdax.com/products/';
foreach($gdax_pairs as $us => $them){
  $tmpdata = getData($gdax_url.$them.'/ticker');
  $pair = $us;
  $val = $tmpdata['price'];
  $vol = $tmpdata['volume'];
  $query .= '(null,"gdax","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
require getdata_end.php;
?>
