<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/homepage.css'); ?>" />
		<title><?php echo h($page_title); ?></title>
	</head>
	<body>
		<header>
			<nav>
				<a href="<?php echo url_for("index.php"); ?>">
					<img class="logo" src="<?php echo url_for("/images/logo.png"); ?>" />
				</a>
				<ul>
					<li><a href="<?php echo url_for("index.php"); ?>">All Product</a>
						<ul>
							<?php while ($subject = mysqli_fetch_assoc($subject_set)) { ?>
								<li><a href="<?php echo url_for("index.php?subject_id=" . h(u($subject['id']))); ?>"><?php echo $subject['category_name']; ?></a></li>
							<?php } ?>
						</ul>
					</li>
					<?php if (is_logged_in()) { ?>
						<li><a href="<?php echo url_for("/user/index.php?id=" . h(u($_SESSION['user_id']))); ?>" >Setting</a>
							<ul>
								<li><a href="<?php echo url_for("/basket/order.php"); ?>">Order</a></li>
								<li><a href="<?php echo url_for("logout.php"); ?>">Logout</a></li>
							</ul>
						</li>
					<?php } else { ?>
						<li><a href="<?php echo url_for("login.php"); ?>">Login</a></li>
					<?php } ?>
					<li><a href="<?php echo url_for("/basket/index.php") ?>">Basket</a></li>
				</ul>
			</nav>
		</header>
		