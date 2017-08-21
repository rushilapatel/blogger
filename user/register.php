<?php //include config
require_once('../includes/config_blogger.php');

?>
<!doctype html>
<html lang="en">
<head>
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

		if($email ==''){
			$error[] = 'Please enter the email address.';
		}

		if(!isset($error)){

			$hashedpassword = $blogger->password_hash($password, PASSWORD_BCRYPT);

			try {

				$stmt = $db->prepare('INSERT INTO blog_blogger (bloggerName,password,bloggerEmail) VALUES (:bloggername, :password, :email)') ;
				$stmt->execute(array(
					':bloggername' => $bloggername,
					':password' => $hashedpassword,
					':email' => $email
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

		<p><label>bloggername</label><br />
		<input type='text' name='bloggername' value='<?php if(isset($error)){ echo $_POST['bloggername'];}?>'></p>

		<p><label>Password</label><br />
		<input type='password' name='password' value='<?php if(isset($error)){ echo $_POST['password'];}?>'></p>

		<p><label>Confirm Password</label><br />
		<input type='password' name='passwordConfirm' value='<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>'></p>

		<p><label>Email</label><br />
		<input type='text' name='email' value='<?php if(isset($error)){ echo $_POST['email'];}?>'></p>

		<p><input type='submit' name='submit' value='Add blogger'></p>

	</form>

</div>
