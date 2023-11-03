<?php
include 'db.php'
?>

<?php


$query = "SELECT Score, First_name, Last_name,Likes,Dislikes,Apothema,Product,Price
FROM Offers 
INNER JOIN User ON Offers.Pusername = User.Username";

$result = mysqli_query($conn, $query);

print_r(mysqli_num_rows($result));

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

mysqli_close($conn);

//header("Cache-Control: max-age=300");
header("Content-Type: application/json");
echo json_encode($data);

?>
