<?php
    require_once('./includes/config_blogger.php');

    //get search term
    $searchTerm = $_GET['term'];

    //get matched data from skills table
    $query = $db->query("SELECT * FROM blog_post WHERE postTitle LIKE '%".$searchTerm."%' ORDER BY postTitle ASC");
    while ($row = $query->fetch()) {
        $data[] = $row['postTitle'];
    }

    //return json data
    echo json_encode($data);
?>
