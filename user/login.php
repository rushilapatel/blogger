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
<style>

    input[type="text"]{
       
    }

.sl1{
background-color: #4CAF50;
color: white;
   -webkit-border-radius: 20px;
   -moz-border-radius: 20px;
   border-radius: 20px;
  padding: 2px 20px;
  text-align: center;
}
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
.but1{
    background-color: #4CAF50;
       -webkit-border-radius: 20px;
   -moz-border-radius: 20px;
   border-radius: 20px;
    color: white;
    padding: 5px 15px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

</style>
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
<h2><center>Login</center></h2>
	<form action="" method="post" style="border:ridge">
	<table style="border:none;" >
	<tr style="border:none;">
	<th style="border:none;background-color:#550006;color:#FFFFFF"><label>Email</label></th><td style="border:none;"><input type="text" style="border-color:#000000" name="email" value=""  /></td></tr>
	
	<tr style="border:none;">
	<th style="border:none; background-color:#550006;color:#FFFFFF"><label>Password</label></th><td style="border:none;"><input type="password" name="password" value="" style="border-color:#000000"  /></td></tr>
	</table>
	<br>
	
	<label><b>User Type</b></label>
	
	
		<select name="user_type" class="sl1" style="margin-left:10px;">
			<option value="blogger">Blogger</option>
			<option value="viewer">Viewer</option>
		</select>
	
	<br><br>
	<input type="submit" name="submit" value="Login" class="but" />
	<a name="register" href="register.php" class="but1" style="float:right"/> Register </a>
	
	
	</form>

</div>
</body>
</html>
