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
            <li class="menu-item"><a href="showmodels.php">All Games</a></li>
            <!-- check if user login, show differenrt options based on user status -->
            <?php
            session_start();
            if (isset($_SESSION['valid_user'])){
                echo "<li class='menu-item'><a href='logout.php'>Logout</a></li>";
            }else{
                echo "<li class='menu-item'><a href='login.php'>Login</a></li>";
            }

            ?>
        </ul>
        <div class = 'container'>
            <?php
                if(isset($_SERVER['HTTPS']) &&  $_SERVER['HTTPS']== "on") {
                    header("Location: http://" . $_SERVER['HTTP_HOST'] .
                        $_SERVER['REQUEST_URI']);
                    exit();
                }

                $servername = "localhost";
                $username = "root"; //login with root
                $password = "";
                $dbname = "gamearchive"; //classicmodels.sql
                
                //create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                
                //check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                //retrieve prodCode from url
                $game_id = $_GET['game_id'];
                $query = "SELECT * FROM games WHERE game_id = ?"; 
                $result = $conn->prepare($query);
                $result->bind_param('s', $game_id);
                $result->execute();
                $result->bind_result($gmId, $title, $release_date, $developer, $summary, $platform, $genres, $rating, $plays, $playing, $backlogs, $wishlist, $lists, $reviews );

                //display results
                if($result->fetch()){
                    echo "<h3>$title</h3>\n";
                    echo "<p>Release Date: $release_date </p>\n";
                    echo "<p>Developer: $developer </p>\n";
                    echo "<p>Platforms: $platform </p>\n";
                    echo "<p>Genres: $genres </p>\n";
                }

                //release results
                $result->free_result();

                $username = $_SESSION['valid_user'];

                $query = "SELECT library_name FROM library WHERE user_id = ?";
                $result = $conn->prepare($query);
                $result->bind_param('s',$username);
                $result->execute();
                $res = $result->get_result();

                // Check if the query was successful
                if ($result) {
                    echo "<form action=\"addtowatchlist.php\" method=\"post\">\n"; 
                    echo "<input type=\"hidden\" name=\"game_id\" value=$gmId>\n";
                    echo "<label for=\"libraryName\">Select Library:</label>\n";
                    echo "<select name=\"libraryName\" id=\"libraryName\">\n";

                    // Loop through the result set to populate the dropdown
                    while ($row = $res->fetch_assoc()) {
                        $libraryId = $row['library_id'];
                        $libraryName = $row['library_name'];
                        echo "<option value=\"$libraryId\">$libraryName</option>\n";
                    }
                }

                echo "</select>\n";
                echo "<input type=\"submit\" value=\"Add To Library\">\n";
                echo "</form>\n";

                // Free result set
                $res->free();

                $conn->close();
            ?>
        </div>

    </body>

</html>

