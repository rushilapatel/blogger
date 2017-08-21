<?php

include('class.user.php');

class Blogger extends User{

    private $db;

	function __construct($db){
		parent::__construct();

		$this->_db = $db;
	}

	public function is_blogger_logged_in(){
            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['user_type'] && $_SESSION['user_type'] == 'blogger'){
                    return true;
            }
	}

	private function get_blogger_hash($blogger_id){

            try {

                    $stmt = $this->_db->prepare('SELECT password FROM blog_blogger WHERE bloggerId = :bloggerId');
                    $stmt->execute(array('bloggerId' => $blogger_id));

                    $row = $stmt->fetch();
                    return $row['password'];

            } catch(PDOException $e) {
                echo '<p class="error">'.$e->getMessage().'</p>';
            }
	}


	public function login($blogger_email,$password){

            try {
                    $stmt = $this->_db->prepare('SELECT bloggerId FROM blog_blogger WHERE bloggerEmail = :bloggerEmail');
                    $stmt->execute(array('bloggerEmail' => $blogger_email));
                    $row = $stmt->fetch();
                    $blogger_id = $row['bloggerId'];
                    if($blogger_id){
                        $hashed = $this->get_blogger_hash($blogger_id);
                        if($this->password_verify($password,$hashed) == 1){
                            $_SESSION['loggedin'] = true;
                            $_SESSION['user_type'] = 'blogger';
                            $_SESSION['blogger_id'] = $blogger_id;
                            return true;
                        }
                    }
                } catch(PDOException $e) {
                    echo '<p class="error">'.$e->getMessage().'</p>';
                }

	}

	public function logout(){
            session_destroy();
	}

}


?>
