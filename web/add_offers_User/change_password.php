<?php
session_start();

    $loggedInUser = $_SESSION['Username'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['currentPassword']) && isset($_POST['newPassword'])) {
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];

        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{8,}$/", $newPassword)) {
            echo '<p style="color:red;">';
            echo "Password must have at least one uppercase letter, one symbol, one number, and be at least 8 characters long.";
            echo '</p>';
        } else {
            include '../get_from_db/db.php'; 

            $sql = "SELECT Pass FROM User WHERE Username = '$loggedInUser'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $storedPassword = $row['Pass'];

                if ($currentPassword !== $storedPassword) {
                    echo '<p style="color:red;">';
                    echo "Current password is incorrect.";
                    echo '</p>';
                } else {
                $updateSql = "UPDATE User SET Pass = '$newPassword' WHERE Username = '$loggedInUser'";
                
                if (mysqli_query($conn, $updateSql)) {
                    header("Location: ../login_register/log_in.php");
                    exit();
                } else {
                    echo "Error updating password: " . mysqli_error($conn);
                }
            }
        }
             else {
                echo '<p style="color:red;">';
                echo "User not found.";
                echo '</p>';
            }
        }
    }
?>