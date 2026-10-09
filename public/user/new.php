<?php require_once("../../private/initialize.php"); ?>
<?php require_not_login(); ?>
<?php $page_title = "User - Sign Up"; ?>
<?php

if (is_post_request()) {
	$user = [];
	$user['first_name'] = $_POST['first_name'] ?? "";
	$user['last_name'] = $_POST['last_name'] ?? "";
	$user['username'] = $_POST['username'] ?? "";
	$user['password'] = $_POST['password'] ?? "";
	$user['confirm_password'] = $_POST['confirm_password'] ?? "";

	$result = insert_user($user);
	if ($result === true) {
		$new_id = mysqli_insert_id($db);
		log_in_user(find_user_by_id($new_id));
		redirect_to(url_for("index.php"));
	} else {
		$errors = $result;
	}
} else {
	$user = [];
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
			<?php echo display_errors($errors); ?>
			<h1>Sign Up</h1>
			<form action="<?php echo url_for("/user/new.php"); ?>" method="post">
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
				<div>
					<input type="submit" value="Sign Up" />
				</div>
			</form>
		</div>
</div>
<?php include(SHARED_PATH . "/user_footer.php"); ?>