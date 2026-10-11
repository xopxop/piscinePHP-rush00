<?php

define('DB_SERVER', getenv('DB_HOST'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));
define('DB_NAME', getenv('DB_NAME'));
define("ITEMS_FILE", "./default_database/items.cvs"); // need to change
define("SUPERUSER_USERNAME", getenv('ADMIN_USER'));
define("SUPERUSER_PASSWORD", getenv('ADMIN_PASSWORD'));
define("SUPERUSER_FIRSTNAME", getenv('ADMIN_FIRSTNAME'));
define("SUPERUSER_LASTNAME", getenv('ADMIN_LASTNAME'));

?>
