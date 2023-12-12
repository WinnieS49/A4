$(document).ready(function () {
    var currentPage = 1;

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

    // Function to load games based on the current page
    function loadGames(page) {
        $.ajax({
            url: 'getgames.php',
            method: 'GET',
            data: { page: page },
            success: function (data) {
                $('#filtered-data-container').html(data);
            }
        });
    }

    // Initial load
    loadGames(currentPage);

    // Previous page button click event
    $('#prevPage').on('click', function () {
        if (currentPage > 1) {
            currentPage--;
            loadGames(currentPage);
        }
    });

    // Next page button click event
    $('#nextPage').on('click', function () {
        currentPage++;
        loadGames(currentPage);
    });
});
