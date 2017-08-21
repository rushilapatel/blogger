<?php

include('class.password.php');

class User extends Password{

	function __construct(){
		parent::__construct();
	}

	public function is_logged_in(){
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}
	}

	public function logout(){
		session_destroy();
	}

}


?>
