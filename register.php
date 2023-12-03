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
    
    //create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    //check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //check if all the fields are filled 
    if (isset($_POST['submit'])) {
        $name = !empty($_POST["name"]) ? trim($_POST["name"]) : "";
        $email = !empty($_POST["email"]) ? trim($_POST["email"]) : "";
        $password = !empty($_POST["password"]) ? $_POST["password"] : "";
        $username = !empty($_POST["username"]) ? $_POST["username"] : "";
        $phoneNumber = !empty($_POST["phoneNumber"]) ? $_POST["phoneNumber"] : "";
        
        //if not all fields are filled, message will appear 
        if (!$name || !$email || !$username || !$password|| !$phoneNumber) {
            $message = "Please fill all the fields above.";
        }

        //all fields are filled, password will be encrypted and data saved into user table and jump to login page
        else {
            $encryptedPass = password_hash($password, PASSWORD_DEFAULT);
    
            $query = "INSERT INTO users (email, password, name, username, phoneNumber) ";
            $query .= "VALUES (?,?,?,?, ?)";
            
            $result = $conn->prepare($query);
            $result->bind_param('sssss',$email,$encryptedPass,$name, $username, $phoneNumber);
            $result->execute();

            //login after they register
            $_SESSION['valid_user'] = $email;

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
        }
    }
    else {
        $name = "";
        $email = "";
        $password = "";
        $phoneNumber = "";
    }
?>

<h2>Register</h2>
<!-- HTML register form -->
<div class = pad>
    <form method="post" action="register.php"> 
        <label for="lname">Name: <input type="text" name="name" value="<?php $name ?>"></label>
        <br/>
        <label for="email">Email Address: <input type="email" name="email" value="<?php $email ?>"></label>
        <br/>
        <label for="phoneNumber">Phone Number: <input type="text" name="phoneNumber" value="<?php $email ?>"></label>
        <br/>
        <label for="username">Username: <input type="text" name="username" value="<?php $email ?>"></label>
        <br/>
        <label for="password">Password: <input type="password" name="password" value=""></label>
        <br/>
        <input type="submit" name="submit" value="Register">
        <?php 
        // if the message is not empty (user does not fill all the info), it will display the message
            if(!empty($message)){
                echo '<p class="message">' . $message . '</p>';
            } 
        ?>
    </form>
</div>