<?php
require getdata_begin.php;
echo '<hr>OKCN Started<hr>';
$okcnPairs = array('btc','ltc');
$usdurl = 'https://www.okcoin.com/api/v1/ticker.do?symbol=';
$cnyurl = 'https://www.okcoin.cn/api/v1/ticker.do?symbol=';
foreach ($okcnPairs as $key => $coin) {
  $tmpusd = getData($usdurl.$coin.'_usd');
  $okcnD1 = $tmpusd['ticker'];
  $query .= '(null,"okcn","'.$coin.'_usd'.'",'.$okcnD1['last'].','.$okcnD1['vol'].',"'.timeStamp().':00"),';
  $tmpcny = getData($cnyurl.$coin.'_cny');
  $okcnD2 = $tmpcny['ticker'];
  $query .= '(null,"okcn","'.$coin.'_cny'.'",'.$okcnD2['last'].','.$okcnD2['vol'].',"'.timeStamp().':00"),';
}
require getdata_end.php;
?>
