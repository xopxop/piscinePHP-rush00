<?php require_once("../private/initialize.php"); ?>
<?php require_not_login() ?>
<?php $page_title = "Login..."; ?>
<?php

if (is_post_request()) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	if (is_blank($username)) {
		$errors[] = "Username cannot be blank";
	}
	if (is_blank($password)) {
		$errors[] = "Password cannot be blank";
	}
	if (empty($errors)) {
		$login_failure_messge = "Log in was unsuccessful!";
		$user = find_user_by_username($username);
		if ($user) {
			if (password_verify($password, $user['hashed_password'])) {
				log_in_user($user);
				redirect_to(url_for("index.php"));
			} else {
				$errors[] = $login_failure_messge;
			}
		} else {
			$errors[] = $login_failure_messge;
		}
	}
} else {
	$username = "";
	$password = "";
}

?>
<?php include(SHARED_PATH . "/user_header.php"); ?>
<div id="content">
	<?php echo display_errors($errors); ?>
	<div class="login_form">
		<h1>Log In</h1>
		<form action="<?php echo url_for("login.php"); ?>" method="post">
			<dl>
				<dt>Username</dt>
				<dd><input type="text" name="username" value="" placeholder="Username" /></dd>
			</dl>
			<dl>
			<dt>Password</dt>
				<dd><input type="password" name="password" value=""  placeholder="Password" /></dd>
			</dl>
			<div>
				<input type="submit" value="Submit" />
			</div>
		</form>
	</div>
	<div class="sign_up">
		<a href="<?php echo url_for("/user/new.php"); ?>" >Sign Up</a>
	</div>
</div>
<?php include(SHARED_PATH . "/user_footer.php"); ?>