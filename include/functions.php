<?php
function connectToDatabase() {
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

    return $conn;
}

function redirectToHttps() {
    if ($_SERVER['HTTPS'] != "on") {
        header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        exit();
    }
}

function redirectToHttp() {
    // Check if the request is using HTTPS
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") {
        // Redirect to HTTP
        header("Location: http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        exit();
    }
}

function redirectToCallback() {
    //check if there is a callback URL
    if (isset($_SESSION['callback_url'])) {
        $callback_url = $_SESSION['callback_url'];
        unset($_SESSION['callback_url']);

        //redirect to the callback URL
        header("Location: $callback_url");
        exit();
    }else {
        //no callback URL redirect to homepage
        header("Location: homepage.php");
        exit();
    }
}

function addGenreSelection(){
    echo "<label for='genre'>Select Genre:</label>";
    echo "<select id='genre' name='genre'>";
    echo "<option value='Adventure'>Adventure</option>";
    echo "<option value='Puzzle'>Puzzle</option>";
    echo "<option value='Brawler'>Brawler</option>";
    echo "<option value='Indie'>Indie</option>";
    echo "<option value='Platform'>Platform</option>";
    echo "<option value='Simulator'>Simulator</option>";
    echo "<option value='Shooter'>Shooter</option>";
    echo "<option value='Turn-Based Strategy'>Turn-Based Strategy</option>";
    echo "<option value='Strategy'>Strategy</option>";
    echo "<option value='Tactical'>Tactical</option>";
    echo "<option value='Arcade'>Arcade</option>";
    echo "<option value='Music'>Music</option>";
    echo "<option value='Visual Novel'>Visual Novel</option>";
    echo "<option value='Racing'>Racing</option>";
    echo "<option value='Fighting'>Fighting</option>";
    echo "<option value='MOBA'>MOBA</option>";
    echo "<option value='Card & Board Game'>Card & Board Game</option>";
    echo "<option value='Real Time Strategy'>Real Time Strategy</option>";
    echo "<option value='Sport'>Sport</option>";
    echo "<option value='Quiz/Trivia'>Quiz/Trivia</option>";
    echo "<option value='Point-and-Click'>Point-and-Click</option>";
    echo "<option value='Pinball'>Pinball</option>";
    echo "</select><br>";
}

function addPlatformSelection(){
    echo "<label for='platform'>Select Platform:</label>";
    echo "<select id='platform' name='platform'>";
    echo "<option value='Windows PC'>Windows PC</option>";
    echo "<option value='Mac'>Mac</option>";
    echo "<option value='Linux'>Linux</option>";
    echo "<option value='PlayStation 4'>PlayStation 4</option>";
    echo "<option value='Xbox One'>Xbox One</option>";
    echo "<option value='Nintendo Switch'>Nintendo Switch</option>";
    echo "<option value='PlayStation 5'>PlayStation 5</option>";
    echo "<option value='Xbox Series'>Xbox Series</option>";
    echo "<option value='Xbox 360'>Xbox 360</option>";
    echo "<option value='PlayStation 3'>PlayStation 3</option>";
    echo "<option value='Android'>Android</option>";
    echo "<option value='iOS'>iOS</option>";
    echo "</select><br>";
}
?>
