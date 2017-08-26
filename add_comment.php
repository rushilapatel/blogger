<?php
  require_once('includes/config_blogger.php');
  if(!$blogger->is_blogger_logged_in()){ header('Location: user/login.php'); }
  $resp = new \stdClass();
  $stmt = $db->prepare('INSERT INTO blog_post_comment (postId,bloggerId,comment_description) VALUES (:postId,:bloggerId,:comment_description)') ;
  $stmt->execute(array(
        ':postId' => $_REQUEST['postId'],
        ':bloggerId' => $_REQUEST['bloggerId'],
        ':comment_description' => $_REQUEST['commentDescription']
      ));
  if($stmt->rowCount() > 0){
    $resp->inserted = true;
  }else{
    $resp->inserted = false;
  }
  echo json_encode($resp);
?>
