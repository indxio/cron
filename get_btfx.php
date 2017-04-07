<?php
require getdata_begin.php;
echo '<hr>BTFX Started<hr>';
$btfx_pairs = array('btc_usd' => 'btcusd','ltc_usd' => 'ltcusd','ltc_btc' => 'ltcbtc','eth_usd' => 'ethusd',
  'eth_btc' => 'ethbtc','etc_btc' => 'etcbtc','etc_usd' => 'etcusd','bfx_usd' => 'bfxusd','bfx_btc' => 'bfxbtc',
  'zec_usd' => 'zecusd','zec_btc' => 'zecbtc','xmr_usd' => 'xmrusd','xmr_btc' => 'xmrbtc');
  $btfx_url = 'https://api.bitfinex.com/v1/pubticker/';
foreach ($btfx_pairs as $us => $them) {
  $tmpdata = getData($btfx_url.$them);
  $pair = $us;
  $val = $tmpdata['last_price'];
  $vol = $tmpdata['volume'];
  $query .= '(null,"btfx","'.$pair.'",'.$val.','.$vol.',"'.timeStamp().':00"),';
}
require getdata_end.php;
?>
