<?php require_once("../../private/initialize.php"); ?>
<?php require_login(); ?>
<?php $page_title = "User - Setting" ?>
<?php

if (!isset($_GET['id'])) {
	redirect_to(url_for("index.php"));
}
$id = $_GET['id'];
$user = find_user_by_id($id);

?>
<?php include(SHARED_PATH . "/user_header.php"); ?>
<div id="content">
	<div class="user_setting">
		<h1>Setting</h1>
		<a href="<?php echo url_for("index.php"); ?>">&laquo; Back to Homepage</a>
		<ul>
			<li><a href="<?php echo url_for("/user/edit.php?id=" . h(u($user['id']))); ?>">Edit account</a></li>
			<li><a href="<?php echo url_for("/user/delete.php?id=" . h(u($user['id']))); ?>">Delete account</a></li>
			<?php if ($user['access'] === "1") { ?> 
			<li><a href="<?php echo url_for("/admin/index.php?id=" . h(u($user['id']))); ?>">Admin Section</a></li>
			<?php } ?>
		</ul>
	</div>
</div>
<?php include(SHARED_PATH . "/user_footer.php"); ?>