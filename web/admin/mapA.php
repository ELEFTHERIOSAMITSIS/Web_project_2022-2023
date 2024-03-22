<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <link rel="stylesheet"href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css">
    <script src="upload.js"></script>


</head>
<body>
    <div id="Up">
    <button id="lead" class="up_butts" style="position:absolute; bottom:15%; left:75%;">Leaderboard</button>
        <script>
            const lead=document.getElementById("lead");
            lead.addEventListener("click",function(){   

                window.location.href = "leaderboard.php";
           
                
                                        
            });
        </script>
    <button id="poi" class="up_butts" style="position:absolute; bottom:15%; left:60%;">POIS</button>
        <script>
            const poi=document.getElementById("poi");
            poi.addEventListener("click",function(){   

                window.location.href = "mapA.php";
           
                
                                        
            });
        </script>
    <button id="off" class="up_butts" style="position:absolute; bottom:15%; left:45%;">Offers</button>
        <script>
            const off=document.getElementById("off");
            off.addEventListener("click",function(){   
               
                    window.location.href = "admin_5.php";
           
                
                                        
            });
        </script>
    <button id="signout" class="up_butts" style="position:absolute; bottom:5%; right:1%;">SignOut</button>
        <script>
            const signout=document.getElementById("signout");
            signout.addEventListener("click",function(){   
                if (confirm("Are you sure you want to logout?")) {
                window.location.href = "../login_register/log_in.php";
            } else {
                
            }                            
            });
        </script>
    <button id="chart1" class="up_butts" style="position:absolute; bottom:15%; left:15%;">Chart1</button>
        <script>
            const chart1=document.getElementById("chart1");
            chart1.addEventListener("click",function(){   
               
                window.location.href = "chart.php";                                    
            });
        </script>
        <button id="chart2" class="up_butts" style="position:absolute; bottom:15%; left:2%;">Chart2</button>
        <script>
            const chart2=document.getElementById("chart2");
            chart2.addEventListener("click",function(){   
               
                window.location.href = "chart_test.php";                                    
            });
        </script>
        <button id="prod" class="up_butts" style="position:absolute; bottom:15%; left:30%;">Products Managment</button>
        <script>
            const prod=document.getElementById("prod");
            prod.addEventListener("click",function(){   
               
                window.location.href = "products.php";                                    
            });
        </script>
    </div>
    <div id="button-container" style="position:absolute; bottom:10%; left: 1%" >
            <button id="add_tokens" class="tokens">Add Tokens</button>         
        </div>  
    <div id="products_scroll">
        <button id="submit_prod2" style="position: absolute; bottom:1% ; " class="button" for="myfile" onclick="uploadFile();" >ADD POI.json</button>
        <input class="add_file4" type="file" id="file" name="file">
        <style>
            .add_file4{
                position: absolute;
                bottom: 1%;
                left: 13%;
                width: 250px;
                height: 30px;
                font-size: 18px;
            }
        </style>
        <button id="delete_button" style="position: absolute; bottom:1% ; left:88%; " class="button" for="myfile" onclick="uploadFile();" >DELETE DATA</button>
        <div id="map"></div>


        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
        <script src="map.js"></script>

    </div>
   
</body>