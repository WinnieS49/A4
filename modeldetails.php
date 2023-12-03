<!-- navigation bar -->
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Classic Models</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <ul class="menu-bar">
            <li class="menu-item"><a href="showmodels.php"> All Models</a></li>
            <li class="menu-item"><a href="watchlist.php">Watchlist</a></li>
            <!-- check if user login, show differenrt options based on user status -->
            <?php
            session_start();
            if (isset($_SESSION['valid_user'])){
                echo "<li class='menu-item'><a href='logout.php'>Logout</a></li>";
            }else{
                echo "<li class='menu-item'><a href='login.php'>Login</a></li>";
            }

            ?>
        </ul>
        <div class = pad>
            <?php
                if(isset($_SERVER['HTTPS']) &&  $_SERVER['HTTPS']== "on") {
                    header("Location: http://" . $_SERVER['HTTP_HOST'] .
                        $_SERVER['REQUEST_URI']);
                    exit();
                }

                $servername = "localhost";
                $username = "root"; //login with root
                $password = "";
                $dbname = "classicmodels"; //classicmodels.sql
                
                //create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                
                //check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                //retrieve prodCode from url
                $prodCode = $_GET['productCode'];
                $query = "SELECT * FROM products WHERE productCode = ?"; 
                $result = $conn->prepare($query);
                $result->bind_param('s', $prodCode);
                $result->execute();
                $result->bind_result($prCode,$prName,$prLine,$prScale,$prVendor,$prDesc,$prQ,$prPrice,$MSRP);

                //display results
                if($result->fetch()) {
                    echo "<h3>$prName</h3>\n";
                    echo "<p>Category: $prLine</p>\n";
                    echo "<p>Scale: $prScale</p>\n";
                    echo "<p>Vendor: $prVendor</p>\n";
                    echo "<p>Price: $prPrice</p>\n";
                    echo "<p>Description: $prDesc</p>\n";
                }

                //release results
                $result->free_result();

                
                echo "<form action=\"addtowatchlist.php\" method=\"post\">\n";
                echo "<input type=\"hidden\" name=\"productCode\" value=$prodCode>\n";
                echo "<input type=\"submit\" value=\"Add To Watchlist\">\n";
                echo "</form>\n";

                $conn->close();
            ?>
        </div>

    </body>

</html>

