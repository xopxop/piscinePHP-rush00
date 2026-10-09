<?php require_once("../../../private/initialize.php"); ?>
<?php require_login(); ?>
<?php

$admin_id = $_SESSION['user_id'];
$admin = find_user_by_id($admin_id);
require_admin($admin);

?>
<?php $page_title = "Admin - Subject Edit" ?>

<?php

if (!isset($_GET['id'])) {
	redirect_to(url_for("/admin/index.php" . h(u($admin_id)) ));
}
$subject_id = $_GET['id'];
if (is_post_request()) {
	$subject = [];
	$subject['id'] = $subject_id;
	$subject['category_name'] = $_POST['category_name'] ?? '';
	$subject['position'] = $_POST['position'] ?? '';

	$result = update_subject($subject);
	if ($result === true) {
		redirect_to(url_for("/admin/subjects/show.php?id=" . $subject_id));
	} else {
		$errors = $result;
	}
}

$subject = find_subject_by_id($subject_id);
$subject_set = find_all_subjects();
$subject_count = mysqli_num_rows($subject_set);
mysqli_free_result($subject_set);

?>
<?php include(SHARED_PATH . "/user_header.php"); ?>
<div id="content">
	<div class="admin_subjects_edit">
		<a href="<?php echo url_for("/admin/subjects/index.php?id=" . h(u($admin['id']))); ?>" >&laquo; Back to Subject list</a>
		<h1>Admin: <?php echo h(u($admin['username'])); ?></h1>
		<h2>Edit Subject: <?php echo $subject['category_name']; ?></h2>
		<?php echo display_errors($errors); ?>
		<form action="<?php echo url_for("/admin/subjects/edit.php?id=" . h(u($subject_id))); ?>" method="post">
			<dl>
				<dt>Category Name</dt>
				<dd><input type="text" name="category_name" value="<?php echo
				h($subject['category_name']); ?>" /></dd>
			</dl>
			<dl>
				<dt>Position</dt>
				<dd>
					<select name="position">
						<?php
							for($i = 1; $i <= $subject_count; $i++) {
								echo "<option value=\"{$i}\"";
								if ($subject["position"] == $i) {
									echo " selected";
								}
								echo ">{$i}</option>";
							}
						?>
					</select>
				</dd>
			</dl>
			<div">
				<input type="submit" value="Edit Subject" />
			</div>
		</form>
	</div>
</div>
<?php include(SHARED_PATH . "/user_footer.php"); ?>