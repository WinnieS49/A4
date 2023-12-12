<!-- include header and functions -->
<?php include('include/header.php'); ?>
<?php include('include/functions.php'); ?>

<div class = 'container'>

<?php
    //secure connection
    redirectToHttps();

    //create connection
    $conn = connectToDatabase();

    //check form submission
    if (!isset($_POST['submit'])) {
        $username = "";
        $pass = "";
    
    } 

    //retrieve email and password from submission
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
                redirectToCallback();
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "User was not found. Try again.";
        }
        
    }

?>

<h2>Login</h2><br>
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
</div>
