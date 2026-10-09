<?php require_once("../../../private/initialize.php"); ?>
<?php require_login(); ?>
<?php

$admin_id = $_SESSION['user_id'];
$admin = find_user_by_id($admin_id);
require_admin($admin);

?>
<?php $page_title = "Admin - Subject Show" ?>
<?php

if (!isset($_GET['id'])) {
	redirect_to(url_for("/admin/index.php" . h(u($admin_id)) ));
}
$item_id = $_GET['id'];
$item = find_item_by_id($item_id);
$subject = find_subject_by_id($item['subject_id']);

?>
<?php include(SHARED_PATH . "/user_header.php"); ?>
<div id="content">
	<div class="admin_items_show">
		<a href="<?php echo url_for("/admin/subjects/show.php?id=" . h(u($subject['id']))); ?>" >&laquo; Back to Item list</a>
		<h1>Admin: <?php echo h(u($admin['username'])); ?></h1>
		<h2>Item: <?php echo $item['item_name']; ?></h2>
		<div>
			<dl>
				<dt>Category</dt>
				<dd><?php echo h($subject['category_name']); ?></dd>
			</dl>
			<dl>
				<dt>Price</dt>
				<dd><?php echo h($item['price']) . " $"; ?></dd>
			</dl>
			<dl>
				<dt>Image</dt>
				<dd><img src="<?php echo $item['image']; ?>"></dd>
			</dl>
		</div>
	</div>
</div>
<?php include(SHARED_PATH . "/user_footer.php"); ?>