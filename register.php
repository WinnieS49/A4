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

    if (isset($_POST['submit'])) {

        // detect if each variable is set (fname, lname, email, password, sid, faculty)
        $fname = !empty($_POST["fname"]) ? trim($_POST["fname"]) : "";
        $lname = !empty($_POST["lname"]) ? trim($_POST["lname"]) : "";
        $email = !empty($_POST["email"]) ? trim($_POST["email"]) : "";
        $password = !empty($_POST["password"]) ? $_POST["password"] : "";
        
        if (!$fname || !$lname || !$email || !$password) {
            $message = "All fields manadatory.";
        }
        else {
            $pw_encrypted = password_hash($password, PASSWORD_DEFAULT);
    
            $query = "INSERT INTO users (email, password, firstName,lastName) ";
            $query .= "VALUES (?,?,?,?)";
            
            $result = $conn->prepare($query);
            $result->bind_param('ssss',$email,$pw_encrypted,$fname,$lname);
            $result->execute();
            echo $query;
            header("Location: login.php");
            exit();
        }
    }
    else {
        $fname = "";
        $lname = "";
        $email = "";
        $s_id = "";
        $faculty = "";
    }
?>

<h2>Register</h2>
<form method="post" action="register.php">
    <label for="fname">First Name: <input name="fname" type="text" value="<?php $fname ?>"></label>
    <br/>
    <label for="lname">Last Name: <input type="text" name="lname" value="<?php $lname ?>"></label>
    <br/>
    <label for="email">Email Address: <input type="email" name="email" value="<?php $email ?>"></label>
    <br/>
    <label for="password">Password: <input type="password" name="password" value=""></label>
    <br/>
    <input type="submit" name="submit" value="Register">
    <?php if(!empty($message)) echo '<p class="message">' . $message . '</p>' ?>
</form>