<?php
session_start();
include 'db.php';

$person_id = $_SESSION['PersonID']; 

$query1 = "SELECT * from LikesDislikes Where person_id='$person_id'";
$result1 = mysqli_query($conn, $query1);


$data = array();
while ($row = mysqli_fetch_assoc($result1)) {
    $data[] = $row;
}

header("Content-Type: application/json");
echo json_encode($data);

?>