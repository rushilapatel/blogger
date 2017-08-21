<?php
//include config
require_once('../includes/config_blogger.php');

//log user out
$blogger->logout();
header('Location: index.php'); 

?>