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
            <li class="menu-item"><a href="homepage.php">Home</a></li>
            <li class="menu-item"><a href="watchlist.php">Library</a></li>
            <!-- check if user login, show different options based on user status -->
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
    if($_SERVER['HTTPS'] != "on") {
            header("Location: https://" . $_SERVER['HTTP_HOST'] .
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
?>