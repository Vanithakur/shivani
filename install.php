<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$api_key = '288762a5cdd55231f391452e35f61e7f';
$server_url = "https://36e7-103-231-46-197.ngrok.io";
$shop = $_GET['shop'];
$scopes = 'read_products,write_products,read_orders,write_orders,read_script_tags,write_script_tags';
$redirect_uri = $server_url.'/beauty2/token.php';
$nonce = bin2hex(random_bytes(12));
$access_mode ='per-user';
$oauth_url = 'https://'.$shop.'/admin/oauth/authorize?client_id='.$api_key.'&scope='.$scopes.'&redirect_uri='.urlencode($redirect_uri).'&state='.$nonce.'&grant_options[]='.$access_mode;
header("Location:".$oauth_url);
exit();