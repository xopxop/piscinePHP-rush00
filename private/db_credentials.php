<?php

define('DB_SERVER', getenv('DB_HOST'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));
define('DB_NAME', getenv('DB_NAME'));
define("ITEMS_FILE", "./default_database/items.cvs"); // need to change
define("SUPERUSER_USERNAME", getenv('ADMIN_USER'));
define("SUPERUSER_PASSWORD", getenv('ADMIN_PASSWORD'));

echo "DB_SERVER: " . DB_SERVER . "\n";
echo "DB_USER: " . DB_USER . "\n";
echo "DB_PASS: " . DB_PASS . "\n";
echo "DB_NAME: " . DB_NAME . "\n";
echo "ITEMS_FILE: " . ITEMS_FILE . "\n";
echo "SUPERUSER_USERNAME: " . SUPERUSER_USERNAME . "\n";
echo "SUPERUSER_PASSWORD: " . SUPERUSER_PASSWORD . "\n";

?>
