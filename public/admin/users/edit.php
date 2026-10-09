<?php require_once("../../../private/initialize.php"); ?>
<?php require_login(); ?>
<?php

$admin_id = $_SESSION['user_id'];
$admin = find_user_by_id($admin_id);
require_admin($admin);

?>
<?php $page_title = "Admin - Users Edit" ?>

<?php

if (!isset($_GET['id'])) {
	redirect_to(url_for("/admin/index.php" . h(u($admin_id)) ));
}

$user_id = $_GET['id'];

if (is_post_request()) {
	$user = [];
	$user['id'] = $user_id;
	$user['access'] = $_POST['access'];
	$user['first_name'] = $_POST['first_name'] ?? "";
	$user['last_name'] = $_POST['last_name'] ?? "";
	$user['password'] = $_POST['password'] ?? "";
	$user['username'] = $_POST['username'] ?? "";
	$user['confirm_password'] = $_POST['confirm_password'] ?? "";

	$result = update_user($user);
	if ($result === true) {
		redirect_to(url_for("/admin/users/index.php?id=" . $admin_id));
	} else {
		$errors = $result;
	}
}
$user = find_user_by_id($user_id);

?>
<?php include(SHARED_PATH . "/user_header.php"); ?>
<div id="content">
	<div class="admin_user_editting">
		<a href="<?php echo url_for("/admin/users/index.php?id=" . h(u($admin['id']))); ?>">&laquo; Back to User list</a>
		<h1>Admin: <?php echo h(u($admin['username'])); ?></h1>
		<h2>Edit User: <?php echo h(u($user['username'])); ?></h2>
		<?php echo display_errors($errors); ?>
		<form action="<?php echo url_for("/admin/users/edit.php?id=" . h(u($user['id']))); ?>" method="post">
			<dl>
				<dt>First name</dt>
				<dd><input type="text" name="first_name" value="<?php echo $user['first_name']; ?>" /></dd>
			</dl>
			<dl>
				<dt>Last Name</dt>
				<dd><input type="text" name="last_name" value="<?php echo $user['last_name']; ?>" /></dd>
			</dl>
			<dl>
				<dt>Username</dt>
				<dd><input type="text" name="username" value="<?php echo $user['username']; ?>" /></dd>
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
			<dl>
				<dt>Administrator privileges</dt>
				<dd>
					<input type="hidden" name="access" value="0" />
					<input type="checkbox" name="access" value="1"<?php
					if ($user['access'] == "1") { echo " checked"; } ?> />
				</dd>
			</dl>
			<div>
				<input type="submit" value="Submit" />
			</div>
		</form>
	</div>
</div>
<?php include(SHARED_PATH . "/user_footer.php"); ?>