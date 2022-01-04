<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include_once("includes/connection.php");
$api_key = '288762a5cdd55231f391452e35f61e7f';
$secret_key = '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';
$parameters = $_GET;
$shop_url = $parameters['shop'];
$hmac = $parameters['hmac'];
$parameters = array_diff_key($parameters,array('hmac'=>''));
ksort($parameters);
$new_hmac = hash_hmac('sha256', http_build_query($parameters), $secret_key);
if(hash_equals($hmac, $new_hmac)){
	$access_token_endpoint = 'https://'.$shop_url.'/admin/oauth/access_token';
	$var = array(
		"client_id" => $api_key,
		"client_secret" => $secret_key,
		"code" => $parameters['code']     
	);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $access_token_endpoint);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, count($var));
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($var));

	$response = curl_exec($ch);
	curl_close($ch);

	$response = json_decode($response,true);
	echo print_r($response);
	$query = "INSERT INTO shops(shop_url, access_token, install_time) VALUES('" .$shop_url. "','" .$response['access_token']. "',NOW()) on DUPLICATE KEY UPDATE access_token='".$response['access_token']."'";
    if ($conn->query($query)) {
    	echo "<script>top.window.location= 'https://".$shop_url."/admin/apps'</script>";
    	die();
    	// header("Location: https://".$shop_url.'/admin/apps');
    	// exit();	
    }
}
else{
	echo "this is not coming from shopify";
}	