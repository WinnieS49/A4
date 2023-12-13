<!-- include header and functions -->
<?php include('include/header.php'); ?>
<?php include('include/functions.php'); ?>

<div class = 'container'>
<?php
    //secure connection
    redirectToHttps();

    //create connection
    $conn = connectToDatabase();

    //query to get the data from products table and display on the page

    if(!isset($_SESSION['valid_user'])) { //not logged in
        $_SESSION['callback_url'] = 'profile.php';
        header('Location: ' . 'login.php');
        exit(); 
    } 

    if (isset($_SESSION['valid_user'])) { //if logged in
        $username = $_SESSION['valid_user'];

        $query = "SELECT username, name, password, email, phoneNumber, preferredGenre FROM users WHERE username = ?";
        $resultUser = $conn->prepare($query);
        $resultUser->bind_param('s', $username);
        $resultUser->execute();
        $resultUser->bind_result($username, $name, $password, $email, $phoneNumber, $preferredGenre);
        $resultUser->fetch();
        $resultUser->close();

        echo '<div class="profile-container">';
        echo "<h2>$name's Profile Page</h2><br>";
        echo '<div class="user-details">';
        echo '<h3>User Details</h3><br>';
        echo '<label for="name">Name:</label>';
        echo "<p>$name</p><br>";

        echo '<label for="username">Username:</label>';
        echo "<p>$username</p><br>";

        echo '<label for="email">Email:</label>';
        echo "<p>$email</p><br>";

        echo '<label for="phoneNumber">Phone Number:</label>';
        echo "<p>$phoneNumber</p><br>";

        echo '<label for="preferredGenre">Preferred Genre:</label>';
        echo "<p>$preferredGenre</p><br>";
        echo '</div>';

        echo '<form action="edit_profile_form.php" method="post">';
        echo '<input type="hidden" name="username" value="' . $username . '">';
        echo '<button type="submit">Edit</button>';
        echo '</form>';
        echo '</div>';
    }

    $conn->close();
?>
</div>