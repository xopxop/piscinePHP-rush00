<?php require_once("../private/initialize.php"); ?>
<?php $page_title = "Nice-Shop"; ?>
<?php

$subject_set = find_all_subjects();

if (is_post_request()) {
	if (isset($_POST['add_to_cart'])) {
		$id = $_POST['id'];
		if (isset($_SESSION['shopping_cart'][$id])) {
			$_SESSION['shopping_cart'][$id] += $_POST['quantity'];
		} else {
			$_SESSION['shopping_cart'][$id] = $_POST['quantity'];
		}
	}
}

?>
<?php include(SHARED_PATH . "/homepage_header.php"); ?>
<?php

if (isset($_GET['id'])) {
	$item_id = $_GET['id'];
	$item = find_item_by_id($item_id);
	if (!$item) {
		redirect_to(url_for("index.php"));
	}
} else if (isset($_GET['subject_id'])) {
	$subject_id = $_GET['subject_id'];
	$subject = find_subject_by_id($subject_id);
	if (!$subject) {
		redirect_to(url_for("index.php"));
	}
	$item_set = find_items_by_subject_id($subject_id);
} else {
	$item_set = find_all_items();
}

?>
<div id="content">
	<div class="items">
		<?php if (isset($item)) {
			include(PUBLIC_PATH . "/show_item.php");
		} else {
		?>
		<?php while($item = mysqli_fetch_assoc($item_set)) {
			include(PUBLIC_PATH . "/show_item.php");
		} ?>
		<?php mysqli_free_result($item_set); }?>
	</div>
</div>
<?php include(SHARED_PATH . "/homepage_footer.php"); ?>