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
         
        $queryLibrary = "SELECT game_id, title, summary, platform, release_date, genres, rating FROM games WHERE genres LIKE ? LIMIT 10";
        $pattern = '%'. $genreUser . '%';
        
        $resultLibrary = $conn->prepare($queryLibrary);
        $resultLibrary->bind_param('s', $pattern);
        $resultLibrary->execute();
        $resultLibrary->bind_result($game_id, $title, $summary, $platform, $release_date, $genres, $rating);
    
        echo "<h2>Games from Your Favourite Genre</h2>\n";
        echo "<div class = 'card-container'>\n";
        while ($resultLibrary->fetch()) {
            echo "<div class='card'>";
            echo "<h3>$title</h3>";
            echo "<p class='description'>$summary</p>";
            echo "<p>Release Date: $release_date</p>";
            echo "<p>Genres: $genres</p>";
            echo "<a href=\"gamedetails.php?game_id=$game_id\">View Game Details </a>";
            echo "</div>";
        }
        $resultLibrary->close();

        $selectedYear = '2023';
        $queryLatest = "SELECT game_id, title, summary, platform, genres, rating FROM games WHERE release_date LIKE ? LIMIT 10";
        $pattern = '%' . $selectedYear . '%';

        $resultLatest = $conn->prepare($queryLatest);
        $resultLatest->bind_param('s', $pattern);
        $resultLatest->execute();
        $resultLatest->bind_result($game_id, $title, $summary, $platform, $genres, $rating);

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