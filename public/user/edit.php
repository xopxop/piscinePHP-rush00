<?php require_once("../../private/initialize.php") ?>
<?php require_login(); ?>
<?php $page_title = "User - Eddit" ?>
<?php

if (!isset($_GET['id'])) {
	redirect_to(url_for("/user/index.php"));
}

$id = $_GET['id'];

if (is_post_request()) {
	$user = [];
	$user['id'] = $id;
	$user['username'] = "";
	$user['first_name'] = $_POST['first_name'] ?? "";
	$user['last_name'] = $_POST['last_name'] ?? "";
	$user['password'] = $_POST['password'] ?? "";
	$user['confirm_password'] = $_POST['confirm_password'] ?? "";

	$result = update_user($user);
	if ($result === true) {
		redirect_to(url_for("/user/index.php?id=" . $id));
	} else {
		$errors = $result;
	}
}
$user = find_user_by_id($id);

?>
<?php include(SHARED_PATH . "/user_header.php"); ?>
<div id="content">
	<div class="user_edit">
		<a href="<?php echo url_for("/user/index.php?id=" . $id); ?>">&laquo; Back to Setting</a>
		<?php echo display_errors($errors); ?>
		<h1>Edit User: <?php echo $user['username']; ?></h1>
		<form action="<?php echo url_for("/user/edit.php?id=" . h(u($id))); ?>" method="post">
			<dl>
				<dt>First name</dt>
				<dd><input type="text" name="first_name" value="<?php echo $user['first_name']; ?>" /></dd>
			</dl>
			<dl>
				<dt>Last Name</dt>
				<dd><input type="text" name="last_name" value="<?php echo $user['last_name']; ?>" /></dd>
			</dl>
			<dl>
				<dt>Password</dt>
				<dd><input type="password" name="password" value="" /></dd>
			</dl>
			<dl>
				<dt>Confirm Password</dt>
				<dd><input type="password" name="confirm_password" value="" /></dd>
			</dl>
			<p>
				If you want to change password, you should provide password and confirm password, and it should be at least 4 characters.
			</p>
			</br />
			<div>
				<input type="submit" value="Submit" />
			</div>
		</form>
	</div>
</div>
<?php include(SHARED_PATH . "/user_footer.php"); ?>