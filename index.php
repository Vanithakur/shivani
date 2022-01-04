<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include_once("includes/connection.php");
include_once("includes/Shopify.php");

$shopify = new Shopify();
$paramters = $_GET;

include_once("includes/check_token.php");

// echo print_r($response);
?>

	<section>
		<div class="alert success">
			<dl>
				<dt>Success Alert</dt>
				<dd>Successfully Register.</dd>
			</dl>
		</div>
		<div class="alert">
			<dl>
				<dt>
					<p style="color: blue;">WELCOME SHIVANI THAKUR THIS IS YOUR OWN APP.</p>
				</dt>
			</dl>
		</div>
	</section>
	
<?php include_once("header.php");?>

<?php include_once("footer.php");?>