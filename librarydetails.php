<!-- include header and functions -->
<?php include('include/header.php'); ?>
<?php include('include/functions.php'); ?>

<div class = 'container'>

<?php
// check if library_id is provided in the URL
if (isset($_GET['library_id'])) {
    $libraryId = $_GET['library_id'];

    // redirect to HTTP if not secure
    redirectToHttp();

    // connect to the database
    $conn = connectToDatabase();

    if(!isset($_SESSION['valid_user'])) { //not logged in
        $_SESSION['callback_url'] = 'mylibrary.php';
        header('Location: ' . 'login.php');
        exit(); 
    } 

    // query to get library details based on library_id
    $libraryQuery = "SELECT * FROM librarylist WHERE library_id = '$libraryId'";
    $libraryResult = $conn->query($libraryQuery);

    // check if the query for library details was successful
    if ($libraryResult && $libraryResult->num_rows > 0) {
        // query to get game titles associated with the library
        $gameQuery = "SELECT games.title FROM games
                      JOIN librarylist ON games.game_id = librarylist.game_id
                      WHERE librarylist.library_id = '$libraryId'";
        $gameResult = $conn->query($gameQuery);

        // check if the query for game titles was successful
        if ($gameResult && $gameResult->num_rows > 0) {
            echo "<h3>Games in this Library</h3>";
            echo "<ul>";
            while ($gameRow = $gameResult->fetch_assoc()) {
                echo "<li>{$gameRow['title']}</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No games in this library.</p>";
        }

    } else {
        echo "Library not found.";
    }

    // close the database connection
    $conn->close();
} else {
    echo "Library ID not provided.";
}

?>
