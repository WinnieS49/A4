<?php
    if(isset($_SERVER['HTTPS']) &&  $_SERVER['HTTPS']== "on") {
		header("Location: http://" . $_SERVER['HTTP_HOST'] .
			$_SERVER['REQUEST_URI']);
		exit();
	}
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

    if(isset($_SESSION['valid_user'])){ //if user is logged in and this model is not in watchlsit
        $email = $_SESSION['valid_user'];
        $query = "SELECT 1 FROM watchlist WHERE productCode=? AND email=? LIMIT 1";
        $res = $conn->prepare($query);
        $res->bind_param('ss', $prodCode, $email);
        $res->execute();
        $res->store_result();
        if($res->num_rows == 0){
            $res->close();
            //form to add to watchlist
            echo "<form action=\"addtowatchlist.php\" method=\"post\">\n";
	        echo "<input type=\"hidden\" name=\"productCode\" value=$prodCode>\n";
	        echo "<input type=\"submit\" value=\"Add To Watchlist\">\n";
	        echo "</form>\n";
        }else $res->close();
    }
    $conn->close();
?>
