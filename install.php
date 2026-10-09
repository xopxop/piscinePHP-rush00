<?php

require_once("private/database.php");
require_once("private/functions.php");

function database_already_exists() {
	$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	if ($connection) {
		db_disconnect($connection);
		return true;
	}
	return false;
}

function create_database() {
	$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);
	confirm_connection();
	$sql = "CREATE DATABASE " . DB_NAME;
	$result = mysqli_query($connection, $sql);
	if (!$result) {
		$msg = "Database creation failed!" . PHP_EOL;
		exit($msg);
	}
	db_disconnect($connection);
	$db = db_connect();
	confirm_connection();
	return $db;
}

function create_items_table() {
	global $db;

	$sql = "CREATE TABLE items (";
	$sql .= "id INT NOT NULL AUTO_INCREMENT,";
	$sql .= "subject_id INT,";
	$sql .= "item_name VARCHAR(255),";
	$sql .= "position INT,";
	$sql .= "price FLOAT,";
	$sql .= "image VARCHAR(255),";
	$sql .= "PRIMARY KEY (id)";
	$sql .= ")";
	$result = mysqli_query($db, $sql);
	if (!$result) {
		$msg = "Items table creation failed!";
		exit($msg);
	}
}

function fill_default_values_into_items_table() {
	global $db;

	$items = array(
		array('subject_id' => 1, 'item_name' => 'acoustic-guitar', 'position' => 1, 'price' => '1.00', 'image' => 'https://cdn.pixabay.com/photo/2015/12/11/01/23/painted-guitar-1087209_960_720.jpg'),
		array('subject_id' => 1, 'item_name' => 'acoustic-guitar', 'position' => 2, 'price' => '2.00', 'image' => 'https://cdn.pixabay.com/photo/2014/10/13/17/49/acoustic-guitar-487035_960_720.jpg'),
		array('subject_id' => 1, 'item_name' => 'acoustic-guitar', 'position' => 3, 'price' => '3.00', 'image' => 'https://cdn.pixabay.com/photo/2020/05/24/16/18/painted-guitar-5214933_960_720.jpg'),
		array('subject_id' => 1, 'item_name' => 'ukulele', 'position' => 4, 'price' => '4.00', 'image' => 'https://cdn.pixabay.com/photo/2016/08/13/17/41/ukulele-1591161_960_720.jpg'),
		array('subject_id' => 2, 'item_name' => 'black electric bass', 'position' => 5, 'price' => '5.00', 'image' => 'https://cdn.pixabay.com/photo/2020/04/13/09/42/acoustic-5037520_960_720.jpg'),
		array('subject_id' => 2, 'item_name' => 'electric bass', 'position' => 6, 'price' => '6.00', 'image' => 'https://cdn.pixabay.com/photo/2020/02/19/13/12/acoustic-4862173_960_720.jpg'),
		array('subject_id' => 2, 'item_name' => 'electric bass', 'position' => 7, 'price' => '7.00', 'image' => 'https://cdn.pixabay.com/photo/2017/11/07/00/22/guitar-2925282_960_720.jpg'),
		array('subject_id' => 2, 'item_name' => 'electric bass', 'position' => 8, 'price' => '8.00', 'image' => 'https://cdn.pixabay.com/photo/2015/08/19/09/22/etc-895730_960_720.jpg'),
		array('subject_id' => 3, 'item_name' => 'drums set', 'position' => 9, 'price' => '9.00', 'image' => 'https://cdn.pixabay.com/photo/2014/05/28/15/10/eletronica-356598_960_720.jpg'),
		array('subject_id' => 3, 'item_name' => 'drums set', 'position' => 10, 'price' => '10.00', 'image' => 'https://cdn.pixabay.com/photo/2017/01/02/13/11/drum-kit-1946753_960_720.jpg'),
		array('subject_id' => 3, 'item_name' => 'bongo drums', 'position' => 11, 'price' => '11.00', 'image' => 'https://cdn.pixabay.com/photo/2017/11/18/17/06/africa-2960524_960_720.jpg'),
		array('subject_id' => 3, 'item_name' => 'ornado drum"', 'position' => 12, 'price' => '12.00', 'image' => 'https://cdn.pixabay.com/photo/2018/10/29/12/22/tornado-drum-3781022_960_720.jpg'),
		array('subject_id' => 4, 'item_name' => 'grand piano', 'position' => 13, 'price' => '13.00', 'image' => 'https://cdn.pixabay.com/photo/2013/09/07/02/31/grand-piano-179724_960_720.jpg'),
		array('subject_id' => 4, 'item_name' => 'piano', 'position' => 14, 'price' => '14.00', 'image' => 'https://cdn.pixabay.com/photo/2014/06/28/12/31/piano-378898_960_720.jpg'),
		array('subject_id' => 4, 'item_name' => 'key board', 'position' => 15, 'price' => '15.00', 'image' => 'https://cdn.pixabay.com/photo/2017/10/06/12/25/keyboard-2822917_960_720.jpg'),
		array('subject_id' => 4, 'item_name' => 'piano', 'position' => 16, 'price' => '16.00', 'image' => 'https://cdn.pixabay.com/photo/2017/10/06/15/16/grand-piano-2823488_960_720.jpg'),
		array('subject_id' => 5, 'item_name' => 'violin', 'position' => 17, 'price' => '17.00', 'image' => 'https://cdn.pixabay.com/photo/2016/01/13/00/58/violin-1136991_960_720.jpg'),
		array('subject_id' => 5, 'item_name' => 'cello', 'position' => 18, 'price' => '18.00', 'image' => 'https://cdn.pixabay.com/photo/2017/10/08/15/44/cello-2830350_960_720.jpg'),
		array('subject_id' => 6, 'item_name' => 'saxo phone', 'position' => 19, 'price' => '19.00', 'image' => 'https://cdn.pixabay.com/photo/2015/09/02/13/08/saxophone-918904_960_720.jpg'),
		array('subject_id' => 6, 'item_name' => 'flute', 'position' => 20, 'price' => '20.00', 'image' => 'https://cdn.pixabay.com/photo/2018/01/18/12/39/music-3090204_960_720.jpg')
	);

	foreach ($items as $item) {
		$sql = "INSERT INTO items ";
		$sql .= "(subject_id, item_name, position, price, image) VALUES (";
		$sql .= "'" . $item['subject_id'] . "',";
		$sql .= "'" . $item['item_name'] . "',";
		$sql .= "'" . $item['position'] . "',";
		$sql .= "'" . $item['price'] . "',";
		$sql .= "'" . $item['image'] . "')";
		$result = mysqli_query($db, $sql);
		if (!$result) {
		$msg = "Filling databases into items-table failed";
		exit($msg);
		}
	}
}

