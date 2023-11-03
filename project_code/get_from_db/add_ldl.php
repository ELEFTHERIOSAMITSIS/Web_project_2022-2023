<?php
session_start();
include 'db.php';


$shop = $_POST['shop'];
$prod_name = $_POST['product'];
$likes = $_POST['likes'];
$dislikes = $_POST['dislikes'];
$apothema=$_POST['apothema'];
$offer_id=$_POST['offer_id'];
$user=$_POST['user'];
$person_id = $_SESSION['PersonID']; 
$click1 = $_POST['Click1'];

print_r($_POST);

$sql_select = "SELECT * FROM Offers WHERE offer_id = '$offer_id'";
$result = mysqli_query($conn, $sql_select);
$last_ldl = mysqli_fetch_assoc($result);
$likes_before = $last_ldl['Likes'];
$dislikes_before = $last_ldl['Dislikes'];

$points_query1= "SELECT score from User where Username='$user'";
$points_exec = mysqli_query($conn, $points_query1);
$points_row = mysqli_fetch_assoc($points_exec);
$points=$points_row['score'];

$points_query2= "SELECT total_score from User where Username='$user'";
$points_exec2 = mysqli_query($conn, $points_query2);
$points_row2 = mysqli_fetch_assoc($points_exec2);
$points2=$points_row2['total_score'];

$check_like="SELECT * FROM LikesDislikes WHERE person_id= $person_id AND offer_id= $offer_id "; 
$res=mysqli_query($conn, $check_like);

if(mysqli_num_rows($res) == 0){

if($likes>$likes_before){
    $points=$points+5;
    $points2=$points2+5;

    $new_points="UPDATE User SET score='$points', total_score='$points2' where Username= '$user' "; 
     mysqli_query($conn, $new_points);
}
else if($dislikes>$dislikes_before){
    if($points>=1){
    $points=$points-1;
    $points2=$points2-1;

    $new_points="UPDATE User SET score='$points', total_score='$points2' where Username= '$user' "; 
     mysqli_query($conn, $new_points);}
    else {
    $points=0;
    $new_points="UPDATE User SET Score='$points' where Username= '$user' "; 
     mysqli_query($conn, $new_points);}    
    }
else{

}
}


if (mysqli_num_rows($result) > 0 ) {
    $sql_update = "UPDATE Offers SET Likes = '$likes', Dislikes = '$dislikes', Apothema='$apothema' WHERE offer_id = '$offer_id'";
    mysqli_query($conn, $sql_update);
    echo "Data updated successfully.";
} else {
    echo "No matching data found.";
}
        
if(mysqli_num_rows($res) == 0) {
    $insertQuery = "INSERT INTO LikesDislikes (offer_id, person_id, Click1) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertQuery);

    mysqli_stmt_bind_param($stmt, "iis", $offer_id, $person_id, $click1);
    mysqli_stmt_execute($stmt);
} else if(mysqli_num_rows($res) > 0) {
    $insertQuery = "UPDATE LikesDislikes SET Click1=? WHERE person_id=? AND offer_id=?";
    $stmt = mysqli_prepare($conn, $insertQuery);

    mysqli_stmt_bind_param($stmt, "sii", $click1, $person_id, $offer_id);
    mysqli_stmt_execute($stmt);
}


?>
