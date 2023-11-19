<?php
    session_start();

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
	}


?>