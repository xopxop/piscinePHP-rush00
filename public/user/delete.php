<?php require_once("../../private/initialize.php") ?>
<?php require_login(); ?>
<?php $page_title = "User - Delete" ?>
<?php

if (!isset($_GET['id'])) {
	redirect_to(url_for("/user/index.php"));
}

$id = $_GET['id'];
$user = find_user_by_id($id);

if (is_post_request()) {
	$result = delete_user($user);
	log_out_user();
	redirect_to(url_for("index.php"));
}

?>
<?php include(SHARED_PATH . "/user_header.php"); ?>
<div id="content">
	<div class="user_delete">
		<a href="<?php echo url_for("/user/index.php?id=" . $id); ?>">&laquo; Back to Setting</a>
		<h1>Delete User: <?php echo $user['username']; ?></h1>
		<p>Are you sure you want to delete this user?</pa>
		<form action="<?php echo url_for("/user/delete.php?id=" . h(u($id))); ?>" method="post">
			<div>
				<input type="submit" name="commit" value="Delete this user"/>
			</div>
		</form>
	</div>
</div>
<?php include(SHARED_PATH . "/user_footer.php"); ?>