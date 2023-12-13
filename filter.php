<?php
// include header and functions
include('include/functions.php');

// create connection
$conn = connectToDatabase();

//pages
$itemsPerPage = 10;
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

    // Fetch games based on selected genre, platform, year, and rating
    // Initialize variables
    $genre = isset($_POST['genre']) ? $_POST['genre'] : '';
    $platform = isset($_POST['platform']) ? $_POST['platform'] : '';
    $year = isset($_POST['year']) ? $_POST['year'] : '';
    $rating = isset($_POST['rating']) ? $_POST['rating'] : '';

    // Start the base query
    $query = "SELECT * FROM games WHERE 1";

    // Add conditions for each parameter if they are set
    if (!empty($genre)) {
        $query .= " AND genres LIKE '%$genre%'";
    }

    if (!empty($platform)) {
        $query .= " AND platform LIKE '%$platform%'";
    }

    // Add conditions for year and rating if they are set
    if (!empty($year)) {
        $query .= " AND release_date LIKE '%$year%'";
    }

    if (!empty($rating)) {
        $query .= " AND rating >= '$rating'";
    }

$query .= " LIMIT $itemsPerPage OFFSET $offset";

$countQuery = "SELECT COUNT(*) AS total FROM games WHERE 1";

// Add conditions for each parameter if they are set
if (!empty($genre)) {
    $countQuery .= " AND genres LIKE '%$genre%'";
}

if (!empty($platform)) {
    $countQuery .= " AND platform LIKE '%$platform%'";
}

// Add conditions for year and rating if they are set
if (!empty($year)) {
    $countQuery .= " AND release_date LIKE '%$year%'";
}

if (!empty($rating)) {
    $countQuery .= " AND rating >= '$rating'";
}

//count total results
$countResult = $conn->query($countQuery);
$totalResults = $countResult->fetch_assoc()['total'];


$result = $conn->query($query);

// Display the filtered games
while ($row = $result->fetch_assoc()) {
    echo "<div class='card'>";
    echo "<h3>{$row['title']}</h3>";
    echo "<p class='description'>{$row['summary']}</p>";
    echo "<p>Release Date: {$row['release_date']}</p>";
    echo "<p>Genres: {$row['genres']}</p>";
    echo "<a href=\"gamedetails.php?game_id={$row['game_id']}\">View Game Details </a>";
    echo "</div>";
    //echo "<div><a class='filtered-game-link' href='gamedetails.php?game_id={$row['game_id']}'>{$row['title']}</a></div>";
}

$totalPages = ceil($totalResults / $itemsPerPage);

// Display current page number
echo "<span>Page $page of $totalPages</span>";

?>
