<?php
// Database connection code here
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

// Fetch products based on selected category
if (isset($_POST['genre'])) {
    $genre = $_POST['genre'];

    $query = "SELECT * FROM video_games_2022";

    if (!empty($genre)) {
        $query .= " WHERE Genre = '$genre'";
    }

    // Execute the query and fetch products
    // Implement your database connection and query execution code here
    // Example:
    $result = $conn->query($query);

    // Display the filtered products
    while ($row = $result->fetch_assoc()) {
        echo "<div>{$row['Title']}</div>";
    }
}
?>