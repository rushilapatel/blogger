<?php
require_once('includes/config_blogger.php');
if(!$blogger->is_blogger_logged_in()){ header('Location: user/login.php'); } ?>
<?php
	try {
	$resp = new \stdClass();
	$stmt = $db->prepare('SELECT * FROM blog_follow WHERE (bloggerId,followingId) = (:bloggerId, :followingId)') ;
	$stmt->execute(array(
				':bloggerId' => $_REQUEST['bloggerId'],
				':followingId' => $_REQUEST['followingId']
			));
	if($stmt->rowCount() <= 0){	
				$stmt = $db->prepare('INSERT INTO blog_follow (bloggerId,followingId) VALUES (:bloggerId, :followingId)') ;
				$stmt->execute(array(
					':bloggerId' => $_REQUEST['bloggerId']
					':followingId' => $_REQUEST['followingId'],
				));
				$resp->inserted = true;
				}else{
				$stmt = $db->prepare('DELETE FROM blog_follow WHERE (bloggerId,followingId) = (:bloggerId, :followingId)') ;
				$stmt->execute(array(
					':bloggerId' => $_REQUEST['bloggerId']
					':followingId' => $_REQUEST['followingId'],
				));
				$resp->inserted = false;
			}	
		$stmt1 = $db->prepare('SELECT bloggerId FROM blog_follow WHERE followingId = :followingId ');
		$stmt1->execute(array(':followingId' => $_REQUEST['followingId']));
		$follow = $stmt1->rowCount();
		 $resp->follow = $follow;
		 echo json_encode($resp);
		 }
	?>			