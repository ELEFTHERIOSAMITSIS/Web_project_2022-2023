<?php
include 'db.php'
?>

<?php
$offer_id=$_POST['id'];


$query = "DELETE FROM Offers where offer_id='$offer_id' ";
$result = mysqli_query($conn, $query);
?>