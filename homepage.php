<!-- include header and functions -->
<?php include('include/header.php'); ?>
<?php include('include/functions.php'); ?>

<div class = 'container'>
<?php
    //create connection
    $conn = connectToDatabase();

    redirectToHttp();

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
         
        $queryWatchlist = "SELECT game_id, title FROM games WHERE genres LIKE ? LIMIT 10";
        $pattern = '%'. $genreUser . '%';
        
        $resultWatchlist = $conn->prepare($queryWatchlist);
        $resultWatchlist->bind_param('s', $pattern);
        $resultWatchlist->execute();
        $resultWatchlist->bind_result($game_id, $title);
    
        echo "<h2>Games from Your Favourite Genre</h2>\n";
        echo "<ul class = modellist>\n";
        while ($resultWatchlist->fetch()) {
            echo "<br>";
            echo "<li>";
            echo "<a href=\"gamedetails.php?game_id=$game_id\">$title</a>";
            echo " ";
            echo "</li>\n";
        }
        $resultWatchlist->close();

        $selectedYear = '2023';
        $queryLatest = "SELECT game_id, title FROM games WHERE release_date LIKE ? LIMIT 10";
        $pattern = '%' . $selectedYear . '%';

        $resultLatest = $conn->prepare($queryLatest);
        $resultLatest->bind_param('s', $pattern);
        $resultLatest->execute();
        $resultLatest->bind_result($game_id, $title);

        echo "<br><br>";
        echo "<h2>Lastest Games</h2>\n";
        echo "<ul class = modellist>\n";
        while ($resultLatest->fetch()) {
            echo "<br>";
            echo "<li>";
            echo "<a href=\"gamedetails.php?game_id=$game_id\">$title</a>";
            echo " ";
            echo "</li>\n";
        }
        
    
        $resultLatest->close();

    }else{
        $selectedYear = '2023';
        $queryLatest = "SELECT game_id, title FROM games WHERE release_date LIKE ? LIMIT 10";
        $pattern = '%' . $selectedYear . '%';

        $resultLatest = $conn->prepare($queryLatest);
        $resultLatest->bind_param('s', $pattern);
        $resultLatest->execute();
        $resultLatest->bind_result($game_id, $title);

        echo "<br>";
        echo "<h2>Lastest Games</h2>\n";
        echo "<ul class = modellist>\n";
        while ($resultLatest->fetch()) {
            echo "<br>";
            echo "<li>";
            echo "<a href=\"gamedetails.php?game_id=$game_id\">$title</a>";
            echo " ";
            echo "</li>\n";
        }
        
    
        $resultLatest->close();
    }

?>
</div>