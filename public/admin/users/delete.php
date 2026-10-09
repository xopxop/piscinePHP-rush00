<?php require_once("../../../private/initialize.php"); ?>
<?php require_login(); ?>
<?php

$admin_id = $_SESSION['user_id'];
$admin = find_user_by_id($admin_id);
require_admin($admin);

?>
<?php $page_title = "Admin - Users Delete" ?>

<?php

if (!isset($_GET['id'])) {
	redirect_to(url_for("/admin/index.php" . h(u($admin_id)) ));
}
$user_id = $_GET['id'];
$user = find_user_by_id($user_id);
if (is_post_request()) {
	$result = delete_user($user);
	redirect_to(url_for("/admin/users/index.php?id=" . h(u($admin['id']))));
}

?>
<?php include(SHARED_PATH . "/user_header.php"); ?>
<div id="content">
	<div class="admin_user_deleting">
		<a href="<?php echo url_for("/admin/users/index.php?id=" . h(u($admin['id']))); ?>">&laquo; Back to User list</a>
		<h1>Admin: <?php echo h(u($admin['username'])); ?></h1>
		<h2>Delete User: <?php echo $user['username']; ?></h2>
		<p>Are you sure you want to delete this user?</pa>
		<form action="<?php echo url_for("/admin/users/delete.php?id=" . h(u($user_id))); ?>" method="post">
			<div>
				<input type="submit" name="commit" value="Delete this user"/>
			</div>
		</form>
	</div>
</div>
<?php include(SHARED_PATH . "/user_footer.php"); ?>