<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no cache");
session_start(); 

include 'db.php';

if (!isset($_POST['id'], $_POST['sub_id'], $_POST['price'], $_POST['shop'], $_POST['prod_name'])) {
    echo json_encode("Your form is incomplete!");
    exit();
}

//Στοιχεία Χρήστη
$name1 = $_SESSION['Username'];

$id = $_POST['id'];
$sub_id = $_POST['sub_id'];
$price = $_POST['price'];
$shop = $_POST['shop'];
$shop_name = $_POST['shop_name'];
$prod_name = $_POST['prod_name'];
$likes = 0;
$dislikes = 0;
$apothema = true;
$response1= null;
$response2= null;

$last_price_query = "SELECT Price FROM Prices WHERE Product_name ='$prod_name' AND price_date = (SELECT MAX(price_date) FROM Prices)";
$last_price_result = mysqli_query($conn, $last_price_query);
if ($last_price_result) {
    $last_price_row = mysqli_fetch_assoc($last_price_result);
    if ($last_price_row && isset($last_price_row['Price'])) {
        $last = $last_price_row['Price'];
    } else {
        $last = 0; 
    }
} else {
    $last = 0;
}

$all_weeks_prices_query = "SELECT AVG(Price) AS 'Mesi-Timi' FROM Prices WHERE Product_name = '$prod_name' AND YEARWEEK(price_date) = YEARWEEK(DATE_SUB(NOW(), INTERVAL 1 WEEK))";
$all_weeks_price_result = mysqli_query($conn, $all_weeks_prices_query);
if ($all_weeks_price_result) {
    $all_weeks_price_row = mysqli_fetch_assoc($all_weeks_price_result);
    if ($all_weeks_price_row && isset($all_weeks_price_row['Mesi-Timi'])) {
        $last_week = $all_weeks_price_row['Mesi-Timi'];
    } else {
        $last_week = 0; 
    }
} else {
    $last_week = 0; 
}
    
$points_query1= "SELECT score from User where Username='$name1'";
$points_exec = mysqli_query($conn, $points_query1);
$points_row = mysqli_fetch_assoc($points_exec);
$points=$points_row['score'];

$points_query2= "SELECT total_score from User where Username='$name1'";
$points_exec2 = mysqli_query($conn, $points_query2);
$points_row2 = mysqli_fetch_assoc($points_exec2);
$points2=$points_row2['total_score'];

////////////////////////////////////////////////
$existingOffers = mysqli_prepare($conn, "SELECT * FROM Offers WHERE Shop_id = ? AND Product = ?");
mysqli_stmt_bind_param($existingOffers, "is", $shop, $prod_name);
mysqli_stmt_execute($existingOffers);
$result = mysqli_stmt_get_result($existingOffers);

if (mysqli_num_rows($result) > 0) {
   
    while ($existingOffer = mysqli_fetch_assoc($result)){


    if ($price <= 0.8 * $existingOffer['Price']) {
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

        $insertQuery = "INSERT INTO Offers (Category, SubCategory, Price, Shop_id, shop_name, Likes, Dislikes, Apothema, Product, Pusername) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insertQuery);

        mysqli_stmt_bind_param($stmt, "ssdissiiss", $id, $sub_id, $price, $shop, $shop_name, $likes, $dislikes, $apothema, $prod_name, $name1);
        mysqli_stmt_execute($stmt);        
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");

        $response2= "Offer with reduced price submitted successfully.";
    } else {
        exit("This offer has already been submitted.");
    } } } 
else {
    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

    $insertQuery = "INSERT INTO Offers (Category, SubCategory, Price, Shop_id, shop_name, Likes, Dislikes, Apothema, Product, Pusername) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertQuery);

    mysqli_stmt_bind_param($stmt, "ssdissiiss", $id, $sub_id, $price, $shop, $shop_name, $likes, $dislikes, $apothema, $prod_name, $name1);
    mysqli_stmt_execute($stmt);
    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");
    
    $response2= "Offer submitted successfully.";}

/////////////////////////////////////////////////////////////////
if($price<=($last-(0.2*$last))){
    $response1="Good job, you earned 50 points.";

    $points = $points + 50;
    $points2 = $points2 + 50;
    $new_points="UPDATE User SET score='$points', total_score = '$points2' where Username= '$name1' "; 
    mysqli_query($conn, $new_points);
}
else if($price<=($last_week-(0.2*$last_week))){
    $response1="Good job, you earned 20 points.";

    $points = $points + 20;
    $points2 = $points2 + 20;
    $new_points="UPDATE User SET score='$points', total_score = '$points2' where Username= '$name1' "; 
    mysqli_query($conn, $new_points);
    }
    else{
    $response1="";
    }

    echo json_encode($response2) . "\n";
    if($response1 !== null){
        echo json_encode($response1);
    }    
    
mysqli_close($conn);

?>