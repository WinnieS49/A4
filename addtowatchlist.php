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

    $productCode = !empty($_POST['productCode']) ? $_POST['productCode'] : "";
    $email = "";

	if (isset($_SESSION['valid_user'])) {
        $email = $_SESSION['valid_user'];
		$query = "SELECT COUNT(*) FROM watchlist WHERE productCode=? AND email=?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param('ss', $prodCode, $email);
		$stmt->execute();
		$stmt->bind_result($count);
	    if($stmt->fetch() && $count == 0){
            $query = "INSERT INTO watchlist (email, productCode) VALUES (?, ?)";
            $values = [$email, $productCode];
        
            $stmt->close();
            $res = $conn->prepare($query);
            $res->bind_param('ss', ...$values);
            $res->execute();       
            echo "The model has been added to your <a href=\"watchlist.php\">watchlist</a>.";
        }else
        echo "Models is already in your watchlist <a href=\"watchlist.php\">watchlist</a>.";
	}


?>