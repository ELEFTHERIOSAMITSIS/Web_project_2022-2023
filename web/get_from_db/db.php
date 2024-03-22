<?php

if($_SERVER ["REQUEST_METHOD"]=="POST" || "GET"){
$servername = "localhost";
$username = "root";
$password = "sarantis159263";
$dbname = "WEB";

$conn = mysqli_connect($servername,$username,$password,$dbname);
  if ($conn)
    {
      //echo "Connection Established! <br>";
    }
  else
    {
      die("Connection failed");   
    }

  }
?>