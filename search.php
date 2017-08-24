
<?php
    //database configuration
    include('includes/config.php');
    //connect with the database
    //echo "y0";
    $db = new mysqli("localhost","root","","blogdb");

    //get search term
    $searchTerm = $_GET['term'];

    //get matched data from skills table
    $query = $db->query("SELECT * FROM blog_post WHERE postTitle LIKE '%".$searchTerm."%' ORDER BY postTitle ASC");
    while ($row = $query->fetch_assoc()) {
        $data[] = $row['postTitle'];
    }

    //return json data
    echo json_encode($data);
?>