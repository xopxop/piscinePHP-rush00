<?php require_once("../../private/initialize.php") ?>
<?php $page_title = "Basket" ?>
<?php

$subject_set = find_all_subjects();
$_SESSION['order']['total_price'] = 0;
$_SESSION['order']['total_quantity'] = 0;

if (is_get_request()) {
	if (isset($_GET['delete'])) {
		$item_id = $_GET['delete'];
		unset($_SESSION['shopping_cart'][$item_id]);
	}
}

?>
<?php include(SHARED_PATH . "/homepage_header.php") ?>
<div id="content">
	<div class="basket">
		<?php if (!isset($_SESSION['shopping_cart']) || count($_SESSION['shopping_cart']) === 0) { ?>
			<p>Your basket is empty</p>
		<?php } else { ?>
		<table class="list">
			<tr>
				<th>Picture</th>
				<th>Item</th>
				<th>Price</th>
				<th>Quantity</th>
				<th>Total</th>
				<th>&nbsp;</th>
			</tr>
			<?php
				$total = 0;
				foreach($_SESSION['shopping_cart'] as $id => $quantity) {
					$item = find_item_by_id($id);
					$_SESSION['order']['total_quantity'] += $quantity;
					$_SESSION['order']['total_price'] += number_format($item['price'] * $quantity, 2);
			?>
			<tr>
				<td><img src="<?php echo h($item['image']); ?>"/></td>
				<td><?php echo $item['item_name']; ?></td>
				<td><?php echo $item['price'] . "$"; ?></td>
				<td><?php echo $quantity . "p/s"; ?></td>
				<td><?php echo number_format($item['price'] * $quantity, 2); ?></td>
				<td><a href="<?php echo url_for("/basket/index.php?delete=" . $item['id']); ?>">Delete</a></td>
			</t>
			<?php } ?>
			<tr style="line-height: 50px;">
				<td colspan="3" style="font-size: 30px;">Your order</td>
				<td style="font-size: 30px;"><?php echo $_SESSION['order']['total_quantity'] . "p/s"; ?></td>
				<td style="font-size: 30px;"><?php echo number_format($_SESSION['order']['total_price'], 2) . "$"; ?></td>
				<td>&nbsp;</td>
			</tr>
		</table>
		<?php if (is_logged_in()) {
			
		?>
			<a href="<?php echo url_for("/basket/order.php"); ?>">Confirm the order!</a>
		<?php } else { ?>
			<a href="<?php echo url_for("/user/new.php"); ?>">Click here to create an account!</a>
		<?php } ?>
		<?php } ?>
	</div>
</div>
<?php include(SHARED_PATH . "/homepage_footer.php") ?>