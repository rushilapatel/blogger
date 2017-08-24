<?php
require_once('includes/config_blogger.php');
if(!$blogger->is_blogger_logged_in()){ header('Location: user/login.php'); } ?>

<?php
	try {
			$resp = new \stdClass();
			$stmt = $db->prepare('SELECT * FROM blog_post_like WHERE (postId,bloggerId) = (:postId, :bloggerId)') ;
			$stmt->execute(array(
				':postId' => $_REQUEST['postId'],
				':bloggerId' => $_REQUEST['bloggerId']
			));

			if($stmt->rowCount() <= 0){	
				$stmt = $db->prepare('INSERT INTO blog_post_like (postId,bloggerId) VALUES (:postId, :bloggerId)') ;
				$stmt->execute(array(
					':postId' => $_REQUEST['postId'],
					':bloggerId' => $_REQUEST['bloggerId']
				));
				$resp->inserted = true;
			}else{
				$stmt = $db->prepare('DELETE FROM blog_post_like WHERE (postId,bloggerId) = (:postId, :bloggerId)') ;
				$stmt->execute(array(
					':postId' => $_REQUEST['postId'],
					':bloggerId' => $_REQUEST['bloggerId']
				));
				$resp->inserted = false;
			}	
            $stmt1 = $db->prepare('SELECT bloggerId FROM blog_post_like WHERE postId = :postId ');
            $stmt1->execute(array(':postId' => $_REQUEST['postId']));
            $likes = $stmt1->rowCount();
            $resp->likes = $likes;
			echo json_encode($resp);
	} catch(PDOException $e) {
	    echo $e->getMessage();
	}
?>



