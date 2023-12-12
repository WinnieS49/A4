<!-- include header and functions -->
<?php include('include/header.php'); ?>
<?php include('include/functions.php'); ?>

<div class = 'container'>
<?php
    redirectToHttp();
    $conn = connectToDatabase();


    //retrieve gameid from url
    $game_id = $_GET['game_id'];
    $query = "SELECT * FROM games WHERE game_id = ?"; 
    $result = $conn->prepare($query);
    $result->bind_param('s', $game_id);
    $result->execute();
    $result->bind_result($gmId, $title, $release_date, $developer, $summary, $platform, $genres, $rating, $plays, $playing, $backlogs, $wishlist, $lists, $reviews );

    //display results
    if($result->fetch()){
        echo "<h3>$title</h3>\n";
        echo "<p>Release Date: $release_date </p>\n";
        echo "<p>Developer: $developer </p>\n";
        echo "<p>Platforms: $platform </p>\n";
        echo "<p>Genres: $genres </p>\n";
    }

    //release results
    $result->free_result();

    if (isset($_SESSION['valid_user'])) { //if logged in
        $username = $_SESSION['valid_user'];

        $query = "SELECT library_id, library_name FROM library WHERE user_id = ?";
        $result = $conn->prepare($query);
        $result->bind_param('s',$username);
        $result->execute();
        $res = $result->get_result();

        // Check if the query was successful
        if ($result) {
            echo "<form action=\"addtomylibrary.php\" method=\"post\">\n"; 
            echo "<input type=\"hidden\" name=\"game_id\" value=$gmId>\n";
            echo "<label for=\"library_id\">Select Library:</label>\n";
            echo "<select name=\"library_id\" id=\"library_id\">\n";

            // Loop through the result set to populate the dropdown
            while ($row = $res->fetch_assoc()) {
                $libraryId = $row['library_id'];
                $libraryName = $row['library_name'];
                echo "<option value=\"$libraryId\">$libraryName</option>\n";
            }
        }

        echo "</select>\n";
        echo "<input type=\"submit\" value=\"Add To Library\">\n";
        echo "</form>\n";

        $res->close();
    }

    if (isset($_GET['message'])) {
        $message = $_GET['message'];
        if($message == 'success'){
            echo "Game has been successfully added to your library.";
        }else if($message == 'exists'){
            echo "Game is already in your library.";
        }
    }

    // Free result set

    $conn->close();
?>
</div>

