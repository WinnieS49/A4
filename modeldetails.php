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
        <div class = pad>
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
                $gameId = $_GET['gameId'];
                $query = "SELECT * FROM video_games_2022 WHERE gameId = ?"; 
                $result = $conn->prepare($query);
                $result->bind_param('s', $gameId);
                $result->execute();
                $result->bind_result($gmId, $month, $day, $title, $platform, $genre, $developer, $publisher);

                //display results
                if($result->fetch()) {
                    echo "<h3>$title</h3>\n";
                    echo "<p>Release Date: $month $day</p>\n";
                    echo "<p>Developer: $developer</p>\n";
                    echo "<p>Platforms: $platform</p>\n";
                    echo "<p>Genres: $genre</p>\n";
                }

                //release results
                $result->free_result();

                
                echo "<form action=\"addtowatchlist.php\" method=\"post\">\n";
                echo "<input type=\"hidden\" name=\"productCode\" value=$gmId>\n";
                echo "<input type=\"submit\" value=\"Add To Watchlist\">\n";
                echo "</form>\n";

                $conn->close();
            ?>
        </div>

    </body>

</html>

