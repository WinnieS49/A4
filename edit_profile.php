<?php include('include/header.php'); ?>
<?php include('include/functions.php'); ?>

<div class = 'container'>

<?php
    //secure connection
    redirectToHttps();

    //connect
    $conn = connectToDatabase();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //retrieve user input
        $username = $_POST["username"];
        $name = $_POST["name"];
        $password = $_POST["password"];
        $phoneNumber = $_POST["phoneNumber"];
        $genre = $_POST["genre"];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "UPDATE users SET name=?, password =?, phoneNumber=?, preferredGenre =? WHERE username=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $name, $hashedPassword, $phoneNumber, $genre, $username);
        $stmt->execute();
        $stmt->close();

        header("Location: profile.php");
        exit();
    }

    $conn->close();
?>
</div>