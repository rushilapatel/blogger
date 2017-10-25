<?php
//include config
require_once('../includes/config_admin.php');
//check if already logged in
if( $admin->is_admin_logged_in() ){ header('Location: index.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Login</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
  <style>
  .but{
    background-color: #4CAF50;
       -webkit-border-radius: 20px;
   -moz-border-radius: 20px;
   border-radius: 20px;
    color: white;
    padding: 5px 15px;
	bckground-ra
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
  </style>
</head>
<body>

<div id="login">

	<?php

	//process login form if submitted
	if(isset($_POST['submit'])){

		$username = trim($_POST['adminName']);
		$password = trim($_POST['password']);

		if($admin->login($username,$password)){

			//logged in return to index page
			header('Location: index.php');
			exit;

		} else {
			$message = '<p class="error">Wrong username or password</p>';
		}

	}//end if submit

	if(isset($message)){ echo $message; }
	?>
<h2><center>Admin-Login</center></h2>
	<form action="" method="post" style="border:ridge">
	<table style="border:none;" >
	<tr style="border:none;">
	<th style="border:none;background-color:#550006;color:#FFFFFF">
	<label>Username</label></th><td style="border:none;"><input type="text" name="adminName" value=""  /></td></tr>
	<tr style="border:none;">
	<th style="border:none;background-color:#550006;color:#FFFFFF">
	<label>Password</label></th><td style="border:none;"><input type="password" name="password" value=""  /></td></tr>
	<tr><label></label><td><input type="submit" name="submit" value="Login" class="but" /></td><td></td></tr>
	</table>
	</form>

</div>
</body>
</html>
