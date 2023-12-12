<!-- include header and functions -->
<?php include('include/header.php'); ?>
<?php include('include/functions.php'); ?>

<? redirectToHttp(); ?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<div class = 'container'>
    <h2>Browse and Filter Games</h2><br>
    <label for="genre">Select Genre:</label>
    <select id="genre" name="genre">
        <option value="">All Genres</option>
        <option value="Adventure">Adventure</option>
        <option value="Puzzle">Puzzle</option>
        <option value="Brawler">Brawler</option>
        <option value="Indie">Indie</option>
        <option value="Platform">Platform</option>
        <option value="Simulator">Simulator</option>
        <option value="Shooter">Shooter</option>
        <option value="Turn-Based Strategy">Turn-Based Strategy</option>
        <option value="Strategy">Strategy</option>
        <option value="Tactical">Tactical</option>
        <option value="Arcade">Arcade</option>
        <option value="Music">Music</option>
        <option value="Visual Novel">Visual Novel</option>
        <option value="Racing">Racing</option>
        <option value="Fighting">Fighting</option>
        <option value="MOBA">MOBA</option>
        <option value="Card & Board Game">Card & Board Game</option>
        <option value="Real Time Strategy">Real Time Strategy</option>
        <option value="Sport">Sport</option>
        <option value="Quiz/Trivia">Quiz/Trivia</option>
        <option value="Point-and-Click">Point-and-Click</option>
        <option value="Pinball">Pinball</option>
    </select>

    <label for='platform'>Select Platform:</label>
    <select id="platform" name="platform">
    <option value=''>All Platforms</option>
    <option value='Windows PC'>Windows PC</option>
    <option value='Mac'>Mac</option>
    <option value='Linux'>Linux</option>
    <option value='PlayStation 4'>PlayStation 4</option>
    <option value='Xbox One'>Xbox One</option>
    <option value='Nintendo Switch'>Nintendo Switch</option>
    <option value='PlayStation 5'>PlayStation 5</option>
    <option value='Xbox Series'>Xbox Series</option>
    <option value='Xbox 360'>Xbox 360</option>
    <option value='PlayStation 3'>PlayStation 3</option>
    <option value='Android'>Android</option>
    <option value='iOS'>iOS</option>
    </select><br>

    <label for="year">Select Year of Release:</label>
    <select id="year" name="year">
        <option value="">All Years</option>
        <?php
        // Populate year options from 2023 to 1990
        for ($year = 2023; $year >= 1990; $year--) {
            echo "<option value='$year'>$year</option>";
        }
        ?>
    </select>

    <label for="rating">Select Minimum Rating:</label>
    <select id="rating" name="rating">
        <option value="">All Ratings</option>
        <?php
        // Populate rating options from 0.5 to 4.5
        for ($rating = 0.5; $rating <= 4.5; $rating += 0.5) {
            echo "<option value='$rating'>$rating</option>";
        }
        ?>
    </select><br>

    <button onclick="filterData()">Apply Filter</button>

    <div id="filtered-data-container">
    </div>

    <script>
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
        
    </script>
</div>