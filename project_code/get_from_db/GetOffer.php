<?php
session_start();

include 'db.php';

$person_id = $_SESSION['PersonID']; 

$query = "SELECT Score, First_name, Last_name,Likes,Dislikes,Apothema,Product,Price,Shop_id,offer_id,Pusername,Category
FROM Offers 
JOIN User ON Offers.Pusername = User.Username";
$result = mysqli_query($conn, $query);


$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

mysqli_close($conn);


header("Content-Type: application/json");
echo json_encode($data);

?>
