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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve user input
        $username = $_POST["username"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phoneNumber = $_POST["phoneNumber"];

        $query = "UPDATE users SET name=?, email=?, phoneNumber=? WHERE username=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $name, $email, $phoneNumber, $username);
        $stmt->execute();
        $stmt->close();

        header("Location: profile.php");
        exit();
    }

    $conn->close();
?>
