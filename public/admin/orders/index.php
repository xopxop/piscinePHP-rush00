<?php require_once("../../../private/initialize.php"); ?>
<?php require_login(); ?>
<?php

if (!isset($_GET['id'])) {
	redirect_to(url_for("/user/index.php"));
}
$id = $_GET['id'];
$admin = find_user_by_id($id);
require_admin($admin);

?>
<?php $page_title = "Admin - Orders" ?>
<?php

$user_set = find_all_users();

?>
<?php include(SHARED_PATH . "/user_header.php"); ?>
<div id="content">
<a href="<?php echo url_for("/admin/index.php?id=" . h(u($admin['id']))); ?>">&laquo; Back to Admin Section</a>
	<div class="order_listing">
	<?php
		$order_set = find_all_orders();
		$index = 0;
		while($order = mysqli_fetch_assoc($order_set)) { ?>
		<h3>Order No: <?php echo ++$index . " (" . $order['date'] . ")"; ?></h3>
		<table class="list">
			<tr>
				<th>Item ID</th>
				<th>Picture</th>
				<th>Item</th>
				<th>Price</th>
				<th>Quantity</th>
				<th>Total</th>
			</tr>
	<?php
			$item_set = find_item_by_order_id($order['id']);
			while ($item = mysqli_fetch_assoc($item_set)) {
				$i = find_item_by_id($item['id']);
		?>
			<tr>
				<td><?php echo $i['id'] ?></td>
				<td><img src="<?php echo $i['image']; ?>" /></td>
				<td><?php echo $i['item_name']; ?></td>
				<td><?php echo number_format($item['price'], 2) . "$" ; ?></td>
				<td><?php echo $item['quantity'] . "p/s"; ?></td>
				<td><?php echo number_format($item['price'] * $item['quantity'], 2) . "$" ; ?>
			</tr>
		<?php } ?>
			<tr>
				<td colspan="4" style="font-size: 30px;">Order:</td>
				<td style="font-size: 30px;"><?php echo $order['total_quantity'] . "p/s"; ?></td>
				<td style="font-size: 30px;"><?php echo number_format($order['total_price'], 2) . "$" ; ?></td>
			</tr>
		</table>
		<?php mysqli_free_result($item_set); 
			}
			mysqli_free_result($order_set);
		?>
	</div>
</div>
<?php include(SHARED_PATH . "/user_footer.php"); ?>