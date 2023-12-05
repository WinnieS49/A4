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
            
            <!-- check if user login, show differenrt options based on user status -->
            <?php
            session_start();
            if (isset($_SESSION['valid_user'])){
                echo "<li class='menu-item'><a href='logout.php'>Logout</a></li>";
            }else{
                echo "<li class='menu-item'><a href='login.php'>Login</a></li>";
            }
            ?>

            <li class="menu-item">
            <form action="search.php" method="get">
                <input type="text" name="query" placeholder="Search...">
                <button type="submit">Search</button>
            </form>
        </li>
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
    $username = "";

	if (isset($_SESSION['valid_user'])) { //if logged in
        $username = $_SESSION['valid_user'];
        $query = "SELECT preferredGenre FROM users WHERE username=?";
        $resultUser = $conn->prepare($query);
        $resultUser->bind_param('s', $username);
        $resultUser->execute();
        $resultUser->bind_result($genreUser);
        $resultUser->fetch();
        $resultUser->close();
         
        $queryWatchlist = "SELECT Title FROM video_games_2022 WHERE Genre = ?";
        $resultWatchlist = $conn->prepare($queryWatchlist);
        $resultWatchlist->bind_param('s', $genreUser);
        $resultWatchlist->execute();
        $resultWatchlist->bind_result($title);
    
        echo "<h2>Games from Your Favourite Genre</h2>\n";
        //echo "<ul class = modellist>\n";
        while ($resultWatchlist->fetch()) {
            echo $title;
            echo "<br>";
            // echo "<li>";
            // echo "<a href=\"modeldetails.php?productCode=$row[0]\">$row[1]</a>";
            // echo " ";
            // echo "</li>\n";
        }
        $resultWatchlist->close();

        $queryLatest = "SELECT Title FROM video_games_2022 WHERE Month = ?";
        $resultLatest = $conn->prepare($queryLatest);
        $resultLatest->bind_param('s', $Month);
        $resultLatest->execute();
        $resultLatest->bind_result($title);

        
        echo "<h2>Games from Your Favourite Genre</h2>\n";
        //echo "<ul class = modellist>\n";
        while ($resultLatest->fetch()) {
            echo $title;
            // echo "<li>";
            // echo "<a href=\"modeldetails.php?productCode=$row[0]\">$row[1]</a>";
            // echo " ";
            // echo "</li>\n";
        }
    
        $resultLatest->close();

    }else{
        $selectedMonth = 'December';
        $queryLatest = "SELECT Title FROM video_games_2022 WHERE Month = ?";
        $resultLatest = $conn->prepare($queryLatest);
        $resultLatest->bind_param('s', $selectedMonth);
        $resultLatest->execute();
        $resultLatest->bind_result($games);

        
        echo "<h2>Lastest Games</h2>\n";
        //echo "<ul class = modellist>\n";
        while ($resultLatest->fetch()) {
            echo $games;
            echo "<br>";
            // echo "<li>";
            // echo "<a href=\"modeldetails.php?productCode=$row[0]\">$row[1]</a>";
            // echo " ";
            // echo "</li>\n";
        }
    
        $resultLatest->close();
    }



?>