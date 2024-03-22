<?php
session_start();

include '../get_from_db/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST["User"];
    $pass = $_POST["Pass"];

    $sql = "SELECT * FROM User WHERE Username = '$name'";
    
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($pass === $row['Pass']) {
                $_SESSION['Username'] = $name;
                $_SESSION['PersonID'] = $row['PersonID'];
                $_SESSION['score'] = $row['score'];
                $_SESSION['Email'] = $row['Email'];
                $_SESSION['First_Name'] = $row['First_Name'];
                $_SESSION['Last_Name'] = $row['Last_Name'];
                $_SESSION['score'] = $row['score'];
                $_SESSION['tokens'] = $row['tokens'];
                $_SESSION['total_score'] = $row['total_score'];
                $_SESSION['total_tokens'] = $row['total_tokens'];
                $_SESSION['admin']= $row['adminstrator'];
                if($_SESSION['admin']=='user'){
                header("Location: ../add_offers_User/add_offers.php");
                exit();}
                else if($_SESSION['admin']=='admin'){
                    header("Location: ../admin/admin_5.php");
                    exit();}
            } else {
                echo '<p style="color:red;">';
                echo "Wrong password";
                echo "</p>";
            }
        } else {
            echo '<p style="color:red;">';
            echo "There is no such user!";
            echo "</p>";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/log_in.css">
    <script> src=src="jquery-3.6.4.min.js"</script>
    <title>Web Project</title>
</head>
<body class="body">
    
<div class="login">
<h1>Log In</h1>
<form method="POST">
 <p>Username</p>
 <input type="text" name="User" placeholder="Enter Username" required>
 <p>Password</p>
 <input type="password" name="Pass" placeholder="Enter Password" required>
 <input type="submit" name="" value="Login">  
</form>
<a id="register_a" href="register.php" > Sign up <br> </a>
</div>
</body>
</html>