<?php //include config
require_once('../includes/config_blogger.php');

?>
<!doctype html>
<html lang="en">
<head>
<style>

.sl1{

   -webkit-border-radius: 20px;
   -moz-border-radius: 20px;
   border-radius: 20px;
  padding: 2px 20px;
  text-align: center;
}
button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

/* Extra styles for the cancel button */
.cancelbtn {
    padding: 14px 20px;
    background-color: #f44336;
}

/* Float cancel and signup buttons and add an equal width */
.cancelbtn {
    float: left;
    width: 100%;
}
.signupbtn {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
    float: left;
    width: 100%;
}

/* Add padding to container elements */
.container {
    padding: 16px;
}

/* Clear floats */
.clearfix::after {
    content: "";
    clear: both;
    display: table;
}

/* Change styles for cancel button and signup button on extra small screens */
@media screen and (max-width: 300px) {
    .cancelbtn, .signupbtn {
       width: 100%;
    }
}
</style>
  <meta charset="utf-8">
  <title>Register</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
</head>
<body>

<div id="wrapper">

	<?php include('menu_register.php');?>

	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		//collect form data
		extract($_POST);

		//very basic validation
		if($bloggername ==''){
			$error[] = 'Please enter the bloggername.';
		}

		if($password ==''){
			$error[] = 'Please enter the password.';
		}

		if($passwordConfirm ==''){
			$error[] = 'Please confirm the password.';
		}

		if($password != $passwordConfirm){
			$error[] = 'Passwords do not match.';
		}

		if($user_type ==''){
			$error[] = 'Please select the user_type.';
		}
		$user_type = strtolower($user_type);
		if($email ==''){
			$error[] = 'Please enter the email address.';
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      	$error[] = "Invalid email format"; 
    	}
		if(!isset($error)){

			$hashedpassword = $blogger->password_hash($password, PASSWORD_BCRYPT);

			try {

				$stmt = $db->prepare('INSERT INTO blog_blogger (bloggerName,password,bloggerEmail,userType) VALUES (:bloggername, :password, :email, :userType)') ;
				$stmt->execute(array(
					':bloggername' => $bloggername,
					':password' => $hashedpassword,
					':email' => $email,
					':userType' => $user_type
				));

				//redirect to index page
				header('Location: login.php');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		}
	}
	?>

	<form action='' method='post'>

		<p><label><b>Username</b></label><br />
		<input type='text' name='bloggername' value='<?php if(isset($error)){ echo $_POST['bloggername'];}?>'></p>

		<p><label><b>Password</b></label><br />
		<input type='password' name='password' value='<?php if(isset($error)){ echo $_POST['password'];}?>'></p>

		<p><label><b>Confirm Password</b></label><br />
		<input type='password' name='passwordConfirm' value='<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>'></p>

		<p><label><b>Email</b></label><br />
		<input type='text' name='email' value='<?php if(isset($error)){ echo $_POST['email'];}?>'></p>

    <p>
      <label><b>User Type</b></label><br />
      <select name="user_type" class="sl1">
  			<option value="blogger">Blogger</option>
  			<option value="viewer">Viewer</option>
  		</select>
    </p>
<div class="clearfix">
		<table style="border:none"><tr style="border:none"><td style="border:none"><a name="cancel" href="login.php"  class="cancelbtn" style="color:#FFFFFF;"><center>Cancel</center></a></td><td style="border:none"><input type='submit' name='submit' value='Sign Up' class="signupbtn"></td></tr></table>
</div>
	</form>

</div>
