<?php
require_once 'config.php';

$symbols = array('BTC', 'ETH', 'BAT', 'SAND', 'EGLD', 'BAND', 'ATOM', 'DASH', 'VET', 'LTC', 'LINK', 'DOT', 'CEL');

$url = sprintf('https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest?symbol=%s&CMC_PRO_API_KEY=%s',
	implode(',', $symbols),
	COIN_MARKET_CAP_API_KEY
);


if (file_exists(CACHE_FILE) && time() - filemtime(CACHE_FILE) < CACHE_TIME_SECONDS) {
	$json = file_get_contents(CACHE_FILE);
}
else {
	$json = file_get_contents($url);
	if ($json->status->error_code == 0) {
		file_put_contents(CACHE_FILE, $json);
	}
	else {
		print_r($data);
	}
}
$data = json_decode($json);
$quote_props = array('volume_24h', 'percent_change_1h', 'percent_change_24h', 'percent_change_7d', 'market_cap', 'last_updated');
$props = array('slug', 'num_market_pairs', 'max_supply', 'circulating_supply', 'total_supply');
$headers = array_merge(array('symbol', 'price'), $quote_props, $props);
$currency = COIN_MARKET_CAP_CURRENCY; // If you know how to use a constant to reference a property in object, please let me know.

ob_start();
foreach ($data->data as $symbol => $symbol_data) {
	echo $symbol, "\t", $symbol_data->quote->$currency->price;
	foreach ($quote_props as $quote_prop) {
		echo "\t", $symbol_data->quote->$currency->$quote_prop;
	}
	foreach ($props as $prop) {
		echo "\t", $symbol_data->$prop;
	}
	echo "\n";
}
$rows = ob_get_contents();
ob_clean();
echo implode("\t", $headers), "\n", $rows;
