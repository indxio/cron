<?php
require getdata_begin.php;
echo '<hr>ITBT Started<hr>';
$itbt_pairs = array('btc_usd' => 'XBTUSD', 'btc_eur' => 'XBTEUR');
$itbt_url = 'https://api.itbit.com/v1/markets/';
foreach($itbt_pairs as $us => $them){
  $tmpdata = getData($itbt_url.$them.'/ticker');
  $pair = $us;
  $val = $tmpdata['lastPrice'];
  $vol = $tmpdata['volume24h'];
  $query .= '(null,"itbt","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
require getdata_end.php;
?>
