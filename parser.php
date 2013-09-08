<?php
// phpinfo();exit;
// define('BASEURL','https://greenbutton.affsys.com');
// echo BASEURL."/ldc/api/v1/UsagePoint?start=1378353600&duration=86400";exit;
$content = requestURL("https://greenbutton.affsys.com/ldc/api/v1/UsagePoint?start=1378353600&duration=86400");
echo '<pre>';print_r($content);echo '</pre>';




exit;

//********************************************************************//


/**
 *
 * @param String $url: valid website URL to create a snapshot.
 * @return mixed
 */
function requestURL($url = "") {
	$connection = curl_init();
	$headers = array(
// 			"GET /HTTP/1.1",
			"GET",
// 			"Content-type: text/xml;charset=\"utf-8\"",
// 			"Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7",
// 			"Accept-Language: en-US,en;q=0.5",
			"Authorization: Bearer [eyJhbGciOiJSUzI1NiJ9.eyJqdGkiOiIzMi4yZTQ0ZTVmNi1kYzA0LTQ0MjYtYWUzNS1lMzc3Nzk3MjkxYWMiLCJhdWQiOiJjb21tZXJjZSIsInBybiI6InZlcm5vbkBkYXRhY3VzdG9kaWFuLmNvbSIsInJlYWxtX2FjY2VzcyI6eyJyb2xlcyI6WyJ1c2VyIl19fQ.iJgJTyZQv4CatSIhAx3ZzQjT3pyoEeUelGsEvM9vgu32hNAFtdRA2EEU3p7LEv7AlgEnemBPaF11UfTN1p5mV9wti8WGfbK7yYGrbsIfxbC_Qtlu22BoZlu3IPPK-Per_w0_wc9EiaEZ_C9V2xMY2NdSoknvlWb181NFneDtROg]"
	);
	curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($connection, CURLOPT_ENCODING, 'UTF-8');
	curl_setopt($connection, CURLOPT_URL, $url);
	curl_setopt($connection, CURLOPT_AUTOREFERER, true);
	curl_setopt($connection, CURLOPT_REFERER, SERVER);
	curl_setopt($connection, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($connection, CURLOPT_HEADER, false);
	curl_setopt($connection, CURLOPT_MAXREDIRS, 10);
	curl_setopt($connection, CURLOPT_CONNECTTIMEOUT, 180);//value: 10
	curl_setopt($connection, CURLOPT_TIMEOUT, 180);//value: 20
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
// 	curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "/CAcerts/BuiltinObjectToken-EquifaxSecureCA.crt");
	curl_setopt($ch, CURLOPT_CAPATH, "ca.pem");
	curl_setopt($ch, CURLOPT_CAINFO, "ca.pem");
	curl_setopt($ch, CURLOPT_SSLCERT, "server.pem");

	// User Agent: Chrome 20.0.1092.0
	curl_setopt($connection, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/536.6 (KHTML, like Gecko) Chrome/20.0.1092.0 Safari/536.6");
	curl_setopt($connection, CURLOPT_RETURNTRANSFER, true);
	$finalURLContent	= curl_exec($connection);
	
	$header = curl_getinfo( $connection );
	$return = array (
			'httpCode' => curl_getinfo($handle, CURLINFO_HTTP_CODE),
			'error' => curl_errno( $connection ),
			'errmsg' => curl_error($connection),
			'header' => curl_getinfo( $connection ),
			'finalURLContent' => $finalURLContent
	);
	curl_close($connection);
	return $return;
}

?>