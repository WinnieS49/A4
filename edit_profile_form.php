<!-- profile edit form, go to edit_profile to add to database-->
<!-- edit_profile_form.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gamearchive";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $username = $_GET['username'];

        $query = "SELECT username, name, password, email, phoneNumber FROM users WHERE username = '$username'";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            // Fetch the user details
            $row = $result->fetch_assoc();
            
            echo "<form action='edit_profile.php' method='post'>";
            echo "<label for='name'>Name:</label>";
            echo "<input type='text' name='name' required value='{$row['name']}'>";

            echo "<label for='username'>Username:</label>";
            echo "<input type='text' name='username' readonly value='{$row['username']}'>";

            echo "<label for='password'>Password:</label>";
            echo "<input type='password' name='password' required value='{$row['password']}'>";

            echo "<label for='phoneNumber'>Phone Number:</label>";
            echo "<input type='tel' name='phoneNumber' value='{$row['phoneNumber']}'>";

            echo "<input type='submit' value='Save'>";
            echo "</form>";
        } else {
            echo "User not found.";
        }
    }

    $conn->close();
    ?>

</body>
</html>
