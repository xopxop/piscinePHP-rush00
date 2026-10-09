<?php require_once("../private/initialize.php"); ?>
<?php require_login(); ?>
<?php

log_out_user();
db_disconnect($db);
redirect_to(url_for("index.php"));

?>