<?php
// filter_games.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('include/functions.php');
$conn = connectToDatabase();

// Get the selected genre and platform from the AJAX request
$selectedGenre = isset($_GET['genre']) ? $_GET['genre'] : '';
$selectedPlatform = isset($_GET['platform']) ? $_GET['platform'] : '';

// Construct the SQL query based on selected filters
$sql = "SELECT game_id, title FROM games WHERE 1";

if ($selectedGenre !== '') {
    $sql .= " AND genre = '$selectedGenre'";
}

if ($selectedPlatform !== '') {
    $sql .= " AND platform = '$selectedPlatform'";
}

// You can add more conditions for other filters as needed

// Limit the number of results (adjust as needed)
$sql .= " LIMIT 10";

// Execute the query
$result = $conn->query($sql);

// Prepare the data for JSON response
$filteredGames = array();

while ($row = $result->fetch_assoc()) {
    $filteredGames[] = $row;
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($filteredGames);

// Close the database connection
$conn->close();
?>
