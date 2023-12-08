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
            <!-- check if user login, show differenrt options based on user status -->
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
    if(isset($_SERVER['HTTPS']) &&  $_SERVER['HTTPS']== "on") {
		header("Location: http://" . $_SERVER['HTTP_HOST'] .
			$_SERVER['REQUEST_URI']);
		exit();
	}

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

    //query to get the data from products table and display on the page
    $query = "SELECT game_id, title FROM games";
    $result = $conn->query($query);

    echo "<h2>All Games</h2>";

    echo "<ul class = 'modellist'>";

    //display the data get from query 
    while ($row = $result->fetch_row()) {
        echo "<li>";
        echo "<a href=\"modeldetails.php?game_id=$row[0]\">$row[1]</a>";
        echo "</li>\n";
    };
    echo "</ul>";

    $conn->close();
?>
</div>