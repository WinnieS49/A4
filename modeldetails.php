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

    $prodCode = $_GET['productCode'];
    $query = "SELECT * FROM products WHERE productCode = ?"; 
    $result = $conn->prepare($query);
    $result->bind_param('s', $prodCode);
    $result->execute();
    $result->bind_result($prCode,$prName,$prLine,$prScale,$prVendor,$prDesc,$prQ,$prPrice,$MSRP);

    if($result->fetch()) {
        echo "<h3>$prName</h3>\n";
        echo "<p>Category: $prLine, Scale: $prScale, Vendor: $prVendor, Price: \$$prPrice</p>\n";
        echo "<p>Description: $prDesc</p>\n";
        }
    $result->free_result();

    if(isset($_SESSION['valid_user'])){ //if user is logged in and this model is not in watchlsit

    }



    $conn->close();
?>