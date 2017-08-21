<?php
//include config
require_once('../includes/config_admin.php');

//if not logged in redirect to login page
if(!$admin->is_admin_logged_in()){ header('Location: login.php'); }

//show message from add / edit page
if(isset($_GET['delblogger'])){

	//if blogger id is 1 ignore
	if($_GET['delblogger'] !='1'){

		$stmt = $db->prepare('DELETE FROM blog_blogger WHERE bloggerId = :bloggerId') ;
		$stmt->execute(array(':bloggerId' => $_GET['delblogger']));

		header('Location: bloggers.php?action=deleted');
		exit;

	}
}

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Users</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
  <script language="JavaScript" type="text/javascript">
  function delblogger(id, title)
  {
	  if (confirm("Are you sure you want to delete '" + title + "'"))
	  {
	  	window.location.href = 'users.php?delblogger=' + id;
	  }
  }
  </script>
</head>
<body>

	<div id="wrapper">

	<?php include('menu.php');?>

	<?php
	//show message from add / edit page
	if(isset($_GET['action'])){
		echo '<h3>User '.$_GET['action'].'.</h3>';
	}
	?>

	<table>
	<tr>
		<th>Username</th>
		<th>Email</th>
		<th>Action</th>
	</tr>
	<?php
		try {

			$stmt = $db->query('SELECT bloggerId, bloggerName, bloggerEmail FROM blog_blogger ORDER BY bloggerName');
			while($row = $stmt->fetch()){

				echo '<tr>';
				echo '<td>'.$row['bloggerName'].'</td>';
				echo '<td>'.$row['bloggerEmail'].'</td>';
				?>

				<td>
					<a href="edit-blogger.php?id=<?php echo $row['bloggerId'];?>">Edit</a>
					<?php if($row['bloggerId'] != 1){?>
						| <a href="javascript:delblogger('<?php echo $row['bloggerId'];?>','<?php echo $row['bloggerName'];?>')">Delete</a>
					<?php } ?>
				</td>

				<?php
				echo '</tr>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>

</div>

</body>
</html>
