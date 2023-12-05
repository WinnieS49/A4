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
if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gamearchive";

    // create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Perform the search query
    $sql = "SELECT * FROM video_games_2022 WHERE Title LIKE '%$searchQuery%'";
    $result = $conn->query($sql);

    // Display the search results
    if ($result->num_rows > 0) {
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['Title']}</li>";
            // Display other relevant information as needed
        }
        echo "</ul>";
    } else {
        echo "<p>No results found</p>";
    }

    $conn->close(); // close the database connection
}
?>