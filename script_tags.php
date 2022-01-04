<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include_once("includes/connection.php");
include_once("includes/Shopify.php");

$shopify = new Shopify();
$paramters = $_GET;

include_once("includes/check_token.php");

$script_url = "https://36e7-103-231-46-197.ngrok.io/beauty2/scripts/beauty2.js";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if ($_POST['action_type'] == 'create_script') {
		// echo "string";
		$scriptTags_data = array(
			"script_tag" => array(
				"event" => "onload",
				"src" => $script_url
			)
		);
		$create_script = $shopify->rest_api('/admin/api/2021-10/script_tags.json', $scriptTags_data, 'POST');
		$create_script = json_decode($create_script['body'], true);
		// echo print_r($create_script);
	}
	if ($_POST['action_type'] == 'delete_script') {
		$script_tag = array('src' => $script_url);
		$get_script = $shopify->rest_api('/admin/api/2021-10/script_tags.json', $script_tag, 'GET');
		$get_script = json_decode($get_script['body'], true);
		// echo print_r($get_script);

		foreach ($get_script['script_tags'] as $script) {
			$delete_script = $shopify->rest_api('/admin/api/2021-10/script_tags.json'.$script['id'].'.json', array(), 'DELETE');
		}
	}
}
echo "</br>";
$script_tags = $shopify->rest_api('/admin/api/2021-10/script_tags.json', array(), 'GET');
$response_product = json_decode($script_tags['body'], true);
// echo print_r($response_product);
include_once("header.php");
?>
<section>
	<aside>
		<h2>Install Script Tag</h2>
		<p>Click the install button to apply our script to your shopify store.</p>
	</aside>
	<article>
		<div class="card">
			<form action="" method="POST">
				<input type="hidden" name="action_type" value="create_script">
				<button type="submit">Create Script Tags</button>
			</form>			
		</div>
	</article>
</section>
<section>
	<aside>
		<h2>Delete Script Tag</h2>
		<p>Click the delete button to delete the script from your shopify store.</p>
	</aside>
	<article>
		<div class="card">
			<form action="" method="POST">
				<input type="hidden" name="action_type" value="delete_script">
				<button type="submit">Delete Script</button>
			</form>			
		</div>
	</article>
</section>