<?php require_once("../../../private/initialize.php"); ?>
<?php require_login(); ?>
<?php

$admin_id = $_SESSION['user_id'];
$admin = find_user_by_id($admin_id);
require_admin($admin);

?>
<?php $page_title = "Admin - Subject Delete" ?>

<?php

if (!isset($_GET['id'])) {
	redirect_to(url_for("/admin/index.php" . h(u($admin_id)) ));
}
$subject_id = $_GET['id'];

if (is_post_request()) {
	$item_set = find_items_by_subject_id($subject_id);
	while ($item = mysqli_fetch_assoc($item_set)) {
		$result = delete_item($item['id']);
	}
	mysqli_free_result($item_set);
	$result = delete_subject($subject_id);
	redirect_to(url_for("/admin/subjects/index.php?id=" . $admin_id));
}

$subject = find_subject_by_id($subject_id);
$item_set = find_items_by_subject_id($subject['id']);
$item_count = mysqli_num_rows($item_set);
mysqli_free_result($item_set);

?>
<?php include(SHARED_PATH . "/user_header.php"); ?>
<div id="content">
	<div class="admin_subjects_delete">
		<a href="<?php echo url_for("/admin/subjects/index.php?id=" . h(u($admin['id']))); ?>">&laquo; Back to Subject list</a>
		<h1>Admin: <?php echo h(u($admin['username'])); ?></h1>
		<h2>Delete Subject: <?php echo $subject['category_name']; ?></h2>
		<p>This subject has <?php echo $item_count; ?> items. Are you sure you want to delete this subject?</pa>
		<form action="<?php echo url_for("/admin/subjects/delete.php?id=" . h(u($subject_id))); ?>" method="post">
			<div>
				<input type="submit" name="commit" value="Delete this subject"/>
			</div>
		</form>
	</div>
</div>
<?php include(SHARED_PATH . "/user_footer.php"); ?>