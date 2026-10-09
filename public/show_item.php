<div class="item">
	<div>
		<a href="<?php echo url_for("index.php?id=" .h(u($item['id'])) ); ?>">
			<img class="item_picture" src="<?php echo $item['image']; ?>"/>
		</a>
		<div><?php echo $item['item_name']; ?></div>
	</div>
	<div><?php echo number_format($item['price'], 2) . " $"; ?></div>
	<form action="" method="post">
		<input type="hidden" name="id" value="<?php echo h($item['id']); ?>" />
		<input type="number" name="quantity" value="0" min="1" max="9" />
		<input type="submit" name="add_to_cart" value="Add to basket" />
	</form>
</div>