<?php

function log_in_user($user) {
	session_regenerate_id();
	$_SESSION['user_id'] = $user['id'];
	$_SESSION['last_login'] = time();
	$_SESSION['username'] = $user['username'];
}

function log_out_user() {
	unset($_SESSION['user_id']);
	unset($_SESSION['last_login']);
	unset($_SESSION['username']);
	if (isset($_SESSION['shopping_cart'])) {
		unset($_SESSION['shopping_cart']);
	}
	if (isset($_SESSION['order'])) {
		unset($_SESSION['order']);
	}
	return true;
}

function is_logged_in() {
	return isset($_SESSION['user_id']);
}

function require_login() {
	if (!is_logged_in()) {
		redirect_to(url_for("index.php"));
	}
}

function require_not_login() {
	if (is_logged_in()) {
		redirect_to(url_for("index.php"));
	}
}

function require_admin($user) {
	if ($user['access'] !== "1") {
		redirect_to(url_for("/user/index.php?id=" . h(u($user['id']))));
	}
}

?>