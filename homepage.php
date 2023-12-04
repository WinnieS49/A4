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

    </body>
</html>

<?php

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

    //get product code to enter
    $productCode = !empty($_POST['productCode']) ? $_POST['productCode'] : "";
    $username = "";

	if (isset($_SESSION['valid_user'])) { //if logged in
        $username = $_SESSION['valid_user'];
		$query = "SELECT preferGenre FROM users WHERE username=?";
		$result = $conn->prepare($query);
		$result->bind_param('ss', $username);
		$result->execute();
		$result->bind_result($genre);
        //check if it exists in watchlist
         
            $query_str = "SELECT G.productName ";
            $query_str .= "FROM gamearchive G ";
            $query_str .= "WHERE G.genre ='$genre'";
            $res = $conn->query($query_str);
        
            echo "<h2>Games from Your Favourite Genre</h2>\n";
            echo "<ul class = modellist>\n";
            while ($row = $res->fetch_row()) {
                echo "<li>";
                echo "<a href=\"modeldetails.php?productCode=$row[0]\">$row[1]</a>";
                echo " ";
                echo "</li>\n";
            };
            echo "</ul>\n";
        
            $res->free_result();
            $conn->close();

        }else{
        echo "Models is already in your watchlist <a href=\"watchlist.php\">watchlist</a>.";
        }



?>