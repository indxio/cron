<?php
require getdata_begin.php;
echo '<hr>GMNI Started<hr>';
$gmni_pairs = array('btc_usd'=>'btcusd','eth_usd'=>'ethusd','eth_btc'=>'ethbtc');
$gmni_url = 'https://api.gemini.com/v1/pubticker/';
foreach($gmni_pairs as $us => $them){
  $pair = $us;
  $tmpdata = getData($gmni_url.$them);
  $val = $tmpdata['last'];
  $bs = explode('_',$pair);
  switch ($bs[0]) {
    case 'btc':
      $vol = $tmpdata['volume']['BTC'];
      break;
    case 'eth':
      $vol = $tmpdata['volume']['ETH'];
      break;
    default:
      break;
  }
  $query .= '(null,"gmni","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
require getdata_end.php;
?>
