<?php
require getdata_begin.php;
echo '<hr>BTCE Started<hr>';
$btce_data = getData('https://btc-e.com/api/3/ticker/btc_usd-btc_eur-ltc_usd-ltc_btc-nmc_usd-nmc_btc-nvc_usd-nvc_btc-eur_usd-ppc_usd-ppc_btc-dsh_btc-eth_btc-eth_usd-eth_ltc?ignore_invalid=1');
foreach ($btce_data as $key => $value) {
  $pair = $key;
  $val = $value['last'];
  $vol = $value['vol_cur'];
  $query .= '(null,"btce","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
require getdata_end.php;
?>
