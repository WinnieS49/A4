<!-- include header and functions -->
<?php include('include/header.php'); ?>
<?php include('include/functions.php'); ?>

<div class = 'container'>

<?php
    redirectToHttp();
    $conn = connectToDatabase();

    //number of games to display per page
    $gamesPerPage = 10;

    //get the current page number from the URL
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

    //galculate the starting index for the games to display
    $startIndex = ($currentPage - 1) * $gamesPerPage;

    // Display filter options
    echo "<h3>Filter Options</h3>";
    addGenreSelection();
    addPlatformSelection();

    echo "<button onclick='applyFilters()'>Apply Filters</button>";
 
    //query to get the data from the games table and display on the page
    $query = "SELECT game_id, title FROM games LIMIT $startIndex, $gamesPerPage";
    $result = $conn->query($query);

    echo "<h2>Browse Games</h2>";

    echo "<ul class = 'modellist'>";

    //display the data get from query 
    while ($row = $result->fetch_row()) {
        echo "<li>";
        echo "<a href=\"gamedetails.php?game_id=$row[0]\">$row[1]</a>";
        echo "</li>\n";
    };
    echo "</ul>";

    //display navigation
    $prevPage = $currentPage - 1;
    $nextPage = $currentPage + 1;

    echo "<div class='pagination'>";
    if ($prevPage > 0) {
        echo "<a href='getgames.php?page=$prevPage'>Previous</a>";
    }
    echo "<span> Page $currentPage </span>";
    if ($nextPage * $gamesPerPage > $result->num_rows) {
        echo "<a href='getgames.php?page=$nextPage'>Next</a>";
    }
    echo "</div>";

    $conn->close();
?>
</div>