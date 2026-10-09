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

if (database_already_exists()) {
	redirect_to("public/index.php");
} else {
	redirect_to("install.php");
}

?>