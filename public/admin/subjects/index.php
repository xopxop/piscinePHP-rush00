<?php require_once("../../../private/initialize.php"); ?>
<?php require_login(); ?>
<?php

if (!isset($_GET['id'])) {
	redirect_to(url_for("/user/index.php"));
}
$id = $_GET['id'];
$admin = find_user_by_id($id);
require_admin($admin);

?>
<?php $page_title = "Admin - Subjects" ?>

<?php

$subject_set = find_all_subjects();

?>
<?php include(SHARED_PATH . "/user_header.php"); ?>
<div id="content">
	<div class="admin_subjects">
		<a href="<?php echo url_for("/admin/index.php?id=" . h(u($admin['id']))); ?>" >&laquo; Back to Admin Section</a>
		<h1>Admin: <?php echo h(u($admin['username'])); ?></h1>
		<a href="<?php echo url_for("/admin/subjects/new.php"); ?>">Create New Subject</a>
		<table class="list">
			<tr>
				<th>ID</th>
				<th>Category Name</th>
				<th>Position</th>
				<th>Items</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
			</tr>
			<?php while($subject = mysqli_fetch_assoc($subject_set)) { 
				$item_count = count_items_by_subject_id($subject['id']);	
			?>
				<tr>
					<td><?php echo h($subject['id']); ?></td>
					<td><?php echo h($subject['category_name']); ?></td>
					<td><?php echo h($subject['position']); ?></td>
					<td><?php echo h($item_count); ?></td>
					<td><a href="<?php echo url_for('/admin/subjects/show.php?id=' .
					h(u($subject['id']))); ?>">View</a></td>
					<td><a href="<?php echo url_for('/admin/subjects/edit.php?id=' .
					h(u($subject['id']))); ?>">Edit</a></td>
					<td><a href="<?php echo url_for('/admin/subjects/delete.php?id=' .
					h(u($subject['id']))); ?>">Delete</a></td>
				</tr>
			<?php } ?>
		</table>
	</div>
</div>
<?php include(SHARED_PATH . "/user_footer.php"); ?>