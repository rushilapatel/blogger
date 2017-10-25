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
  <link rel="stylesheet" href="jquery-ui.min.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script src="http://ajax.microsoft.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js"></script>
  <script src="jquery.autogrowtextarea.min.js"></script>


  <script id="writeCommentTemplate" type="text/x-jquery-tmpl">
  <textarea style="resize:none" rows="1" cols="50" placeholder="Write your comment.." class="comm_input" id="commentInput${postId}"></textarea><br/>
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
      source: 'search.php',
      minLength: 1,
      select: function(event, ui) {
        $(this).val(ui.item.value);
        $(this).parents("form").submit();
      }
    });
  });

  $(document).ready(function(){
    $('body').on("keyup",".comm_input",function(e){
      if(e.which == 13 ){
        pId = (this.id).replace("commentInput","");
        comment = $(this).val();
        var bId = <?php echo $_SESSION['blogger_id'];?>;
        $.post("add_comment.php",
        {
          postId: pId,
          bloggerId: bId,
          commentDescription: comment
        },
        function(response,status){
          response = $.parseJSON(response);
          if(response.inserted){
            $("#commentButton".concat(pId)).trigger('click');
          }else{
            alert("error:: comment not inserted" + response);
          }
        });
      }
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
          $("#likeButton".concat(pId)).hide().html("UnLike").fadeIn(200);
        } else {
          $("#likeButton".concat(pId)).hide().html("Like").fadeIn(200);
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
          $("#span_comment_total".concat(pId)).hide().html("No Comments").fadeIn(300);
          $("#writeCommentTemplate").tmpl({"postId": pId}).hide().appendTo("#div_write_comment".concat(pId)).fadeIn(300).autoGrow();
        }else{
          $("#span_comment_total".concat(pId)).hide().html(response.comments.length + " Comments").fadeIn(300);
          $("#writeCommentTemplate").tmpl({"postId": pId}).hide().appendTo("#div_write_comment".concat(pId)).fadeIn(300).autoGrow();
          $("#commentTemplate").tmpl(response.comments).hide().appendTo("#post_comments".concat(pId)).fadeIn(300);
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
          $(".followButton".concat(fId)).hide().html("Unfollow").fadeIn(100);
        }else{
          $(".followButton".concat(fId)).html("Follow").fadeIn(200);
        }
      });
    });
  });


  </script>
  <style>
  .ui-autocomplete {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    float: left;
    display: none;
    min-width: 160px;
    padding: 4px 0;
    margin: 0 0 10px 25px;
    list-style: none;
    background-color: #ffffff;
    border-color: #ccc;
    border-color: rgba(0, 0, 0, 0.2);
    border-style: solid;
    border-width: 1px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    -webkit-background-clip: padding-box;
    -moz-background-clip: padding;
    background-clip: padding-box;
    *border-right-width: 2px;
    *border-bottom-width: 2px;
  }

  .ui-menu-item > a.ui-corner-all {
    display: block;
    padding: 3px 15px;
    clear: both;
    font-weight: normal;
    line-height: 18px;
    color: #555555;
    white-space: nowrap;
    text-decoration: none;
  }

  .ui-state-hover, .ui-state-active {
    color: #ffffff;
    text-decoration: none;
    background-color: #0088cc;
    border-radius: 0px;
    -webkit-border-radius: 0px;
    -moz-border-radius: 0px;
    background-image: none;
  }
  

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
  .like {
   margin-left:100px;
  padding: 9px 20px;
  font-size: 16px;
  text-align: center;
  cursor: pointer;
  outline: none;
  color: #fff;
  background-color: #4CAF50;
  border: none;
  border-radius: 10px;
  box-shadow: 0 5px #999;
}

.like:hover {background-color: #3e8e41}

.like:active {
  background-color: #3e8e41;
  box-shadow: 0 1px #666;
  transform: translateY(4px);
}
#fol {
  padding: 9px 20px;
  font-size: 16px;
  text-align: center;
  cursor: pointer;
  outline: none;
  color: #fff;
  background-color: #4CAF50;
  border: none;
  border-radius: 10px;
  box-shadow: 0 5px #999;
}

#fol:hover {background-color: #3e8e41}

#fol:active {
  background-color: #3e8e41;
  box-shadow: 0 1px #666;
  transform: translateY(4px);
}
.comment {
  padding: 9px 20px;
  font-size: 16px;
  text-align: center;
  cursor: pointer;
  outline: none;
  color: #fff;
  background-color: #4CAF50;
  border: none;
  border-radius: 10px;
  box-shadow: 0 5px #999;
}

.comment:hover {background-color: #3e8e41}

.comment:active {
  background-color: #3e8e41;
  box-shadow: 0 1px #666;
  transform: translateY(4px);
}

  .bb {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
}
.bb:hover{
background-color:#FFFFFF;
border:thick;
color:#4CAF50;
}

  </style>
  <meta charset="utf-8">
  <title>Blog</title>
  <link rel="stylesheet" href="style/normalize.css">
  <link rel="stylesheet" href="style/main.css">
</head>
<body style="width:100%;">

  <div id="wrapper">
    <h1>Blog</h1>
	
<form  style="background-color:#333">

      <input type="text" name="search" placeholder="Search.." id="search" >
	
    <a href="user/logout.php" class="bb"  style="float:right" >Logout</a>
</form>
   <!-- <a. href="user/login.php">Login</a>
    <a href="user/register.php">Register</a>
    <a href="user/logout.php">Logout</a>-->
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
        echo '<button id="fol"class="follow followButton'. $row['bloggerId'] . '">';
        if($followed <= 0){
          echo ' Follow ';
        }
        else{
          echo ' Unfollow ';
        }
        echo '</button>'.
        
        '<button  class="like" id="likeButton' . $row['postId'] . '">';
        if ($liked <= 0) {
          echo 'Like ';
        } else {
          echo 'Unlike ';
        }
        echo '</button>';
        echo '<span style="margin-left:25px ;"id = "likespan' . $row['postId'] . '">' .
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
