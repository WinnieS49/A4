<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajax Filtering</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

<label for="category">Select Category:</label>
<select id="category" name="category" onchange="filterProducts()">
    <option value="">All Categories</option>
    <option value="Electronics">Electronics</option>
    <option value="Clothing">Clothing</option>
    <!-- Add more categories as needed -->
</select>

<div id="products-container">
    <!-- Product list will be displayed here -->
</div>

<script>
function filterProducts() {
    var category = $("#category").val();

    $.ajax({
        type: "POST",
        url: "filter.php",
        data: { category: category },
        success: function(response) {
            $("#products-container").html(response);
        }
    });
}
</script>

</body>
</html>
