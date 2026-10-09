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
$subject_id = $_GET['id'];
if (is_post_request()) {
	$subject = [];
	$subject['id'] = $subject_id;
	$subject['category_name'] = $_POST['category_name'] ?? '';
	$subject['position'] = $_POST['position'] ?? '';

	$result = update_subject($subject);
	if ($result === true) {
		redirect_to(url_for("/admin/subjects/show.php?id=" . $subject_id));
	} else {
		$errors = $result;
	}
}

$subject = find_subject_by_id($subject_id);
$item_set = find_items_by_subject_id($subject['id']);
$item_count = mysqli_num_rows($item_set);

?>
<?php include(SHARED_PATH . "/user_header.php"); ?>
<div id="content">
	<div class="admin_subjects_show">
		<a href="<?php echo url_for("/admin/subjects/index.php?id=" . h(u($admin['id']))); ?>" >&laquo; Back to Subject list</a>
		<h1>Admin: <?php echo h(u($admin['username'])); ?></h1>
		<h2>Subject: <?php echo $subject['category_name']; ?></h2>
		<h3>Total items: <?php echo $item_count; ?></h3>
		<a href="<?php echo url_for("/admin/items/new.php?subject_id=" . h(u($subject['id']))); ?>">Create New Item</a>
		<table class="list">
			<tr>
				<th>ID</th>
				<th>Item Name</th>
				<th>Price</th>
				<th>Image</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
			</tr>
			<?php while($item = mysqli_fetch_assoc($item_set) ) {?>
			<tr>
				<td><?php echo h($item['id']); ?></td>
				<td><?php echo h($item['item_name']) ?></td>
				<td><?php echo h($item['price']) . "$"; ?></td>
				<td><img src="<?php echo h($item['image']); ?>"/></td>
				<td><a href="<?php echo	url_for("/admin/items/show.php?id=" . h(u($item['id']))); ?>">View</a></td>
				<td><a href="<?php echo url_for("/admin/items/edit.php?id=" . h(u($item['id']))); ?>">Edit</a></td>
				<td><a href="<?php echo	url_for("/admin/items/delete.php?id=" . h(u($item['id'])));	?>">Delete</a></td>
			</tr>
			<?php } ?>
		</table>
		<?php mysqli_free_result($item_set); ?>
	</div>
</div>
<?php include(SHARED_PATH . "/user_footer.php"); ?>