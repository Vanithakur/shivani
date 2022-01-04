<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include_once("includes/connection.php");
include_once("includes/Shopify.php");
//include_once("CSS/uptown.css");
?>


<?php
$shopify = new Shopify();
$paramters = $_GET;

include_once("includes/check_token.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	echo "string";
	if (isset($_POST['product_title']) && isset($_POST['product_body_html']) && $_POST['action_type'] == 'create_product') {
		$product_data = array(
			"product" => array(
				'title' => $_POST['product_title'],
				'body_html' => $_POST['product_body_html']
			)
		);
		$create_product = $shopify->rest_api('/admin/api/2021-10/products.json', $product_data, 'POST');
		$create_product = json_decode($create_product['body'], true);
		print_r($create_product);
	}
	if (isset($_POST['delete_id']) && $_POST['action_type'] == 'delete') {
		$delete = $shopify->rest_api('/admin/api/2021-10/products/'.$_POST['delete_id'].'.json',array(), 'DELETE');
	    $delete = json_decode($delete['body'], true);	
	}
	if (isset($_POST['update_id']) && $_POST['action_type'] == 'update') {
		$update_data = array(
           "product" => array(
              'id' => $_POST['update_id'],
              'title' => $_POST['update_name']
           )
		);
		$update = $shopify->rest_api('/admin/api/2021-10/products/'.$_POST['update_id'].'.json', $update_data, 'PUT');
		$update = json_decode($update['body'], true);
	}
}
$delete = $shopify->rest_api('/admin/api/2021-10/products.json', array('limit' => 69), 'GET');
$products = json_decode($delete['body'], true);

?>
<h3 style="color: red;">HELLO GUY'S</h3>
<?php include_once("header.php");?>
<section>
	<aside>
		<h2>Create New Product</h2>
		<p>Fill out the following form and click the submit button to create a new product.</p>
	</aside>
	<article>
		<div class="card">
			<form action="" method="POST">
				<input type="hidden" name="action_type" value="create_product">
				<div class="row">
					<label for="productTitle">Title</label>
					<input type="text" name="product_title" id="productTittle">
				</div>
				<div class="row">
					<label for="productDescription">Description</label>
					<textarea name="product_body_html" id="productDescription"></textarea>
				</div>
				<div class="row">
					<button type="submit">Submit</button>
				</div>
			</form>
		</div>
	</article>
</section>
<section>
	<table>
		<thead>
			<tr>
				<th colspan="2">Product</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
			
		</thead>
		<tbody>
			<?php
              foreach ($products as $product) {
              		foreach ($product as $key => $value) {
              		    $image = count($value['images'])>0 ? $value['images'][0]['src'] : "";              		              		
              		?>
              		<tr>
              	 		<td><img width="35" height="35" src="<?php echo $image ?>"></td>
              	 		<td>
              	 			<form action="" method="POST" class="row side-elements">
              	 				<input type="hidden" name="update_id" value="<?php echo $value['id'];?>">
              	 				<input type="text" name="update_name" value="<?php echo $value['title'];?>">
              	 				<input type="hidden" name="action_type" value="update">
              	 				<button type="submit" class="secondary icon-checkmark"></button>
              	 			</form>
              	 		</td>
              	 		<td><?php  echo $value['status']?></td>
              	 		<td>
              	 			<form action="" method="POST">
              	 				<input type="hidden" name="delete_id" value="<?php echo $value['id']?>">
              	 				<input type="hidden" name="action_type" value="delete">
              	 			    <button class="secondary icon-trash"></button>
              	 		    </form>
              	 	    </td>
              	 	</tr>
              	 	<?php
              	  }
              }
			?>
		</tbody>
	</table>
</section>

<?php include_once("footer.php");?>

