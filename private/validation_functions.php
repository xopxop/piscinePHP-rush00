<?php

function is_blank($value) {
	return (!isset($value) || trim($value) === "");
}

function is_presence($value) {
	return !is_blank($value);
}

function has_length_greater_than($value, $min) {
	$length = strlen($value);
	return $length > $min;
}

function has_length_less_than($value, $max) {
	$length = strlen($value);
	return $length < $max;
}

function has_length_exactly($value, $exact) {
	$length = strlen($value);
	return $length == $exact;
}

function has_length($value, $options) {
	if (isset($options['min']) && !has_length_greater_than($value, $options['min'] - 1)) {
		return false;
	} else if (isset($options['max']) && !has_length_less_than($value, $options['max'] + 1)) {
		return false;
	} else if (isset($options['exact']) && !has_length_exactly($value, $options['exact'])) {
		return false;
	}
	return true;
}

function has_unique_username($username, $current_id="0") {
	global $db;

	$sql = "SELECT * FROM users ";
	$sql .= "WHERE username='" . db_escape($db, $username) . "' ";
	$sql .= "AND id != '" . db_escape($db, $current_id) . "'";

	$result = mysqli_query($db, $sql);
	$user_count = mysqli_num_rows($result);
	mysqli_free_result($result);
	return $user_count === 0;
}

?>