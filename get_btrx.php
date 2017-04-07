<?php
require getdata_begin.php;
echo '<hr>BTRX Started<hr>';
$btrx_pairs = array('blk_btc'=>'btc-blk','cann_btc'=>'btc-cann','ccn_btc'=>'btc-ccn','doge_btc'=>'btc-doge','drk_btc'=>'btc-dash','ltc_btc'=>'btc-ltc','myr_btc'=>'btc-myr','nxt_btc'=>'btc-nxt','pot_btc'=>'btc-pot','via_btc'=>'btc-via');
$btrx_url = 'https://bittrex.com/api/v1.1/public/getmarketsummary?market=';
foreach($btrx_pairs as $us => $them){
  $pair = $us;
  $tmpdata = getData($btrx_url.$them);
  $val = $tmpdata['result'][0]['Last'];
  $vol = $tmpdata['result'][0]['Volume'];
  $query .= '(null,"btrx","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
require getdata_end.php;
?>
