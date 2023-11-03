<?php
include '../get_from_db/db.php';
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <script type="text/JavaScript" src="products.js"></script>
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
    <div id="option_div">
        <div class="select_sections"> <label class="labels" for="pet-select">Choose a product category:</label>

            <select class="select" id="select_pr">
                <option value="">Please choose a category</option>
            </select>
        </div>
        <div class="select_sections2">
            <label class="labels" for="pet-select">Subcategories:</label>

            <select class="select" id="select_sub">
                <option style="color:red" value="">You must choose a categorie</option>
            </select>
        </div>
        <button id="search">Search</button>
        <input class="add_file" type="file" id="myfile" name="file">
        <button id="submit_prod" style="position: absolute; bottom:20% ; " class="button" for="myfile">Submit products</button>
        <script type="text/JavaScript" src="test_json.js"></script>
        <button id="submit_prod2" style="position: absolute; bottom:10% ; " class="button" for="myfile">Submit prices</button>
        <input class="add_file3" type="file" id="myfile2" name="file">
        <script type="text/JavaScript" src="prices.js"></script>
    </div>
</body>