<!-- profile edit form, go to edit_profile to add to database-->
<!-- edit_profile_form.php -->
<?php include('include/header.php'); ?>
<?php include('include/functions.php'); ?>

<div class = 'container'>
    <?php
    //secure connection
    redirectToHttps();

    //connect
    $conn = connectToDatabase();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_SESSION['valid_user'];

        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($query);

        echo '<div class="profile-container">';
        echo "<h2>Edit your profile</h2><br>";
        if ($result && $result->num_rows > 0) {
            // Fetch the user details
            $row = $result->fetch_assoc();

            echo "<form action='edit_profile.php' method='post'>";
            echo "<label for='name'>Name:</label>";
            echo "<input type='text' name='name' required value='{$row['name']}'><br>";

            echo "<label for='username'>Username:</label>";
            echo "<input type='text' name='username' required value='{$row['username']}'><br>";

            echo "<label for='password'>Password:</label>";
            echo "<input type='password' name='password' required value='{$row['password']}'><br>";

            echo "<label for='phoneNumber'>Phone Number:</label>";
            echo "<input type='text' name='phoneNumber' required value='{$row['phoneNumber']}'><br>";

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

            echo "<input type='submit' value='Save'>";
            echo "</form>";
        } else {
            echo "User not found.";
        }
    }

    echo '</div>';
    $conn->close();
    ?>

</div>
