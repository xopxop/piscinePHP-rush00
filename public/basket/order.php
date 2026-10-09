<?php require_once("../../private/initialize.php") ?>
<?php require_login(); ?>
<?php $page_title = "Order" ?>
<?php

$subject_set = find_all_subjects();
$display_orders = false;
if (isset($_SESSION['order']['total_price']) && $_SESSION['order']['total_price'] > 0 && isset($_SESSION['order']['total_quantity']) && $_SESSION['order']['total_quantity'] > 0) {
	$order = [];
	$order['user_id'] = $_SESSION['user_id'];
	$order['date'] = date('Y-m-d');
	$order['total_quantity'] = $_SESSION['order']['total_quantity'];
	$order['total_price'] = $_SESSION['order']['total_price'];
	insert_order($order);
	$order_id = mysqli_insert_id($db);
	foreach ($_SESSION['shopping_cart'] as $id => $quantity) {
		$item = find_item_by_id($id);
		$orderred_item = [];
		$orderred_item['item_id'] = $item['id'];
		$orderred_item['order_id'] = $order_id;
		$orderred_item['quantity'] = $quantity;
		$orderred_item['price'] = $item['price'];
		insert_orderred_item($orderred_item);
	}
	unset($_SESSION['shopping_cart']);
	unset($_SESSION['order']);
} else {
	$display_orders = true;
}

?>
<?php include(SHARED_PATH . "/homepage_header.php") ?>
<div id="content">
	<div class="order">
		<?php if ($display_orders === true) {
			$order_set = find_orders_by_user_id($_SESSION['user_id']);
			while($order = mysqli_fetch_assoc($order_set)) { ?>
		<table class="list">
			<tr>
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
				<td><img src="<?php echo $i['image']; ?>" /></td>
				<td><?php echo $i['item_name']; ?></td>
				<td><?php echo number_format($item['price'], 2) . "$"; ?></td>
				<td><?php echo $item['quantity'] . "p/s"; ?></td>
				<td><?php echo number_format($item['price'] * $item['quantity'], 2) . "$" ; ?>
			</tr>
		<?php } ?>
			<tr>
				<td colspan="3" style="font-size: 30px;">Your order:</td>
				<td style="font-size: 30px;"><?php echo $order['total_quantity'] . "p/s"; ?></td>
				<td style="font-size: 30px;"><?php echo number_format($order['total_price'], 2) . "$" ; ?></td>
			</tr>
		</table>
		<?php mysqli_free_result($item_set); 
			}
			mysqli_free_result($order_set);
		?>
		<?php } else { ?>
			<h1 class="msg">Thank you for shopping with us!</h1>
		<?php } ?>
	</div>
</div>
<?php include(SHARED_PATH . "/homepage_footer.php") ?>