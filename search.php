<!-- include header and functions -->
<?php include('include/header.php'); ?>
<?php include('include/functions.php'); ?>
<div class = 'container'>

<?php
    if (isset($_GET['query'])) {
        $searchQuery = $_GET['query'];

        //connect to database
        $conn = connectToDatabase();

        //number of games to display per page
        $gamesPerPage = 10;

        //get the current page number from the URL
        $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

        //galculate the starting index for the games to display
        $startIndex = ($currentPage - 1) * $gamesPerPage;

        // Perform the search query
        $sql = "SELECT * FROM games WHERE title LIKE '%$searchQuery%' LIMIT $startIndex, $gamesPerPage";
        $result = $conn->query($sql);

        echo "<h2>Search Results</h2>";
        // Display the search results
        if ($result->num_rows > 0) {
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<a href=\"search.php?game_id={$row['game_id']}\">{$row['title']}</a><br>";
                // Display other relevant information as needed
            }
            echo "</ul>";
        } else {
            echo "<p>No results found</p>";
        }

        $prevPage = $currentPage - 1;
        $nextPage = $currentPage + 1;

        echo "<div class='pagination'>";
        if ($prevPage > 0) {
            echo "<a href='search.php?page=$prevPage&query=$searchQuery'>Previous</a> ";
        }
        echo "<span> Page $currentPage </span>";
        if ($nextPage * $gamesPerPage > $result->num_rows) {
            echo "<a href='search.php?page=$nextPage&query=$searchQuery'>Next</a>";
        }
        echo "</div>";


        $conn->close(); // close the database connection
    }
?>
</div>