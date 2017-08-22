<?php
require_once('includes/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>$(function() {
      $( "#search" ).autocomplete({
        source: 'search.php'
      });
    });</script>
<style> 
input[type=text] {
    width: 250px;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    background-color: white;
    background-image: url('images/search.png');
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 12px 20px 12px 40px;
    -webkit-transition: width 0.4s ease-in-out;
    transition: width 0.4s ease-in-out;
}

input[type=text]:focus {
    width: 250px;
}
</style>
    <meta charset="utf-8">
    <title>Blog</title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
</head>
<body>

    <div id="wrapper">
            <h1>Blog</h1>
<form>
  <input type="text" name="search" placeholder="Search.." id="search">
</form>
            <hr/>
            <a href="user/login.php">Login</a>
            <a href="user/register.php">Register</a>
            <hr/>
			
            <?php
                    try {

                            $stmt = $db->query('SELECT postID, postTitle, postDesc, postDate FROM blog_post ORDER BY postID DESC');
                            while($row = $stmt->fetch()){

                                    echo '<div>';
                                            echo '<h1><a href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h1>';
                                            echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).'</p>';
                                            echo '<p>'.$row['postDesc'].'</p>';
                                            echo '<p><a href="viewpost.php?id='.$row['postID'].'">Read More</a></p>';
                                    echo '</div>';

                            }

                    } catch(PDOException $e) {
                        echo $e->getMessage();
                    }
            ?>
    </div>


</body>
</html>
