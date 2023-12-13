<!-- include header and functions -->
<?php include('include/header.php'); ?>
<?php include('include/functions.php'); ?>

<div class = 'container'>

<?php
    //secure connection
    redirectToHttps();

    //create connection
    $conn = connectToDatabase();

    $name = "";
    $email = "";
    $password = "";
    $phoneNumber = "";
    $message = '';

    //check if all the fields are filled 
    if (isset($_POST['submit'])) {
        $name = !empty($_POST["name"]) ? trim($_POST["name"]) : "";
        $email = !empty($_POST["email"]) ? trim($_POST["email"]) : "";
        $password = !empty($_POST["password"]) ? $_POST["password"] : "";
        $confirmPassword = !empty($_POST["confirmPassword"]) ? $_POST["confirmPassword"] : "";
        $username = !empty($_POST["username"]) ? $_POST["username"] : "";
        $phoneNumber = !empty($_POST["phoneNumber"]) ? $_POST["phoneNumber"] : "";
        $genre = !empty($_POST["preferredGenre"]) ? $_POST["preferredGenre"] : "";
        
        //if not all fields are filled, message will appear 
        if (!$name || !$email || !$username || !$password|| !$phoneNumber) {
            $message = "Please fill all the fields above.";
        }else if($password != $confirmPassword){
            $message = "Password does not match.";
        }

        //all fields are filled, password will be encrypted and data saved into user table and jump to login page
        else {
            
            //check if the username already exists
            $checkUsernameQuery = "SELECT * FROM users WHERE username = ?";
            $checkUsernameResult = $conn->prepare($checkUsernameQuery);
            $checkUsernameResult->bind_param('s', $username);
            $checkUsernameResult->execute();
            $existingUser = $checkUsernameResult->get_result()->fetch_assoc();
        
            if ($existingUser) {
                $message = "Username already exists. Please choose a different username.";
            }else{
                $encryptedPass = password_hash($password, PASSWORD_DEFAULT);
    
                $query = "INSERT INTO users (email, password, name, username, phoneNumber, preferredGenre) ";
                $query .= "VALUES (?,?,?,?, ?, ?)";
                
                $result = $conn->prepare($query);
                $result->bind_param('ssssss',$email, $encryptedPass, $name, $username, $phoneNumber, $genre);
                $result->execute();

                //login after they register
                $_SESSION['valid_user'] = $username;

                //check if there is a callback URL
                if (isset($_SESSION['callback_url'])) {
                    $callback_url = $_SESSION['callback_url'];
                    unset($_SESSION['callback_url']);

                    //redirect to the callback URL
                    header("Location: $callback_url");
                    exit();
                } else {
                    //no callback URL redirect to getgames.php
                    header("Location: homepage.php");
                    exit();
                }
            }

           
        }
    }else {
    }
?>

<h2>Register</h2><br>
<!-- HTML register form -->
<div class = pad>
    <form method="post" action="register.php"> 
        <label for="name">Name: <input type="text" name="name"></label>
        <br/>
        <label for="email">Email Address: <input type="email" name="email"></label>
        <br/>
        <label for="phoneNumber">Phone Number: <input type="text" name="phoneNumber"></label>
        <br/>
        <label for="username">Username: <input type="text" name="username"></label>
        <br/>
        <label for="password">Password: <input type="password" name="password"></label>
        <br/>
        <label for="confirmPassword">Confirm Password: <input type="password" name="confirmPassword"></label>
        <br/>
        
        
        <label for="preferredGenre">Preferred Genre:</label>
        <select name="preferredGenre">
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
        </select><br/>

        <br><input type="submit" name="submit" value="Register">

        <?php 
        // if the message is not empty (user does not fill all the info), it will display the message
            if(!empty($message)){
                echo '<p class="message">' . $message . '</p>';
            } 
        ?>
    </form>
</div>
</div>