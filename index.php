<?php

require_once("private/database.php");
require_once("private/functions.php");

if (database_already_exists()) {
	redirect_to("public/index.php");
} else {
	redirect_to("install.php");
}

?>
