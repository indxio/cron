<?php

$urls['cexo'] = 'https://cex.io/api/tickers/USD/EUR/BTC';
$urls['polx'] = 'https://poloniex.com/public?command=returnTicker';

$urls['btsp']['base'] = 'https://www.bitstamp.net/api/v2/ticker/';
$urls['btsp']['pairs']['btc_usd'] = 'btcusd';
$urls['btsp']['pairs']['btc_eur'] = 'btceur';
$urls['btsp']['pairs']['eur_usd'] = 'eurusd';
$urls['btsp']['pairs']['xrp_usd'] = 'xrpusd';
$urls['btsp']['pairs']['xrp_eur'] = 'xrpeur';
$urls['btsp']['pairs']['xrp_btc'] = 'xrpbtc';


$urls['btfx']['pairs']['btc_usd'] = 'btcusd';
$urls['btfx']['pairs']['ltc_usd'] = 'ltcusd';
$urls['btfx']['pairs']['ltc_btc'] = 'ltcbtc';
$urls['btfx']['pairs']['eth_usd'] = 'ethusd';
$urls['btfx']['pairs']['eth_btc'] = 'ethbtc';
$urls['btfx']['pairs']['etc_btc'] = 'etcbtc';
$urls['btfx']['pairs']['etc_usd'] = 'etcusd';
$urls['btfx']['pairs']['bfx_usd'] = 'bfxusd';
$urls['btfx']['pairs']['bfx_btc'] = 'bfxbtc';
$urls['btfx']['pairs']['zec_usd'] = 'zecusd';
$urls['btfx']['pairs']['zec_btc'] = 'zecbtc';
$urls['btfx']['pairs']['xmr_usd'] = 'xmrusd';
$urls['btfx']['pairs']['xmr_btc'] = 'xmrbtc';
$urls['btfx']['base'] = 'https://api.bitfinex.com/v1/pubticker/';

$urls['btrx']['pairs'] = array('blk_btc'=>'btc-blk','cann_btc'=>'btc-cann','ccn_btc'=>'btc-ccn','doge_btc'=>'btc-doge','drk_btc'=>'btc-dash','ltc_btc'=>'btc-ltc','myr_btc'=>'btc-myr','nxt_btc'=>'btc-nxt','pot_btc'=>'btc-pot','utc_btc'=>'btc-utc','via_btc'=>'btc-via');
$urls['btrx']['base'] = 'https://bittrex.com/api/v1.1/public/getmarketsummary?market=';

$urls['gdax']['pairs']['btc_usd'] = 'btc-usd';
$urls['gdax']['pairs']['ltc_btc'] = 'ltc-btc';
$urls['gdax']['pairs']['ltc_usd'] = 'ltc-usd';
$urls['gdax']['pairs']['eth_btc'] = 'eth-btc';
$urls['gdax']['pairs']['eth_usd'] = 'eth-usd';
$urls['gdax']['pairs']['btc_eur'] = 'btc-eur';
$urls['gdax']['pairs']['btc_gbp'] = 'btc-gbp';
$urls['gdax']['base'] = 'https://api.gdax.com/products/';
$urls['gdax']['end'] = '/ticker';

$urls['gmni']['pairs'] = array('btc_usd'=>'btcusd','eth_usd'=>'ethusd','eth_btc'=>'ethbtc');
$urls['gmni']['base'] = 'https://api.gemini.com/v1/pubticker/';

$urls['hbtc']['pairs'] = array('doge_btc'=>'DOGEBTC','ltc_btc'=>'LTCBTC','btc_usd'=>'BTCUSD','eur_usd'=>'EURUSD','ltc_usd'=>'LTCUSD','btc_eur'=>'BTCEUR','ltc_eur'=>'LTCEUR');
$urls['hbtc']['base'] = 'https://api.hitbtc.com/api/1/public/'
$urls['hbtc']['end'] = '/ticker';

$urls['itbt']['pairs'] = array('btc_usd' => 'XBTUSD', 'btc_eur' => 'XBTEUR');
$urls['itbt']['base'] = 'https://api.itbit.com/v1/markets/';
$urls['itbt']['end'] = '/ticker';

$urls['krkn']['plist'] = array('XETHXXBT'=>'eth_btc','XETHZEUR'=>'eth_eur','XETHZUSD'=>'eth_usd','XLTCZEUR'=>'ltc_eur','XXBTXLTC'=>'btc_ltc','XXBTXNMC'=>'btc_nmc','XXBTZEUR'=>'btc_eur','XXBTZUSD'=>'btc_usd','XLTCZUSD'=>'ltc_usd');
$urls['krkn']['base'] = 'https://api.kraken.com/0/public/Ticker?pair=xbtusd,xbteur,ltcusd,ltceur,ethxbt,etheur,ethusd';

$urls['okcn']['pairs'] = array('btc','ltc');
$urls['okcn']['usd']['base'] = 'https://www.okcoin.com/api/v1/ticker.do?symbol=';
$urls['okcn']['cny']['base'] = 'https://www.okcoin.cn/api/v1/ticker.do?symbol=';

?>
