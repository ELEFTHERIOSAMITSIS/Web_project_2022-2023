<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">



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
    <div id="leaderboard">
    <h1 id="header">LEADERBOARD</h1>
    <ul id="itemList">
    </ul>
 

    </div>
    <script src="leaderboard.js"></script> 
</body>