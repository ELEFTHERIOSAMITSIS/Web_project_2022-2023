<?php
include 'db.php';
?>

<?php

header("Cache-Control: max-age=604800, public");

$query = "SELECT * FROM Products";
$result = mysqli_query($conn, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

mysqli_close($conn);

header("Content-Type: application/json");
echo json_encode($data);

?>

