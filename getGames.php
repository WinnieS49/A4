<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajax Filtering</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

<label for="genre">Select Genre:</label>
<select id="genre" name="genre" onchange="filterGenres()">
    <option value="">All Genres</option>
    <option value="Puzzle">Puzzle</option>
    <!-- <option value="Clothing">Clothing</option> -->
    <!-- Add more categories as needed -->
</select>

<div id="genres-container">
    <!-- Product list will be displayed here -->
</div>

<script>
function filterGenres() {
    var genre = $("#genre").val();

    $.ajax({
        type: "POST",
        url: "filter.php",
        data: { genre: genre },
        success: function(response) {
            $("#genres-container").html(response);
        }
    });
}
</script>

</body>
</html>
