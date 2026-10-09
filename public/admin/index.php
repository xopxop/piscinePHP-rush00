<?php require_once("../../private/initialize.php"); ?>
<?php require_login(); ?>
<?php

if (!isset($_GET['id'])) {
	redirect_to(url_for("/user/index.php"));
}
$id = $_GET['id'];
$user = find_user_by_id($id);

?>
<?php require_admin($user); ?>
<?php $page_title = "Admin Section" ?>
<?php include(SHARED_PATH . "/user_header.php"); ?>
<div id="content">
	<a href="<?php echo url_for("/user/index.php?id=" . h(u($user['id']))); ?>" >&laquo; Back to Setting</a>
	<div class="admin_setting">
		<h1>Admin: <?php echo h(u($user['username'])); ?></h1>
		<ul>
			<li><a href="<?php echo url_for("/admin/users/index.php?id=" . h(u($user['id']))); ?>">User management</a></li>
			<li><a href="<?php echo url_for("/admin/subjects/index.php?id=" . h(u($user['id']))); ?>">Product management</a></li>
			<li><a href="<?php echo url_for("/admin/orders/index.php?id=" . h(u($user['id']))); ?>">Orders</a></li>
		</ul>
	</div>
</div>
<?php include(SHARED_PATH . "/user_footer.php"); ?>