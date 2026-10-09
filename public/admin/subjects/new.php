<?php require_once("../../../private/initialize.php"); ?>
<?php require_login(); ?>
<?php

$admin = find_user_by_id($_SESSION['user_id']);
require_admin($admin);

?>
<?php $page_title = "Admin - Subject New" ?>
<?php

if (is_post_request()) {
	$subject = [];
	$subject['category_name'] = $_POST['category_name'] ?? '';
	$subject['position'] = $_POST['position'] ?? '';

	$result = insert_subject($subject);
	if ($result === true) {
		$new_id = mysqli_insert_id($db);
		redirect_to(url_for('/admin/subjects/show.php?id=' . $new_id));
	} else {
		$errors = $result;
	}
}

$subject_set = find_all_subjects();
$subject_count = mysqli_num_rows($subject_set) + 1;
mysqli_free_result($subject_set);

$subject = [];
$subject['position'] = $subject_count;

?>
<?php include(SHARED_PATH . "/user_header.php"); ?>
<div id="content">
	<div class="admin_subjects_new">
		<a href="<?php echo url_for("/admin/subjects/index.php?id=" . h(u($admin['id']))); ?>" >&laquo; Back to Subject list</a>
		<h1>Admin: <?php echo h(u($admin['username'])); ?></h1>
		<h2>Create Subject</h2>
		<?php echo display_errors($errors); ?>
		<form action="<?php echo url_for("/admin/subjects/new.php"); ?>" method="post">
			<dl>
				<dt>Category Name</dt>
				<dd><input type="text" name="category_name" value="" /></dd>
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
				<input type="submit" value="Create Subject" />
			</div>
		</form>
	</div>
</div>
<?php include(SHARED_PATH . "/user_footer.php"); ?>