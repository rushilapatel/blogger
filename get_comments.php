<?php
  require_once('includes/config_blogger.php');
  if(!$blogger->is_blogger_logged_in()){ header('Location: user/login.php'); }
  $resp = new \stdClass();
  $stmt = $db->prepare('SELECT * FROM blog_post_comment NATURAL JOIN blog_blogger WHERE postId = :postId') ;
  $stmt->execute(array(
        ':postId' => $_REQUEST['postId']
      ));
  $resp->comments = array();
  while($row = $stmt->fetch()){
      $comment = new \stdClass();
      $comment->commentId = $row['commentId'];
      $comment->postId = $row['postId'];
      $comment->bloggerId = $row['bloggerId'];
      $comment->commentDescription = $row['comment_description'];
      $comment->commentCreated = $row['comment_created'];
      $comment->bloggerName = ucwords($row['bloggerName']);
      array_push($resp->comments,$comment);
  }
  echo json_encode($resp);
?>
