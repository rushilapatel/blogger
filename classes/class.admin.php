<?php

include('class.user.php');

class Admin extends User{

  private $db;

	function __construct($db){
		parent::__construct();

		$this->_db = $db;
	}

	public function is_admin_logged_in(){
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['user_type'] && $_SESSION['user_type'] == 'admin'){
			return true;
		}
	}

	private function get_admin_hash($adminName){

		try {

			$stmt = $this->_db->prepare('SELECT password FROM blog_admin WHERE adminName = :adminName');
			$stmt->execute(array('adminName' => $adminName));

			$row = $stmt->fetch();
			return $row['password'];

		} catch(PDOException $e) {
		    echo '<p class="error">'.$e->getMessage().'</p>';
		}
	}


	public function login($adminName,$password){

		$hashed = $this->get_admin_hash($adminName);

		if($this->password_verify($password,$hashed) == 1){

		    $_SESSION['loggedin'] = true;
                    $_SESSION['user_type'] = 'admin';
		    return true;
		}
	}


	public function logout(){
		session_destroy();
	}

}

?>
