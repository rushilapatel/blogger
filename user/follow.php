<?php

require_once('../includes/config_blogger.php');

if( $blogger->is_blogger_logged_in() ){ 
	
	header('Location: index.php');
	 }
?>