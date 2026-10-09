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
<?php $page_title = "Admin - Users" ?>
<?php

$user_set = find_all_users();

?>
<?php include(SHARED_PATH . "/user_header.php"); ?>
<div id="content">
	<div class="admin_user_listing">
		<a href="<?php echo url_for("/admin/index.php?id=" . h(u($admin['id']))); ?>" >&laquo; Back to Admin Section</a>
		<h1>Admin: <?php echo h(u($admin['username'])); ?></h1>
		<a href="<?php echo url_for("/admin/users/new.php?id=" . h(u($admin['id']))); ?>">Create New User</a>
		<table class="list">
			<tr>
				<th>ID</th>
				<th>Admin</th>
				<th>First</th>
				<th>Last</th>
				<th>Username</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
			</tr>
			<?php while($user = mysqli_fetch_assoc($user_set)) { ?>
			<tr>
				<td><?php echo h($user['id']); ?></td>
				<td><?php echo $user['access'] == "1" ? "Admin" : "User"; ?></td>
				<td><?php echo h($user['first_name']); ?></td>
				<td><?php echo h($user['last_name']); ?></td>
				<td><?php echo h($user['username']); ?></td>
				<td><a class="action" href="<?php echo url_for('/admin/users/edit.php?id=' .
				h(u($user['id']))); ?>">Edit</a></td>
				<td><a class="action" href="<?php echo url_for('/admin/users/delete.php?id=' .
				h(u($user['id']))); ?>">Delete</a></td>
			</tr>
			<?php } ?>
		</table>
	</div>
</div>
<?php include(SHARED_PATH . "/user_footer.php"); ?>