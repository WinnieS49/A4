<?php
    if($_SERVER['HTTPS'] != "on") {
        header("Location: https://" . $_SERVER['HTTP_HOST'] .
            $_SERVER['REQUEST_URI']);
        exit();
    }
    session_start();

    $servername = "localhost";
    $username = "root"; //login with root
    $password = "";
    $dbname = "classicmodels"; //classicmodels.sql
    
    //create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    //check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //check form submission
    if (!isset($_POST['submit'])) {
        $email = "";
        $pass = "";
    
    } 
    //retrieve email and password submission
    else {
        $email = !empty($_POST["email"]) ? trim($_POST["email"]) : "";
        $password = !empty($_POST["password"]) ? trim($_POST["password"]) : "";
    
        $query = "SELECT email, password FROM users WHERE email = ?";
    
        $result = $conn->prepare($query);
        $result->bind_param('s',$email);
        $result->execute();
        $result->bind_result($dbEmail, $dbPassword);
        $result->fetch();

        //check email matching from database, set current session to email
        if ($email == $dbEmail) {
            if (password_verify($password, $dbPassword)) {
                $_SESSION['valid_user'] = $email;
                echo "You have logged in.";
                //return to showmodels.php upon login
                header('Location: ' . 'showmodels.php');
                exit();
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

    <form action="login.php" method="post">
    <label for="email">Email Address: <input type="email" name="email" value="<?php $email ?>"></label>
    <br/>
    <label for="password">Password: <input type="password" name="password" value=""></label>
    <br/>
    <input type="submit" name="submit" value="Submit">
            </form>
	<p><a href="register.php">Not registered yet. Register here.</a></p>
