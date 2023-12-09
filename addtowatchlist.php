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
        </ul>
        <div class = 'container'>

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
    $game_id = !empty($_POST['game_id']) ? $_POST['game_id'] : "";
    $library_id = !empty($_POST['libraryID']) ? $_POST['libraryID'] : "";

    $username = "";

	if (isset($_SESSION['valid_user'])) { //if logged in
        $username = $_SESSION['valid_user'];
		$query = "SELECT COUNT(*) FROM librarylist WHERE library_id=? AND game_id = ?";
		$result = $conn->prepare($query);
		$result->bind_param('ss',$library_id, $game_id);
		$result->execute();
		$result->bind_result($count);
        //check if it exists in watchlist
	    if($result->fetch() && $count == 0){
            //add to watchlist table
            $query = "INSERT INTO librarylist (library_id, game_id) VALUES (?, ?)";
            $values = [$library_id, $game_id];
        
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
</div>