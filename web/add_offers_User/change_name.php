<?php
session_start();
    $loggedInUser = $_SESSION['Username'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newUsername'])) {
        $newUsername = $_POST['newUsername'];

        include '../get_from_db/db.php'; 

        $checkSql = "SELECT * FROM User WHERE Username = '$newUsername'";
        $checkResult = mysqli_query($conn, $checkSql);

        if (mysqli_num_rows($checkResult) > 0) {
            echo '<p style="color:red;">';
            echo "Username already taken.";
            echo '</p>';
        } else {
            $updateSql = "UPDATE User SET Username = '$newUsername' WHERE Username = '$loggedInUser'";
            if (mysqli_query($conn, $updateSql)) {
                $_SESSION['Username'] = $newUsername; 
                header("Location: profile.php");
                exit();
            } else {
                echo "Error updating username: " . mysqli_error($conn);
            }
        }
    }
 else {
    header("Location: ../login_register/log_in.php");
    exit();
}
?>