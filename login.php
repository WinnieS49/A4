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
            <li class="menu-item"><a href="showmodels.php"> All Models</a></li>
            <li class="menu-item"><a href="watchlist.php">Watchlist</a></li>
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
    if($_SERVER['HTTPS'] != "on") {
        header("Location: https://" . $_SERVER['HTTP_HOST'] .
            $_SERVER['REQUEST_URI']);
        exit();
    }

    $servername = "localhost";
    $username = "root"; //login with root
    $password = "";
    $dbname = "gamearchive"; //classicmodels.sql
    $callback_url = "";
    
    //create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    //check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //check form submission
    if (!isset($_POST['submit'])) {
        $username = "";
        $pass = "";
    
    } 
    //retrieve email and password submission
    else {
        $username = !empty($_POST["username"]) ? trim($_POST["username"]) : "";
        $password = !empty($_POST["password"]) ? trim($_POST["password"]) : "";
    
        $query = "SELECT username, password FROM users WHERE username = ?";
    
        $result = $conn->prepare($query);
        $result->bind_param('s',$username);
        $result->execute();
        $result->bind_result($dbUsername, $dbPassword);
        $result->fetch();

        //check email matching from database, set current session to email
        if ($username == $dbUsername) {
            if (password_verify($password, $dbPassword)) {
                $_SESSION['valid_user'] = $username;
                echo "You have logged in.";

                //check if there is a callback URL
                if (isset($_SESSION['callback_url'])) {
                    $callback_url = $_SESSION['callback_url'];
                    unset($_SESSION['callback_url']);

                    //redirect to the callback URL
                    header("Location: $callback_url");
                    exit();
                } else {
                    //no callback URL redirect to showmodels.php
                    header("Location: showmodels.php");
                    exit();
                }
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "User was not found. Try again.";
        }
        
    }

?>

<h2>Login</h2>
    <?php if(!empty($message)) echo '<p>' . $message . '</p>' ?>

    <div class = pad>
        <form action="login.php" method="post">
        <label for="username">Username: <input type="text" name="username" value="<?php $email ?>"></label>
        <br/>
        <label for="password">Password: <input type="password" name="password" value=""></label>
        <br/>
        <input type="submit" name="submit" value="Submit">
                </form>
        <p><a href="register.php">Not registered yet. Register here.</a></p>
    </div>
