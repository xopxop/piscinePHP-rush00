<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/user.css'); ?>" />
		<link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/admin.css'); ?>" />
		<title><?php echo h($page_title); ?></title>
	</head>
	<body>
		<header>
			<a href="<?php echo url_for("index.php"); ?>">
				<img class="logo" src="<?php echo url_for("/images/logo.png"); ?>" />
			</a>
		</header>