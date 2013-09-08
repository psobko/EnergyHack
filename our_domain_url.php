//set POST variables
$url = $_POST['url'];
unset($_POST['url']);

$fields_string = "";
//url-ify the data for the POST
foreach($_POST as $key=>$value) { 
	$fields_string .= $key.'='.$value.'&#038;'; 
}
$fields_string = rtrim($fields_string,'&#038;');

$headers = array("Authorization: Bearer [eyJhbGciOiJSUzI1NiJ9.eyJqdGkiOiIzMi4yZTQ0ZTVmNi1kYzA0LTQ0MjYtYWUzNS1lMzc3Nzk3MjkxYWMiLCJhdWQiOiJjb21tZXJjZSIsInBybiI6InZlcm5vbkBkYXRhY3VzdG9kaWFuLmNvbSIsInJlYWxtX2FjY2VzcyI6eyJyb2xlcyI6WyJ1c2VyIl19fQ.iJgJTyZQv4CatSIhAx3ZzQjT3pyoEeUelGsEvM9vgu32hNAFtdRA2EEU3p7LEv7AlgEnemBPaF11UfTN1p5mV9wti8WGfbK7yYGrbsIfxbC_Qtlu22BoZlu3IPPK-Per_w0_wc9EiaEZ_C9V2xMY2NdSoknvlWb181NFneDtROg]");
$url = "https://greenbutton.affsys.com/ldc/api/v1/UsagePoint";

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//curl_setopt($ch,CURLOPT_GET);
//curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);