<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/register.css">
</head>
<body id="register_body">
<div id=reg_div>
    <h1 id="test">Create your account!</h1>
    <form method="POST" action="check_cred.php">
    <p>First Name</p>
    <input type="text" name="First_Name" placeholder="First Name" required>
    <p>Last Name</p>
    <input type="text" name="Last_Name" placeholder="Last Name" required>
    <p id="Some">Email</p>
    <input type="text" name="Email" placeholder="Email" required>
    <p id="pass_txt">Password</p>
    <input type="password" name="Pass" placeholder="Enter Password" required>
    <p>Confirm Password</p>
    <input type="password" name="Confirm Pass" placeholder="Confirm Password" required>
    <input type="submit" name="" value="Register">   
    </form>
    
    <a id="register_a" href="log_in.php" ><br> Log In <br> </a>
    <script type="text/JavaScript" src="register.js"></script>
</body>