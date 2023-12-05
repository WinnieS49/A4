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

    </body>
</html>

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

    //query to get the data from products table and display on the page
    $query = "SELECT username, name, password, email, phoneNumber, preferredGenre FROM users";
    $result = $conn->query($query);

    $row = $result->fetch_row();
    echo "<h2>$row[1]'s profile page</h2>";
    echo "<h3>User details</h3>";
    echo "<p>Name: $row[1]</p>";
    echo "<p>Username: $row[0]</p>";
    echo "<p>Password: *********</p>";
    echo "<p>Email: $row[3]</p>";
    echo "<p>Phone Number: $row[4]</p>";
    echo "<p>Preferred Genre: $row[5]</p>";
    echo "<a href='edit_profile_form.php?username=$row[0]'>Edit</a>";

    $conn->close();
?>