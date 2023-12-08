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
    $dbname = "gamearchive"; //classicmodels.sql
    
    //create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    //check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //get product code to enter
    $productCode = !empty($_POST['productCode']) ? $_POST['productCode'] : "";
    $email = "";

	if (isset($_SESSION['valid_user'])) { //if logged in
        $email = $_SESSION['valid_user'];
		$query = "SELECT COUNT(*) FROM watchlist WHERE productCode=? AND email=?";
		$result = $conn->prepare($query);
		$result->bind_param('ss', $prodCode, $email);
		$result->execute();
		$result->bind_result($count);
        //check if it exists in watchlist
	    if($result->fetch() && $count == 0){
            //add to watchlist table
            $query = "INSERT INTO watchlist (email, productCode) VALUES (?, ?)";
            $values = [$email, $productCode];
        
            $result->close();
            $res = $conn->prepare($query);
            $res->bind_param('ss', ...$values);
            $res->execute();
            echo "Model has been added to your <a href=\"watchlist.php\">watchlist</a>.";
        }else
        echo "Models is already in your watchlist <a href=\"watchlist.php\">watchlist</a>.";
	}else{
        $_SESSION['callback_url'] = 'addtowatchlist.php';
        header('Location: ' . 'login.php');
        exit(); 
    }


?>