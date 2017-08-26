<?php
//include config
require_once('../includes/config_blogger.php');


//check if already logged in
if( $blogger->is_blogger_logged_in() ){
	if($blogger->is_blogger()){
		header('Location: index.php');
	}else{
		header('Location: ../index.php');
	}
	exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>blogger Login</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
</head>
<body>

<div id="login">

	<?php

	//process login form if submitted
	if(isset($_POST['submit'])){

		$blogger_email = trim($_POST['email']);
		$password = trim($_POST['password']);
		$user_type = strtolower(trim($_POST['user_type']));
		if($blogger->login($blogger_email,$password,$user_type)){
			if($blogger->is_blogger()){
				header('Location: index.php');
			}else{
				header('Location: ../index.php');
			}
			exit;

		} else {
			$message = '<p class="error">Wrong user emailname or password</p>';
		}

	}//end if submit

	if(isset($message)){ echo $message; }
	?>

	<form action="" method="post">
	<p><label>Email</label><input type="text" name="email" value=""  /></p>
	<p><label>Password</label><input type="password" name="password" value=""  /></p>
	<p>
		<label>User Type</label><br />
		<select name="user_type">
			<option value="blogger">Blogger</option>
			<option value="viewer">Viewer</option>
		</select>
	</p>
	<p><input type="submit" name="submit" value="Login"  /></p>
	<p><a name="register" href="register.php"/> Register </a>
	</form>

</div>
</body>
</html>
