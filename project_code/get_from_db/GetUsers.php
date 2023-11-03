<?php
include 'db.php'
?>

<?php
$query = "SELECT * FROM User WHERE Score > 0 ORDER BY Score DESC";
$result = mysqli_query($conn, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

mysqli_close($conn);

header("Content-Type: application/json");
echo json_encode($data);

?>