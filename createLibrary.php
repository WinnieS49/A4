<!-- include header and functions -->
<?php include('include/header.php'); ?>
<?php include('include/functions.php'); ?>

<div class = 'container'>

<?php
    redirectToHttp();
    $conn = connectToDatabase();

    if(!isset($_SESSION['valid_user'])) { //not logged in
        $_SESSION['callback_url'] = 'mylibrary.php';
        header('Location: ' . 'login.php');
        exit(); 
    }

    $username = $_SESSION['valid_user'];

    if (isset($_POST['CreateLibrary'])) {
        $libraryName = !empty($_POST["libraryName"]) ? trim($_POST["libraryName"]) : "";
        
        //check if the library name already exists for the user
        $queryCheck = "SELECT COUNT(*) FROM library WHERE library_name = ? AND user_id = ?";
        $resultCheck = $conn->prepare($queryCheck);
        $resultCheck->bind_param('ss', $libraryName, $username);
        $resultCheck->execute();
        $resultCheck->bind_result($libraryCount);
        $resultCheck->fetch();
        $resultCheck->close();

        if ($libraryCount > 0) {
            echo "Library with the same name already exists. Please choose a different name.";
        } else {
            //insert the new library
            $queryInsert = "INSERT INTO library (library_name, user_id) VALUES (?, ?)";
            $resultInsert = $conn->prepare($queryInsert);
            $resultInsert->bind_param('ss', $libraryName, $username);
            $resultInsert->execute();
            echo "Created library.";
        }
    }

    echo "<h2>Create Library</h2><br>";
    $conn->close();
?>

<form action="createLibrary.php" method="post">
    <label for="libraryName">Library Name:</label>
    <input type="text" id="libraryName" name="libraryName" required><br>   
        
    <button type="submit" name = "CreateLibrary">Create Library</button>
</form><br>
</div>