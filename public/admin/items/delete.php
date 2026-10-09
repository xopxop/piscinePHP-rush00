<?php require_once("../../../private/initialize.php"); ?>
<?php require_login(); ?>
<?php

$admin_id = $_SESSION['user_id'];
$admin = find_user_by_id($admin_id);
require_admin($admin);

?>
<?php $page_title = "Admin - Item Delete" ?>

<?php

if (!isset($_GET['id'])) {
	redirect_to(url_for("/admin/index.php" . h(u($admin_id)) ));
}
$item_id = $_GET['id'];
$item = find_item_by_id($item_id);
$subject = find_subject_by_id($item['subject_id']);

if (is_post_request()) {
	$result = delete_item($item['id']);
	redirect_to(url_for("/admin/subjects/show.php?id=" . h(u($subject['id']))));
}

?>
<?php include(SHARED_PATH . "/user_header.php"); ?>
<div id="content">
	<div class="admin_items_delete">
			<a href="<?php echo url_for("/admin/subjects/show.php?id=" . h(u($subject['id']))); ?>" >&laquo; Back to Item list</a>
			<h1>Admin: <?php echo h(u($admin['username'])); ?></h1>
			<h2>Delete Item: <?php echo $item['item_name']; ?></h2>
			<p>Are you sure you want to delete this item?</p>
			<form action="<?php echo url_for("/admin/items/delete.php?id=" . h(u($item_id))); ?>" method="post">
				<div>
					<input type="submit" name="commit" value="Delete this item"/>
				</div>
			</form>
		</div>
	</div>
</div>
<?php include(SHARED_PATH . "/user_footer.php"); ?>