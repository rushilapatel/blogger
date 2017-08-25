<?php
require_once('includes/config_blogger.php');
if(!$blogger->is_blogger_logged_in()){ header('Location: user/login.php'); } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
    $(function() {
      $( "#search" ).autocomplete({
        source: 'search.php'
      });
    });
	$(document).ready(function(){
        $(".follow").click(function(){
            var pId = this.id;
            var bId = <?php echo $_SESSION['blogger_id'];?>;
           $.post("follow.php",
           {
                followingId: pId,
                bloggerId: bId
           }
	});
	});
    $(document).ready(function(){
        $(".like").click(function(){
            var pId = this.id;
            var bId = <?php echo $_SESSION['blogger_id'];?>;
           $.post("like_post.php",
           {
                postId: pId,
                bloggerId: bId
           },
           function(response,status){
                // alert("*----Received Data----*\n\nResponse : " + response+"\n\nStatus : " + status);
                response = $.parseJSON( response );
                $("#likespan".concat(pId)).html(response.likes);
                if(response.inserted){
                    $("#".concat(pId)).html("Unlike");
                }else{
                    $("#".concat(pId)).html("Like");
                }
           });
            var postId1 = $(this).id;
            
        });
    });
</script>
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
                            $stmt = $db->query('SELECT postId, postTitle, postDesc, postDate, bloggerId FROM blog_post ORDER BY postId DESC');
                            while($row = $stmt->fetch()){
                                $stmt1 = $db->prepare('SELECT bloggerId FROM blog_post_like WHERE postId = :postId ');
                                $stmt1->execute(array(':postId' => $row['postId']));
                                $likes = $stmt1->rowCount();
                                $stmt1 = $db->prepare('SELECT * FROM blog_post_like WHERE (postId,bloggerId) = (:postId, :bloggerId)');
                                $stmt1->execute(array(':postId' => $row['postId'],':bloggerId' => $_SESSION['blogger_id']));
                                $liked = $stmt1->rowCount();
                                echo '<div>';
                                        echo '<h1><a href="viewpost.php?id='.$row['postId'].'">'.$row['postTitle'].'</a></h1>';
                                        echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).'</p>';
                                        echo '<p>'.$row['postDesc'].'</p>';
                                        echo '<p><a href="viewpost.php?id='.$row['postId'].'">Read More</a></p>';
                                        echo '<p><button class="like" id="'. $row['postId'] . '">';
                                        if($liked <= 0){
                                            echo ' Like ';
                                        }
                                        else{
                                            echo ' Unlike ';
                                        }
                                        echo '</button>';
                                        echo '<span id = "likespan'. $row['postId'] .'"> '. $likes .'</span>'.' </p>';
										echo '<p><button class="follow" id="'. $row['bloggerId'] . '">';
										echo 'Follow';
										echo '</button>';
                                echo '</div>';
                                
                      
                            }
                    } catch(PDOException $e) {
                        echo $e->getMessage();
                    }
            ?>
    </div>


</body>
</html>