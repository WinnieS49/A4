<?php
// include header and functions
include('include/functions.php');

// create connection
$conn = connectToDatabase();

//pages
$itemsPerPage = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

// Fetch games based on selected genre, platform, year, and rating
if (isset($_POST['genre']) || isset($_POST['platform']) || isset($_POST['year']) || isset($_POST['rating'])) {
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

    //count total results
    $countQuery = "SELECT COUNT(*) AS total FROM ($query) AS subquery";
    $countResult = $conn->query($countQuery);
    $totalResults = $countResult->fetch_assoc()['total'];

    $query .= " LIMIT $itemsPerPage OFFSET $offset";

    $result = $conn->query($query);

    // Display the filtered games
    while ($row = $result->fetch_assoc()) {
        echo "<div><a class='filtered-game-link' href='gamedetails.php?game_id={$row['game_id']}'>{$row['title']}</a></div>";
    }

    $totalPages = ceil($totalResults / $itemsPerPage);
    // Display "Previous" link
    if ($page > 1) {
        $prevPage = $page - 1;
        echo "<a href='?page=$prevPage&genre=$genre&platform=$platform&year=$year&rating=$rating'>Previous</a>";
    }

    // Display current page number
    echo "<span>Page $page of $totalPages</span>";

    // Display "Next" link
    if ($page < $totalPages) {
        $nextPage = $page + 1;
        echo "<a href='?page=$nextPage&genre=$genre&platform=$platform&year=$year&rating=$rating'>Next</a>";
    }

}
?>
