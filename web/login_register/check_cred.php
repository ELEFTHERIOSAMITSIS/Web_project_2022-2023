<?php
include '../get_from_db/db.php'
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/register.css">
</head>
<body id="finish_body">
<div id="complete_div">
<?php
    $email=$_POST["Email"];
    $pass=$_POST["Pass"];
    $first=$_POST["First_Name"];
    $last=$_POST["Last_Name"];
    $user=$first."_".$last;
    if(preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',$email)&& !preg_match('/\s/', $email))
    {
        if(preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+<>?]).*$/',$pass))
        {
            echo "Good Job your username is "+$user;
            $sql="INSERT INTO User(Username,Pass,Email,First_Name,Last_Name) Values('$user','$pass','$email','$first','$last') " ;
            mysqli_query($conn, $sql);        }
        else
        {
            echo '<p style="color:red;">';
            echo "This is not a valid password";
            echo "</p>";
        }
    }
    else {
            echo '<p style="color:red;">';
            echo "This is not a valid email";
            echo "</p>";}
    ?>
    <a id="register_a" href="log_in.php" ><br> Log In <br> </a>
</div>
</body>



