<?php
include '../get_from_db/db.php'
?>


<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $jsonData = file_get_contents('php://input');

    $data = json_decode($jsonData, true);

    $valuePlaceholders = [];
        
        foreach ($data['data'] as $product) {
            $productName = $product['name'];

            foreach ($product['prices'] as $price) {
                $priceDate = $price['date'];
                $priceValue = $price['price'];

                $valuePlaceholders[] = "('$productName', '$priceDate', '$priceValue')";
            }
        }
       
        // Construct the SQL query using implode
        $sql = "INSERT INTO Prices (Product_name, price_date, Price) 
                VALUES " . implode(", ", $valuePlaceholders);
        
        mysqli_query($conn, $sql);

        
       
}
?>
