<?php

$query = "SELECT * FROM shops WHERE shop_url='".$paramters['shop']."'LIMIT 1";
$result = $conn->query($query);
// // print_r($result);
// // die();
if ($result->num_rows<1) {
	header("Location: install.php?shop=".$_GET['shop']);
    exit();
}
$store_data = $result->fetch_assoc();

$shopify->set_url($paramters['shop']);
$shopify->set_token($store_data['access_token']);
// echo $shopify->get_url();
// echo "</br>";
// echo $shopify->get_token();
// echo "hello";
$shop = $shopify->rest_api('/admin/api/2021-10/shop.json', array(), 'GET');
$response = json_decode($shop['body'], true);
if (array_key_exists('errors', $response)) {
	echo "</br>";
	echo "Sorry! your API is not connected please try again".$response['errors'];
	header("Location: install.php?shop=".$_GET['shop']);
}
