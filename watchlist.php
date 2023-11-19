<?php
    if($_SERVER['HTTPS'] != "on") {
            header("Location: https://" . $_SERVER['HTTP_HOST'] .
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

    if(!isset($_SESSION['valid_user'])) { //not logged in
        $_SESSION['callback_url'] = 'watchlist.php';
        header('Location: ' . 'login.php');
        exit(); 
    } 

    $email = $_SESSION['valid_user'];
    $query_str = "SELECT P.productCode, P.productName ";
    $query_str .= "FROM products P INNER JOIN watchlist W ON P.productCode = W.productCode ";
    $query_str .= "WHERE W.email ='$email'";
    $res = $conn->query($query_str);

    echo "<h2>Your Watchlist</h2>\n";
    echo "<ul>\n";
    while ($row = $res->fetch_row()) {
        echo "<li>";
        echo "<a href=\"modeldetails.php?productCode=$row[0]\">$row[1]</a>";
        echo " ";
        echo "</li>\n";
    };
    echo "</ul>\n";

    $res->free_result();
    $conn->close();
?>