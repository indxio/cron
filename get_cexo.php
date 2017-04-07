<?php
require getdata_begin.php;
echo '<hr>CEXO Started<hr>';
$cexo_data = getData('https://cex.io/api/tickers/USD/EUR/BTC');
foreach ($cexo_data['data'] as $key => $value) {
  $tmp = explode(':',$cexo_data['data'][$key]['pair']);
  $pair = strtolower($tmp[0].'_'.$tmp[1]);
  $val = $cexo_data['data'][$key]['last'];
  $vol = $cexo_data['data'][$key]['volume'];
  $query .= '(null,"cexo","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
require getdata_end.php;
?>
