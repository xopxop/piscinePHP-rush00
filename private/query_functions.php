<?php

/* subject */

function find_all_subjects() {
	global $db;
	
	$sql = "SELECT * FROM subjects ";
	$sql .= "ORDER BY position ASC;";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

function find_subject_by_id($id) {
	global $db;
	
	$sql = "SELECT * FROM subjects ";
	$sql .= "WHERE id='" . db_escape($db, $id) . "'";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	$subject = mysqli_fetch_assoc($result);
	mysqli_free_result($result);
	return $subject;
}

function validate_subject($subject) {
	$errors = [];

	if (is_blank($subject['category_name'])) {
		$errors[] = "Category name cannot be blank.";
	} else if (!has_length($subject['category_name'], ['min' => 2, 'max' => 255])) {
		$errors[] = "Category name must be between 2 and 255 characters.";
	}

	$position_int = (int) $subject['position'];
	if ($position_int <= 0) {
		$errors[] = "Position must be greater than zero.";
	}
	else if ($position_int > 999) {
		$errors[] = "Position must be less than 999.";
	}

	return $errors;
}

function shift_subject_position($start_pos, $end_pos, $current_id=0) {
	global $db;

	if($start_pos == $end_pos) {
		return;
	}

	$sql = "UPDATE subjects ";
	if ($start_pos == 0) {
		$sql .= "SET position = position + 1 ";
		$sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
	} else if ($end_pos == 0) {
		$sql .= "SET position = position - 1 ";
		$sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
	} else if ($start_pos < $end_pos) {
		$sql .= "SET position = position - 1 ";
		$sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
		$sql .= "AND position <= '" . db_escape($db, $end_pos) . "' ";
	} else if ($start_pos > $end_pos) {
		$sql .= "SET position = position + 1 ";
		$sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
		$sql .= "AND position < '" . db_escape($db, $start_pos) . "' ";
	}
	$sql .= "AND id != '" . db_escape($db, $current_id) . "' ";
	$result = mysqli_query($db, $sql);
	if ($result) {
		return true;
	} else {
		echo msqli_error($db);
		db_disconnect($db);
		exit;
	}
}

function insert_subject($subject) {
	global $db;

	$errors = validate_subject($subject);
	if(!empty($errors)) {
		return $errors;
	}

	shift_subject_position(0, $subject['position']);

	$sql = "INSERT INTO subjects ";
	$sql .= "(category_name, position) ";
	$sql .= "VALUES (";
	$sql .= "'" . db_escape($db, $subject['category_name']) . "',";
	$sql .= "'" . db_escape($db, $subject['position']) . "'";
	$sql .= ")";
	$result = mysqli_query($db, $sql);
	if ($result) {
		return true;
	} else {
		echo mysqli_error($db);
		db_disconnect($db);
		exit();
	}
}

function update_subject($subject) {
	global $db;

	$errors = validate_subject($subject);
	if(!empty($errors)) {
		return $errors;
	}

	$old_subject = find_subject_by_id($subject['id']);
	$old_position = $old_subject['position'];
	shift_subject_position($old_position, $subject['position'], $subject['id']);

	$sql = "UPDATE subjects SET ";
	$sql .= "category_name='" . db_escape($db, $subject['category_name']) . "', ";
	$sql .= "position='" . db_escape($db, $subject['position']) . "' ";
	$sql .= "WHERE id='" . db_escape($db, $subject['id']) . "' ";
	$sql .= "LIMIT 1";

	$result = mysqli_query($db, $sql);
	if ($result) {
		return (true);
	} else {
		echo mysqli_error($db);
		db_disconnect($db);
		exit();
	}
}

function delete_subject($id) {
	global $db;

	$old_subject = find_subject_by_id($id);
	$old_position = $old_subject['position'];
	shift_subject_position($old_position, 0, $id);

	$sql = "DELETE FROM subjects ";
	$sql .= "WHERE id='" . db_escape($db, $id) . "' ";
	$sql .= "LIMIT 1";
	$result = mysqli_query($db, $sql);
	if ($result)
		return true;
	else {
		echo mysqli_error($db);
		db_disconnect($db);
		exit();
	}
}

/* item */

function find_item_by_order_id($order_id) {
	global $db;
	
	$sql = "SELECT * FROM orderred_items ";
	$sql .= "WHERE order_id='" . db_escape($db, $order_id) . "' ";
	$sql .= "ORDER BY id ASC;";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

function find_all_items() {
	global $db;
	
	$sql = "SELECT * FROM items ";
	$sql .= "ORDER BY subject_id ASC, position ASC;";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

function find_item_by_id($id) {
	global $db;

	$sql = "SELECT * FROM items ";
	$sql .= "WHERE id='" . db_escape($db, $id) . "'";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	$item = mysqli_fetch_assoc($result);
	mysqli_free_result($result);
	return $item;
}

function find_items_by_subject_id($subject_id) {
	global $db;

	$sql = "SELECT * FROM items ";
	$sql .= "WHERE subject_id='" . db_escape($db, $subject_id) . "' ";
	$sql .= "ORDER BY position ASC";
	$result = mysqli_query($db, $sql);
	return $result;
}

function count_items_by_subject_id($subject_id) {
	global $db;

	$sql = "SELECT COUNT(id) FROM items ";
	$sql .= "WHERE subject_id='" . db_escape($db, $subject_id) . "' ";
	$sql .= "ORDER BY position ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	$row = mysqli_fetch_row($result);
	mysqli_free_result($result);
	$count = $row[0];
	return $count;
}


function shift_item_position($start_pos, $end_pos, $subject_id, $current_id=0) {
	global $db;

	if($start_pos == $end_pos) {
		return;
	}

	$sql = "UPDATE items ";
	if($start_pos == 0) {
		$sql .= "SET position = position + 1 ";
		$sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
	} else if ($end_pos == 0) {
		$sql .= "SET position = position - 1 ";
		$sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
	} else if($start_pos < $end_pos) {
		$sql .= "SET position = position - 1 ";
		$sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
		$sql .= "AND position <= '" . db_escape($db, $end_pos) . "' ";
	} else if($start_pos > $end_pos) {
		$sql .= "SET position = position + 1 ";
		$sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
		$sql .= "AND position < '" . db_escape($db, $start_pos) . "' ";
	}
	$sql .= "AND id != '" . db_escape($db, $current_id) . "' ";
	$sql .= "AND subject_id = '" . db_escape($db, $subject_id) . "'";

	$result = mysqli_query($db, $sql);
	if($result) {
		return true;
	} else {
		echo mysqli_error($db);
		db_disconnect($db);
		exit;
	}
}

function delete_item($id) {
	global $db;

	$old_item = find_item_by_id($id);
	$old_position = $old_item['position'];
	shift_item_position($old_position, 0, $old_item['subject_id'], $id);

	$sql = "DELETE FROM items ";
	$sql .= "WHERE id='" . db_escape($db, $id) . "' ";
	$sql .= "LIMIT 1";
	$result = mysqli_query($db, $sql);
	if ($result)
		return true;
	else {
		echo mysqli_error($db);
		db_disconnect($db);
		exit();
	}
}

function validate_item($item) {
	$errors = [];

	//item_name
	if (is_blank($item['item_name'])) {
		$errors[] = "Item name cannot be blank.";
	} else if (!has_length($item['item_name'], ['min' => 2, 'max' => 255])) {
		$errors[] = "Item name must be between 2 and 255 characters.";
	}
	// image
	if(is_blank($item['image'])) {
		$errors[] = "Link to image cannot be blank.";
	}

	return $errors;
}

function update_item($item) {
	global $db;

	$errors = validate_item($item);
	if(!empty($errors)) {
		return $errors;
	}

	$sql = "UPDATE items SET ";
	$sql .= "item_name='" . db_escape($db, $item['item_name']) . "', ";
	$sql .= "price='" . db_escape($db, $item['price']) . "', ";
	$sql .= "image='" . db_escape($db, $item['image']) . "' ";
	$sql .= "WHERE id='" . db_escape($db, $item['id']) . "' ";
	$sql .= "LIMIT 1";

	$result = mysqli_query($db, $sql);
	if ($result) {
		return (true);
	} else {
		echo mysqli_error($db);
		db_disconnect($db);
		exit();
	}
}

function insert_item($item) {
	global $db;

	$errors = validate_item($item);
	if(!empty($errors)) {
		return $errors;
	}

	$sql = "INSERT INTO items ";
	$sql .= "(subject_id, item_name, position, price, image) ";
	$sql .= "VALUES (";
	$sql .= "'" . db_escape($db, $item['subject_id']) . "', ";
	$sql .= "'" . db_escape($db, $item['item_name']) . "',";
	$sql .= "'" . db_escape($db, $item['position']) . "',";
	$sql .= "'" . db_escape($db, $item['price']) . "', ";
	$sql .= "'" . db_escape($db, $item['image']) . "'";
	$sql .= ")";
	$result = mysqli_query($db, $sql);
	if ($result) {
		return true;
	} else {
		echo mysqli_error($db);
		db_disconnect($db);
		exit();
	}
}

/* user */

function find_all_users() {
	global $db;
	
	$sql = "SELECT * FROM users ORDER BY id ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

function find_user_by_username($username) {
	global $db;

	$sql = "SELECT * FROM users ";
	$sql .= "WHERE username='" . db_escape($db, $username) . "' ";
	$sql .= "LIMIT 1";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	$user = mysqli_fetch_assoc($result);
	mysqli_free_result($result);
	return $user;
}

function find_user_by_id($id) {
	global $db;

	$sql = "SELECT * FROM users ";
	$sql .= "WHERE id='" . db_escape($db, $id) . "' ";
	$sql .= "LIMIT 1";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	$user = mysqli_fetch_assoc($result);
	mysqli_free_result($result);
	return $user;
}

function validate_user($user, $options=[]) {
	$errors = [];

	$password_required = $options['password_required'] ?? true;
	$username_required = $options['username_required'] ?? true;
	if (is_blank($user['first_name'])) {
		$errors[] = "First name cannot be blank.";
	}
	else if (!has_length($user['first_name'], array('min' => 2, 'max' => 255))) {
		$errors[] = "First name must be between 2 and 255 characters.";
	}

	if (is_blank($user['last_name'])) {
		$errors[] = "Last name cannot be blank.";
	}
	else if (!has_length($user['last_name'], array('min' => 2, 'max' => 255))) {
		$errors[] = "Last name must be between 2 and 255 characters.";
	}

	if ($username_required) {
		if (is_blank($user['username'])) {
			$errors[] = "Username cannot be blank.";
		} else if (!has_length($user['username'], array('min' => 2, 'max' => 255))) {
			$errors[] = "Username must be between 2 and 255 characters.";
		} else if (!has_unique_username($user['username'], $user['id'] ?? 0)) {
			$errors[] = "Username not allowed. Try another.";
		}
	}

	if ($password_required) {
		if (is_blank($user['password'])) {
			$errors[] = "Password cannot be blank.";
		} else if (!has_length($user['password'], array('min' => 4, 'max' => 255))) {
			$errors[] = "Password must be between 4 and 255 characters.";
		}
		if (is_blank($user['confirm_password'])) {
			$errors[] = "Confirm password cannot be blank.";
		} else if ($user['password'] !== $user['confirm_password']) {
			$errors[] = "Password and confirm password must match.";
		}
	}
	
	return $errors;
}

function insert_user($user) {
	global $db;

	$errors = validate_user($user, array('username_required' => true));
	if (!empty($errors)) {
		return $errors;
	}

	$hashed_password = password_hash($user['password'], PASSWORD_BCRYPT);
	$sql = "INSERT INTO users ";
	$sql .= "(access, first_name, last_name, username, hashed_password) ";
	$sql .= "VALUES (";
	$sql .= "FALSE, ";
	$sql .= "'" . db_escape($db, $user['first_name']) . "', ";
	$sql .= "'" . db_escape($db, $user['last_name']) . "', ";
	$sql .= "'" . db_escape($db, $user['username']) . "', ";
	$sql .= "'" . db_escape($db, $hashed_password) . "'";
	$sql .= ")";
	$result = mysqli_query($db, $sql);
	if (!$result) {
		echo mysqli_error($db);
		db_disconnect($db);
		exit();
	}
	return true;
}

function insert_user2($user) {
	global $db;

	$errors = validate_user($user, array('username_required' => true));
	if (!empty($errors)) {
		return $errors;
	}

	$hashed_password = password_hash($user['password'], PASSWORD_BCRYPT);
	$sql = "INSERT INTO users ";
	$sql .= "(access, first_name, last_name, username, hashed_password) ";
	$sql .= "VALUES (";
	$sql .= "'" . db_escape($db, $user['access']) . "', ";
	$sql .= "'" . db_escape($db, $user['first_name']) . "', ";
	$sql .= "'" . db_escape($db, $user['last_name']) . "', ";
	$sql .= "'" . db_escape($db, $user['username']) . "', ";
	$sql .= "'" . db_escape($db, $hashed_password) . "'";
	$sql .= ")";
	$result = mysqli_query($db, $sql);
	if (!$result) {
		echo mysqli_error($db);
		db_disconnect($db);
		exit();
	}
	return true;
}

function update_user($user) {
	global $db;

	$password_sent = !is_blank($user['password']);
	$username_sent = !is_blank($user['username']);
	$errors = validate_user($user, array('password_required' => $password_sent, 'username_required' => $username_sent));
	if(!empty($errors)) {
		return $errors;
	}
	if (isset($user['access'])) {
		$access = $user['access'] === "1" ? 1 : 0;
	} else {
		$access = 0;
	}
	$hashed_password = password_hash($user['password'], PASSWORD_BCRYPT);
	$sql = "UPDATE users SET ";
	$sql .= "first_name='" . db_escape($db, $user['first_name']) . "', ";
	if ($password_sent) {
		$sql .= "hashed_password='" . db_escape($db, $hashed_password) . "', ";
	}
	if ($username_sent) {
		$sql .= "username='" . db_escape($db, $user['username']) . "', ";
	}
	$sql .= "access='" . $access . "', ";
	$sql .= "last_name='" . db_escape($db, $user['last_name']) . "' ";
	$sql .= "WHERE id='" . db_escape($db, $user['id']) . "' ";
	$sql .= "LIMIT 1";

	$result = mysqli_query($db, $sql);
	if ($result) {
		return (true);
	} else {
		echo mysqli_error($db);
		db_disconnect($db);
		exit();
	}
}

function delete_user($user) {
	global $db;

	$sql = "DELETE FROM users ";
	$sql .= "WHERE id='" . db_escape($db, $user['id']) . "' ";
	$sql .= "LIMIT 1";
	$result = mysqli_query($db, $sql);
	if ($result)
		return true;
	else {
		echo mysqli_error($db);
		db_disconnect($db);
		exit();
	}
}

/* order */
function insert_order($order) {
	global $db;

	$sql = "INSERT INTO orders ";
	$sql .= "(user_id, date, total_quantity, total_price) ";
	$sql .= "VALUES (";
	$sql .= "'" . db_escape($db, $order['user_id']) . "',";
	$sql .= "'" . db_escape($db, $order['date']) . "',";
	$sql .= "'" . db_escape($db, $order['total_quantity']) . "',";
	$sql .= "'" . db_escape($db, $order['total_price']) . "'";
	$sql .= ")";
	$result = mysqli_query($db, $sql);
	if (!$result) {
		echo mysqli_error($db);
		db_disconnect($db);
		exit();
	}
	return true;
}

/* order item */

function find_all_orders() {
	global $db;
	
	$sql = "SELECT * FROM orders ORDER BY id ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

function insert_orderred_item($orderred_item) {
	global $db;

	$sql = "INSERT INTO orderred_items ";
	$sql .= "(item_id, order_id, quantity, price) ";
	$sql .= "VALUES (";
	$sql .= "'" . db_escape($db, $orderred_item['item_id']) . "', ";
	$sql .= "'" . db_escape($db, $orderred_item['order_id']) . "', ";
	$sql .= "'" . db_escape($db, $orderred_item['quantity']) . "', ";
	$sql .= "'" . db_escape($db, $orderred_item['price']) . "'";
	$sql .= ")";
	$result = mysqli_query($db, $sql);
	if (!$result) {
		echo mysqli_error($db);
		db_disconnect($db);
		exit();
	}
	return true;
}

function find_orders_by_user_id($user_id) {
	global $db;

	$sql = "SELECT * FROM orders ";
	$sql .= "WHERE user_id='" . db_escape($db, $user_id) . "'";
	$result = mysqli_query($db, $sql);
	return $result;
}

?>