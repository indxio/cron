<?php
require getdata_begin.php;
echo '<hr>POLX Started<hr>';
$polx_data = getData('https://poloniex.com/public?command=returnTicker');
$pcount = count($polx_data);
$count = 0;
foreach($polx_data as $key => $value){
  $count++;
  $tpair = strtolower($key);
  $tmp = explode('_',$tpair);
  $pair = $tmp[1].'_'.$tmp[0];
  $val = $value['last'];
  $vol = $value['quoteVolume'];
  if($count == $pcount){
    $query .= '(null,"polx","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00");';
  }else{
    $query .= '(null,"polx","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
  }
}
require getdata_end.php;
?>
