<?php
require_once('includes/config_blogger.php');
if(!$blogger->is_blogger_logged_in()){ header('Location: user/login.php');}
if(isset($_GET['search']) && !empty($_GET['search'])){
  $searchTearm = trim($_GET['search']," \t\n\r\0\x0B" );
  $stmt = $db->prepare("SELECT postId FROM blog_post WHERE postTitle = :pT");
  $stmt->execute(array(':pT' => $searchTearm));
  if($stmt->rowCount() > 0){
    $row = $stmt->fetch();
    header('Location: viewpost.php?id=' . $row['postId']);
  }
}
?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="http://ajax.microsoft.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js"></script>
    <script id="writeCommentTemplate" type="text/x-jquery-tmpl">

    </script>
    <script id = "commentTemplate" type="text/x-jquery-tmpl">
    <div id = "div${commentId}">
    <span class="commentBlogger" id = "comment${commentId}Blogger${bloggerId}">${bloggerName}</span>
    <span class="commentDescription">${commentDescription}</span>
    </div>
    </script>
    <script>
    $(function () {
      $("#search").autocomplete({
        source: 'search.php'
      });
    });
    $(document).ready(function () {
      $(".like").click(function () {
        var pId = (this.id).replace("likeButton","");
        var bId = <?php echo $_SESSION['blogger_id']; ?>;
        $.post("like_post.php",
        {
          postId: pId,
          bloggerId: bId
        },
        function (response, status) {
          response = $.parseJSON(response);
          $("#likespan".concat(pId)).html(response.likes);
          if (response.inserted) {
            $("#likeButton".concat(pId)).html("Unlike");
          } else {
            $("#likeButton".concat(pId)).html("Like");
          }
        });

      });
    });
    $(document).ready(function(){
      $(".comment").click(function(){
        var pId = (this.id).replace("commentButton","");
        $.post("get_comments.php",
        {
          postId: pId
        },
        function(response,status){
          //alert("*----Received Data----*\n\nResponse : " + response+"\n\nStatus : " + status);
          response = $.parseJSON(response);
          $("#post_comments".concat(pId)).empty();
          $("#div_write_comment".concat(pId)).empty();
          $("#span_comment_total".concat(pId)).empty();
          if(response.comments.length <= 0){
            $("#span_comment_total".concat(pId)).html("No Comments");
          }else{
            $("#span_comment_total".concat(pId)).html(response.comments.length + " Comments");
            $("#writeCommentTemplate").tmpl().appendTo("#div_write_comment".concat(pId));
            $("#commentTemplate").tmpl(response.comments).appendTo("#post_comments".concat(pId));
          }
        });
      });
    });
    $(document).ready(function(){
      $(".follow").click(function(){
        var classNames = $(this).attr("class").toString().split(' ');
        var fId = (classNames[1]).replace("followButton","");
        var bId = <?php echo $_SESSION['blogger_id'];?>;
        $.post("follow.php",
        {
          followingId: fId,
          bloggerId: bId
        },
        function(response,status){
          //alert("*----Received Data----*\n\nResponse : " + response+"\n\nStatus : " + status);
          response = $.parseJSON(response);
          if(response.followed){
            $(".followButton".concat(fId)).html("Unfollow");
          }else{
            $(".followButton".concat(fId)).html("Follow");
          }
        });
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
      <a href="user/logout.php">Logout</a>
      <hr/>

      <?php
      try {
        $stmt = $db->query('SELECT postId, postTitle, postDesc, postDate, bloggerId,bloggerName FROM blog_post NATURAL JOIN blog_blogger ORDER BY postId DESC');
        while($row = $stmt->fetch()){
          $stmt1 = $db->prepare('SELECT bloggerId FROM blog_post_like WHERE postId = :postId ');
          $stmt1->execute(array(':postId' => $row['postId']));
          $likes = $stmt1->rowCount();
          $stmt1 = $db->prepare('SELECT * FROM blog_post_like WHERE (postId,bloggerId) = (:postId, :bloggerId)');
          $stmt1->execute(array(':postId' => $row['postId'],':bloggerId' => $_SESSION['blogger_id']));
          $liked = $stmt1->rowCount();
          $stmt1 = $db->prepare('SELECT * FROM blog_follow WHERE (bloggerId,followingId) = (:bloggerId, :followingId)') ;
          $stmt1->execute(array(
            ':bloggerId' => $_SESSION['blogger_id'],
            ':followingId' => $row['bloggerId']
          ));
          $followed = $stmt1->rowCount();
          echo '<div>';
          echo '<h1><a href="viewpost.php?id='.$row['postId'].'">'.$row['postTitle'].'</a></h1>';

          echo '<p>' .
          '<span>' .
          'blogger :: '.
          '</span>'.
          '<a href = "" class="bloggerName">'.
          $row['bloggerName'] .
          ' </a>';
          echo '<button class="follow followButton'. $row['bloggerId'] . '">';
          if($followed <= 0){
            echo ' Follow ';
          }
          else{
            echo ' Unfollow ';
          }
          echo '</button>'.
          '</p>';


          echo '<p>'.
          'Posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).
          '</p>';

          echo '<p>'.
          $row['postDesc'].
          '</p>';
          echo '<p>'.
          '<a href="viewpost.php?id='.$row['postId'].'">'.
          'Read More'.
          '</a>'.
          '</p>';

          echo '<p>'.
          '<button  class="like" id="likeButton' . $row['postId'] . '">';
          if ($liked <= 0) {
            echo ' Like ';
          } else {
            echo ' Unlike ';
          }
          echo '</button>';
          echo '<span id = "likespan' . $row['postId'] . '">' .
          $likes .
          '</span>' .
          ' </p>';

          echo '<p><button  class="comment" id="commentButton' . $row['postId'] . '">';
          echo 'Comment';
          echo '</button>';
          echo '<div>'.
          '<span id="span_comment_total'.$row['postId'].'">' .
          '</span>'.
          '</div>';
          echo '<div id="div_write_comment'.$row['postId'].'"></div>';
          echo '<div id="post_comments'.$row['postId'].'"></div>';
          echo '</div>';


        }
      } catch(PDOException $e) {
        echo $e->getMessage();
      }
      ?>
    </div>


  </body>
  </html>
