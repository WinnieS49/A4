<!-- include header and functions -->
<?php include('include/header.php'); ?>
<?php include('include/functions.php'); ?>

<div class = 'container'>

<?php
    redirectToHttps();

    $conn = connectToDatabase();

    if(!isset($_SESSION['valid_user'])) { //not logged in
        $_SESSION['callback_url'] = 'mylibrary.php';
        header('Location: ' . 'login.php');
        exit(); 
    } 

    $username = $_SESSION['valid_user'];
    $query_str = "SELECT L.library_name, L.library_id ";
    $query_str .= "FROM library L INNER JOIN users U ON L.user_id = U.username ";
    $query_str .= "WHERE U.username ='$username'";
    $res = $conn->query($query_str);?>


    <?php
    echo "<h2>My Library</h2><br>\n";
    echo "<ul class = modellist>\n";
    while ($row = $res->fetch_row()) {
        $libraryId = $row[1];
        $libraryName = $row[0];

        echo "<li><a href='librarydetails.php?library_id=$libraryId'>$libraryName</a></li><br>";

    };
    echo "</ul>\n";?>

    <form action="createLibrary.php" method="post">
    <button type="submit">Create Library</button>
    </form><br>
    
    <?php
    $res->free_result();
    $conn->close();
    ?>
</div>