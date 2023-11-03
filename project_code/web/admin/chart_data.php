<?php
include '../get_from_db/db.php';

if (isset($_POST['category']) && isset($_POST['subcategory'])) {
    $selectedCategory = $_POST['category'];
    $selectedSubcategory = $_POST['subcategory'];

    $diff=0.00;
    $discounts=array();
    $dataset=array();
    $products_values=array();
    $temp=0.00;
    $i=0;
//AND Prices.price_date >= DATE_SUB(NOW(), INTERVAL 1 WEEK) NA PROSTETHEI STA QUERYS
    if($selectedSubcategory!=null){
        $query1 = "SELECT
        Products.Product_name,
        SUM(Prices.Price) AS TotalPrice,
        COUNT(Prices.Product_name) AS NumberOfInsertions
        FROM Prices
        INNER JOIN Products
        ON Prices.Product_name = Products.Product_name
        WHERE
        Products.Category = '$selectedCategory'
        AND Products.SubCategory = '$selectedSubcategory'
        AND Prices.price_date >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)
        GROUP BY
        Products.Product_name ";
        
        $result1 = mysqli_query($conn, $query1);
        while ($row = mysqli_fetch_assoc($result1)) {
            $productName = $row['Product_name'];
            $totalPrice = $row['TotalPrice'];
            $numberOfInsertions = $row['NumberOfInsertions'];
            $temp=$totalPrice / $numberOfInsertions;
            $temp_form = number_format($temp, 2);
            $products_values[$i] = array(
                'productName' => $productName,
                'M_timi' => $temp_form
            );
            $i++;
            
        }
        $query2 = "SELECT DISTINCT
        Offers.Product, DATE_FORMAT(Offers.created_at, '%m/%d/%y') AS formatted_created_at, Offers.Price
        FROM Offers
        INNER JOIN Products
        ON Offers.Product = Products.Product_name
        INNER JOIN Prices
        ON Products.Product_name = Prices.Product_name
        WHERE
        Products.Category = '$selectedCategory'
        AND Products.SubCategory = '$selectedSubcategory'
        AND WEEK(Offers.created_at) = WEEK(NOW())";
    
        $i=0;
        $result2=mysqli_query($conn, $query2);
        while ($row = mysqli_fetch_assoc($result2)) {
        $Date = $row['formatted_created_at'];
        $Discount = $row['Price'];
        $Product= $row['Product'];
        for ($j = 0; $j < count($products_values); $j++) {
            foreach ($products_values[$j] as $key => $value) {
                if ($key == 'productName' && $value == $Product) {
                    $diff = $products_values[$j]['M_timi'] - $Discount;
                    $m_timi=$products_values[$j]['M_timi'];
                    $diff_form = number_format($diff, 2);
                }
            }
        }

        $discounts[$i]=array(
            'date' => $Date,
            'difference' => $diff_form ,
            'm_timi' => $m_timi
        );
        $i++;
        
    }
    

    $discountsByDate = []; 
    $diffCount = []; 
    for ($i = 0; $i < count($discounts); $i++) {
        $Date = $discounts[$i]['date']; 
        $diff = $discounts[$i]['difference'];
        $timi = $discounts[$i]['m_timi'];
    
        if (isset($discountsByDate[$Date])) {
            $discountsByDate[$Date]['sum'] += $diff;
            $discountsByDate[$Date]['count']++; 
            $discountsByDate[$Date]['names']= $timi;
        } else {
            $discountsByDate[$Date] = [
                'sum' => $diff,
                'count' => 1,
                'timi' => $timi 
            ];
        }
    }
    
    $dataset = [];
    
    foreach ($discountsByDate as $date => $data) {
        $sum = $data['sum'];
        $count = $data['count'];
        $average = $count > 0 ? (($sum / $count) * 100)/$data['timi'] : 0; 
    
        $dataset[] = [
            'date' => $date,
            'sum' => $sum,
            'count' => $count,
            'average' => number_format($average, 2)
        ];
    }
    


    echo json_encode($dataset);
}
else if($selectedCategory!=null && $selectedSubcategory==null){
    $query1 = "SELECT
    Products.Product_name,
    SUM(Prices.Price) AS TotalPrice,
    COUNT(Prices.Product_name) AS NumberOfInsertions
    FROM
        Prices
        INNER JOIN
        Products
    ON
        Prices.Product_name = Products.Product_name
    WHERE
    Products.Category = '$selectedCategory'
    AND Prices.price_date >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)
    GROUP BY
        Products.Product_name ";

    $result1 = mysqli_query($conn, $query1);
    while ($row = mysqli_fetch_assoc($result1)) {
        $productName = $row['Product_name'];
        $totalPrice = $row['TotalPrice'];
        $numberOfInsertions = $row['NumberOfInsertions'];
        $temp=$totalPrice / $numberOfInsertions;
        $temp_form = number_format($temp, 2);
        $products_values[$i] = array(
            'productName' => $productName,
            'M_timi' => $temp_form
        );
        $i++;
        
    }
    $query2 = "SELECT DISTINCT
    Offers.Product,
    DATE_FORMAT(Offers.created_at, '%m/%d/%y') AS formatted_created_at,
    Offers.Price
    FROM
        Offers
    INNER JOIN
        Products
    ON
        Offers.Product = Products.Product_name
    INNER JOIN
        Prices
    ON
        Products.Product_name = Prices.Product_name
    WHERE
        Products.Category = '$selectedCategory'
        AND WEEK(Offers.created_at) = WEEK(NOW())";

    $i=0;
    $result2=mysqli_query($conn, $query2);
    while ($row = mysqli_fetch_assoc($result2)) {
        $Date = $row['formatted_created_at'];
        $Discount = $row['Price'];
        $Product= $row['Product'];
        for ($j = 0; $j < count($products_values); $j++) {
            foreach ($products_values[$j] as $key => $value) {
                if ($key == 'productName' && $value == $Product) {
                    $diff = $products_values[$j]['M_timi'] - $Discount;
                    $m_timi=$products_values[$j]['M_timi'];
                    $diff_form = number_format($diff, 2);
                }
            }
        }

        $discounts[$i]=array(
            'date' => $Date,
            'difference' => $diff_form ,
            'm_timi' => $m_timi
        );
        $i++;
        
    }
    

    $discountsByDate = []; 
    $diffCount = []; 

    for ($i = 0; $i < count($discounts); $i++) {
        $Date = $discounts[$i]['date']; 
        $diff = $discounts[$i]['difference'];
        $timi = $discounts[$i]['m_timi'];
    
        if (isset($discountsByDate[$Date])) {
            $discountsByDate[$Date]['sum'] += $diff;
            $discountsByDate[$Date]['count']++; 
            $discountsByDate[$Date]['names']= $timi; 
        } else {
            $discountsByDate[$Date] = [
                'sum' => $diff,
                'count' => 1, 
                'timi' => $timi 
            ];
        }
    }
    
    $dataset = [];
    
    foreach ($discountsByDate as $date => $data) {
        $sum = $data['sum'];
        $count = $data['count'];
        $average = $count > 0 ? (($sum / $count) * 100)/$data['timi'] : 0; 
    
        $dataset[] = [
            'date' => $date,
            'sum' => $sum,
            'count' => $count,
            'average' => number_format($average, 2)
        ];
    }
    


    echo json_encode($dataset);
}


} else {
    echo json_encode(['error' => 'Category and subcategory not provided']);
}

?>