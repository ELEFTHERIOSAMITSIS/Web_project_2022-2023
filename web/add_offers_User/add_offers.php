<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/client.css">
    <link rel="stylesheet"href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css">
    

</head>
<body>
    <div id="Up">
        <button id="signout" class="up_butts" style="position:absolute; bottom:5%; right:2%;">SignOut</button>
        <script>
            const signout=document.getElementById("signout");
            signout.addEventListener("click",function(){   
                if (confirm("Are you sure you want to logout?")) {
                window.location.href = "../login_register/log_in.php";
            } else {
                
            }                            
            });
        </script>
    </div>
    <div id="offers_place">
        <div id="map"></div>

        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
        
    </div>
    <div id="close" class="instractions">
    
        <h1 style="font-size:22px; text-align:center;">Pick a store to add an offer</h1>
        <select class="select_place" id="Search_name">
        <option value="All">Select Store Name</option>    
        </select>
        <select class="select_place" id="Search_Category">
        <option value="All">Select offer Category</option>    
        </select>
    </div>
        <style>
            .instractions{
                height: 720px;
                width: 600px;
                position: absolute;
                right: 66%;
                top: 23%;
                background-color : rgb(255, 255, 255);
            }
        </style>

<div id="name-box">
        <?php
            echo "Welcome, " . $_SESSION['Username'];
        ?>
    </div>
    <div id="button-container">
        <button class="button">Επεξεργασία Προφίλ</button>         
    </div>    
    <script src="client_map.js"></script>


</body>