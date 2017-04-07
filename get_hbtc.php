<?php
require getdata_begin.php;
echo '<hr>HBTC Started<hr>';
$hbtc_pairs =array('doge_btc'=>'DOGEBTC','ltc_btc'=>'LTCBTC','btc_usd'=>'BTCUSD',
  'ltc_usd'=>'LTCUSD','btc_eur'=>'BTCEUR','ltc_eur'=>'LTCEUR');
$hbtc_url = 'https://api.hitbtc.com/api/1/public/';
foreach($hbtc_pairs as $us => $them){
  $pair = $us;
  $tmpdata = getData($hbtc_url.$them.'/ticker');
  $val = $tmpdata['last'];
  $vol = $tmpdata['volume'];
  $query .= '(null,"hbtc","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
require getdata_end.php;
?>
