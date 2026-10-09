<?php require_once("../../../private/initialize.php"); ?>
<?php require_login(); ?>
<?php

$admin = find_user_by_id($_SESSION['user_id']);
require_admin($admin);

?>
<?php $page_title = "Admin - Item New" ?>
<?php

if (is_post_request()) {
	$item = [];
	$item['subject_id'] = $_POST['subject_id'];
	$item['item_name'] = $_POST['item_name'];
	$item['position'] = $_POST['position'];
	$item['price'] = $_POST['price'];
	$item['image'] = $_POST['image'];

	$result = insert_item($item);
	if ($result === true) {
		$new_id = mysqli_insert_id($db);
		redirect_to(url_for("/admin/items/show.php?id=" . $new_id));
	} else {
		$errors = $result;
	}
} else {
	$item = [];
	$item['subject_id'] = $_GET['subject_id'] ?? '1';
	$item['item_name'] = '';
	$item['position'] = '';
	$item['price'] = '0';
	$item['image'] = '';
}

$item_count = count_items_by_subject_id($item['subject_id']) + 1;

?>



<?php

?>
<?php include(SHARED_PATH . "/user_header.php"); ?>
<div id="content">
	<div class="admin_items_new">
		<a href="<?php echo url_for("/admin/subjects/show.php?id=" . h(u($item['subject_id']))); ?>" >&laquo; Back to Item list</a>
		<h1>Admin: <?php echo h(u($admin['username'])); ?></h1>
		<h2>Create Item</h2>
		<?php echo display_errors($errors); ?>
		<form action="<?php echo url_for("/admin/items/new.php?id=" . h(u($item['subject_id']))); ?>" method="post">
			<dl>
				<dt>Category</dt>
				<dd>
					<select name="subject_id">
						<?php
							$subject_set = find_all_subjects();
							while($subject = mysqli_fetch_assoc($subject_set)) {
								echo "<option value=\"". h($subject['id']) . "\"";
								if($item["subject_id"] == $subject['id']) {
									echo " selected";
								}
								echo ">" . h($subject['category_name']) . "</option>";
							}
							mysqli_free_result($subject_set);
						?>
					</select>
				</dd>
			</dl>
			<dl>
				<dt>Item Name</dt>
				<dd><input type="text" name="item_name" value="<?php echo h($item['item_name']); ?>" /></dd>
			</dl>
			<dl>
				<dt>Position</dt>
				<dd>
					<select name="position">
						<?php
							for($i=1; $i <= $item_count; $i++) {
								echo "<option value=\"{$i}\"";
								if ($item["position"] == $i) {
									echo " selected";
								}
								echo ">{$i}</option>";
							}
						?>
					</select>
				</dd>
			</dl>
			<dl>
				<dt>Price (in $)</dt>
				<dd>
					<input type="number" name="price" value="<?php echo h($item['price']); ?>" min="1" max="200" />
				</dd>
			</dl>
			<dl>
				<dt>Image</dt>
				<dd>
					<textarea name="image" cols="60" rows="5"><?php echo h($item['image']); ?></textarea>
				</dd>
			</dl>
			<div">
				<input type="submit" value="Create Item" />
			</div>
		</form>
	</div>
</div>
<?php include(SHARED_PATH . "/user_footer.php"); ?>