function create_subjects_table() {
	global $db;

	$sql = "CREATE TABLE subjects (";
	$sql .= "id INT NOT NULL AUTO_INCREMENT,";
	$sql .= "category_name VARCHAR(30),";
	$sql .= "position INT,";
	$sql .= "PRIMARY KEY (id)";
	$sql .= ")";
	$result = mysqli_query($db, $sql);
	if (!$result) {
		$msg = "Subjects table creation failed!" . PHP_EOL;
		exit($msg);
	}
}

function fill_default_values_into_subjects_table() {
	global $db;

	$subjects = array(
		array('category_name' => 'Guitar', 'position' => 1),
		array('category_name' => 'Basses', 'position' => 2),
		array('category_name' => 'Drums', 'position' => 3),
		array('category_name' => 'Keys', 'position' => 4),
		array('category_name' => 'Strings', 'position' => 5),
		array('category_name' => 'Others', 'position' => 6)
	);

	foreach ($subjects as $subject) {
		$sql = "INSERT INTO subjects ";
		$sql .= "(category_name, position) VALUES (";
		$sql .= "'" . $subject['category_name'] . "',";
		$sql .= "'" . $subject['position'] . "')";
		$result = mysqli_query($db, $sql);
		if (!$result) {
		$msg = "Filling databases into items-table failed";
		exit($msg);
		}
	}
}

function create_users_table() {
	global $db;

	$sql = "CREATE TABLE users (";
	$sql .= "id INT NOT NULL AUTO_INCREMENT,";
	$sql .= "access BOOLEAN NOT NULL,";
	$sql .= "first_name VARCHAR(30),";
	$sql .= "last_name VARCHAR(30),";
	$sql .= "username VARCHAR(30),";
	$sql .= "hashed_password VARCHAR(255),";
	$sql .= "PRIMARY KEY (id))";
	$result = mysqli_query($db, $sql);
	if (!$result) {
		$msg = "Users table creation failed!" . PHP_EOL;
		exit($msg);
	}
}

function create_default_root_user() {
	global $db;

	$hashed_password = password_hash(SUPERUSER_PASSWORD, PASSWORD_BCRYPT);
	$sql = "INSERT INTO users ";
	$sql .= "(access, first_name, last_name, username, hashed_password) ";
	$sql .= "VALUES (";
	$sql .= "TRUE, 'root', 'root', ";
	$sql .= "'" . db_escape($db, h(SUPERUSER_USERNAME)) . "', ";
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

function create_orders_table() {
	global $db;

	$sql = "CREATE TABLE orders (";
	$sql .= "id INT NOT NULL AUTO_INCREMENT,";
	$sql .= "user_id INT,";
	$sql .= "date VARCHAR(30),";
	$sql .= "total_quantity INT,";
	$sql .= "total_price FLOAT,";
	$sql .= "PRIMARY KEY (id)";
	$sql .= ")";
	$result = mysqli_query($db, $sql);
	if (!$result) {
		$msg = "Orders table creation failed!" . PHP_EOL;
		exit($msg);
	}
}

function create_order_items_table() {
	global $db;

	$sql = "CREATE TABLE orderred_items (";
	$sql .= "id INT NOT NULL AUTO_INCREMENT,";
	$sql .= "item_id INT,";
	$sql .= "order_id INT,";
	$sql .= "quantity INT,";
	$sql .= "price FLOAT,";
	$sql .= "PRIMARY KEY (id)";
	$sql .= ")";
	$result = mysqli_query($db, $sql);
	if (!$result) {
		$msg = "Orders table creation failed!" . PHP_EOL;
		exit($msg);
	}
}

if (database_already_exists()) {
	redirect_to("public/index.php");
}

$db = create_database();
create_items_table();
fill_default_values_into_items_table();
create_subjects_table();
fill_default_values_into_subjects_table();
create_users_table();
create_default_root_user();
create_orders_table();
create_order_items_table();
db_disconnect($db);
redirect_to("public/index.php");

?>