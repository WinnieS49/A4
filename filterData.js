function filterData() {
    var genre = $("#genre").val();
    var platform = $("#platform").val();
    var year = $("#year").val();
    var rating = $("#rating").val();

    console.log("Filter Data - Genre: " + genre + ", Platform: " + platform + ", Year: " + year + ", Rating: " + rating);

    $.ajax({
        type: "POST",
        url: "filter.php",
        data: { genre: genre, platform: platform, year: year, rating: rating },
        success: function (response) {
            $("#filtered-data-container").html(response);
        }
    });
}