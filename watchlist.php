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
            <li class="menu-item"><a href="showmodels.php">All Games</a></li>
            <!-- check if user login, show different options based on user status -->
            <?php
            session_start();
            if (isset($_SESSION['valid_user'])){
                echo "<li class='menu-item'><a href='logout.php'>Logout</a></li>";
            }else{
                echo "<li class='menu-item'><a href='login.php'>Login</a></li>";
            }

            ?>
            <div class="search-bar">
                <form action="search.php" method="get">
                    <input type="text" name="query" placeholder="Search...">
                    <button type="submit">Search</button>
                </form>
            </div>
        </ul>
        <div class = 'container'>

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
    $dbname = "gamearchive"; //gamearchive.sql
    
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

    $username = $_SESSION['valid_user'];
    $query_str = "SELECT L.library_name ";
    $query_str .= "FROM library L INNER JOIN users U ON L.user_id = U.user_id ";
    $query_str .= "WHERE U.username ='$username'";
    $res = $conn->query($query_str);?>

    <form action="createLibrary.php" method="post">
        
        <button type="submit">Create Library</button>
    </form><br>

    <?php
    echo "<h2>My Library</h2>\n";
    echo "<ul class = modellist>\n";
    while ($row = $res->fetch_row()) {
        echo "<li>{$row['library_name']}</li>\n";
    };
    echo "</ul>\n";

    $res->free_result();
    $conn->close();
?>
</div>