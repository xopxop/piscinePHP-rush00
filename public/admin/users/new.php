<?php require_once("../../../private/initialize.php"); ?>
<?php require_login(); ?>
<?php

$admin_id = $_SESSION['user_id'];
$admin = find_user_by_id($admin_id);
require_admin($admin);

?>
<?php $page_title = "Admin - Create User"; ?>
<?php

if (!isset($_GET['id'])) {
	redirect_to(url_for("/admin/index.php" . h(u($admin_id)) ));
}

if (is_post_request()) {
	$user = [];
	$user['access'] = $_POST['access'];
	$user['first_name'] = $_POST['first_name'] ?? "";
	$user['last_name'] = $_POST['last_name'] ?? "";
	$user['username'] = $_POST['username'] ?? "";
	$user['password'] = $_POST['password'] ?? "";
	$user['confirm_password'] = $_POST['confirm_password'] ?? "";

	$result = insert_user2($user);
	if ($result === true) {
		redirect_to(url_for("/admin/users/index.php?id=" . h(u($admin['id']))));
	} else {
		$errors = $result;
	}
} else {
	$user = [];
	$user['access'] = "";
	$user['first_name'] = "";
	$user['last_name'] = "";
	$user['username'] = "";
	$user['password'] = "";
	$user['confirm_password'] = "";
}

?>
<?php include(SHARED_PATH . "/user_header.php"); ?>
<div id="content">
	<div class="sign_up_form">
		<a href="<?php echo url_for("/admin/users/index.php?id=" . h(u($admin['id']))); ?>">&laquo; Back to User list</a>
		<h1>Admin: <?php echo h(u($admin['username'])); ?></h1>
		<h1>Create User</h1>
		<?php echo display_errors($errors); ?>
		<form action="<?php echo url_for("/admin/users/new.php?id=" . h(u($admin_id))); ?>" method="post">
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
			<dl>
			<dt>Administrator privileges</dt>
				<dd>
					<input type="hidden" name="access" value="0" />
					<input type="checkbox" name="access" value="1"<?php
					if ($user['access'] == "1") { echo " checked"; } ?> />
				</dd>
			</dl>
			<div>
				<input type="submit" value="Create User" />
			</div>
		</form>
	</div>
</div>
<?php include(SHARED_PATH . "/user_footer.php"); ?>