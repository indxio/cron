<?php
require getdata_begin.php;
echo '<hr>BTCC Started<hr>';
$btcc_data = getData('https://data.btcchina.com/data/ticker?market=all');
foreach ($btcc_data as $key => $value) {
  $pr = explode('_',$key);
  $tpr = str_split($pr[1]);
  $pair = $tpr[0].$tpr[1].$tpr[2].'_'.$tpr[3].$tpr[4].$tpr[5];
  $val = $value['last'];
  $vol = $value['vol'];
  $query .= '(null,"btcc","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
require getdata_end.php;
?>
