<?php
session_start();

include '../get_from_db/db.php';

$name1 = $_SESSION['Username'];
$mail = $_SESSION['Email'];
$fname = $_SESSION['First_Name'];
$lname = $_SESSION['Last_Name'];
$score = $_SESSION['score'];
$total_score = $_SESSION['total_score'];
$tokens = $_SESSION['tokens'];
$total_tokens = $_SESSION['total_tokens'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Επεξεργασία Προφίλ</title>
    <link rel="stylesheet" type="text/css" href="../css/profile.css">
</head>
<body>
<div class="box">
    <h2>Στοιχεία Χρήστη</h2>
    <?php
    echo "Username: " .$name1 . "<br>";
    echo "Email: " .$mail . "<br>";
    echo "Όνομα: " .$fname . "<br>";
    echo "Επίθετο: " .$lname . "<br>";
    echo "Monthly Score: " .$score . "<br>";
    echo "Total Score: " .$total_score . "<br>";
    echo "Monthly Tokens: " .$tokens . "<br>";
    echo "Total Tokens: " .$total_tokens . "<br>";
    ?>
</div>
<button id="signout" class="up_butts" style="position:absolute; bottom:2%; right:2%;">SignOut</button>
        <script>
            const signout=document.getElementById("signout");
            signout.addEventListener("click",function(){   
                if (confirm("Are you sure you want to logout?")) {
                window.location.href = "../login_register/log_in.php";
            } else {
                
            }                            
            });
        </script>
<div class="settings">
    <h2>Άλλαξε Όνομα Χρήστη</h2>
    <form action="change_name.php" method="POST">
        <p id="newUsername">Νέο Όνομα Χρήστη:</p>
        <input type="text" name="newUsername" required><break>
        <input type="submit" value="Change Username">
    </form>

    <h2>Άλλαξε Κωδικό Πρόσβασης</h2>
    <form action="change_password.php" method="POST">
        <p id="currentPassword">Τρέχων Κωδικός Πρόσβασης:</p>   
        <input type="password" name="currentPassword" required>
        <p id="newPassword">Νεός Κωδικός Πρόσβασης:</p> 
        <input type="password" name="newPassword" required><break>
        <input type="submit" value="Change Password">
    </form>
</div>
   
<div class="offers-box">
<h2>Οι Προσφορές Σας</h2>
<div class="offer-list">
    <?php
        $sql = "SELECT * FROM Offers WHERE Pusername = '$name1'";     
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            echo "<ul>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li>Product: " . $row['Product'] . " | Price: " . $row['Price'] . " | Shop: " . $row['shop_name'] . " | Shop-ID: " . $row['Shop_id'] . " | Datetime: " . $row['created_at'] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Δεν έχετε κάνει καμία προσφορά ακόμα.</p>";
        }
    ?>
</div>
</div>

    <div class="like-box">
        <h2>Ιστορικό like/dislike</h2>
        <div class="offer-list">
        <?php
            $person_id = $_SESSION['PersonID'];
            $sql1 = "SELECT Product, Category, SubCategory, Price, Shop_name, Click1 AS Action
            FROM Offers 
            JOIN LikesDislikes ON LikesDislikes.offer_id = Offers.offer_id
            WHERE person_id = '$person_id';";     
            $result1 = mysqli_query($conn, $sql1);

            if ($result1 && mysqli_num_rows($result1) > 0) {
                echo "<ul>";
                while ($row = mysqli_fetch_assoc($result1)) {
                    echo "<li>Action: " . $row['Action'] . " | Product: " . $row['Product'] . " | Price: " . $row['Price'] . " | Shop: " . $row['Shop_name'] ."</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Δεν έχετε κάνει like ή dislike.</p>";
            }
        ?>
    </div>
    </div>   

    <script type="text/JavaScript" src="profile.js"></script>
</body>
</html>