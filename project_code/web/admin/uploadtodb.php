<?php
include '../get_from_db/db.php'
?>


<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $jsonData = file_get_contents('php://input');


    $data = json_decode($jsonData, true);


    $products = $data["products"];

    foreach ($products as $product) {
        $productName = mysqli_real_escape_string($conn, $product["name"]);
        $category = mysqli_real_escape_string($conn, $product["category"]);
        $subcategory = mysqli_real_escape_string($conn, $product["subcategory"]);
        $production[] = "('$productName', '$category', '$subcategory')";
        $prices[]="('$productName')";
    }

    $sql="INSERT INTO Products (Product_name, Category, SubCategory) VALUES  " . implode(', ', $production) . " ON DUPLICATE KEY UPDATE Product_name=VALUES(Product_name), Category=VALUES(Category), SubCategory=VALUES(SubCategory)";
    mysqli_query($conn, $sql);
    //$sql1="INSERT INTO Prices(Product_name) Values" . implode(', ', $prices) . "   ON DUPLICATE KEY UPDATE Product_name=VALUES(Product_name)";
   // mysqli_query($conn, $sql1);

}
?>
