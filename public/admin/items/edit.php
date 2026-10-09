<?php require_once("../../../private/initialize.php"); ?>
<?php require_login(); ?>
<?php

$admin_id = $_SESSION['user_id'];
$admin = find_user_by_id($admin_id);
require_admin($admin);

?>
<?php $page_title = "Admin - Item Edit" ?>

<?php

if (!isset($_GET['id'])) {
	redirect_to(url_for("/admin/index.php" . h(u($admin_id)) ));
}
$item_id = $_GET['id'];
if (is_post_request()) {
	$item = [];
	$item['id'] = $item_id;
	$item['item_name'] = $_POST['item_name'] ?? '';
	$item['price'] = $_POST['price'] ?? '';
	$item['image'] = $_POST['image'] ?? '';

	$result = update_item($item);
	if ($result === true) {
		redirect_to(url_for("/admin/items/show.php?id=" . $item_id));
	} else {
		$errors = $result;
	}
}

$item = find_item_by_id($item_id);
$subject = find_subject_by_id($item['subject_id']);

?>
<?php include(SHARED_PATH . "/user_header.php"); ?>
<div id="content">
	<div class="admin_items_edit">
		<a href="<?php echo url_for("/admin/subjects/show.php?id=" . h(u($subject['id']))); ?>" >&laquo; Back to Item list</a>
		<h1>Admin: <?php echo h(u($admin['username'])); ?></h1>
		<h2>Edit Item: <?php echo $item['item_name']; ?></h2>
		<?php echo display_errors($errors); ?>
		<form action="<?php echo url_for("/admin/items/edit.php?id=" . h(u($item_id))); ?>" method="post">
			<dl>
				<dt>Item name</dt>
				<dd><input type="text" name="item_name" value="<?php echo
				h($item['item_name']); ?>" /></dd>
			</dl>
			<dl>
				<dt>Price (in $)</dt>
				<dd>
					<input type="number" name="price" value="<?php echo h($item['price']); ?>" min="1" max="200" />
				</dd>
			</dl>
			<dl>
				<dt>Image</dt>
				<dd>
					<textarea name="image" cols="60" rows="5"><?php echo h($item['image']); ?></textarea>
				</dd>
			</dl>
			<div">
				<input type="submit" value="Edit Item" />
			</div>
		</form>
	</div>
</div>
<?php include(SHARED_PATH . "/user_footer.php"); ?>