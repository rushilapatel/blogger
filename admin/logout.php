<?php
//include config
require_once('../includes/config_admin.php');

//log user out
$admin->logout();
header('Location: index.php');

?>
