<!-- end the session (echo message to users) and direct the user to show models page -->
<?php
    session_start();
    session_destroy();
    echo "Signed out";
    header('Location: ' . 'homepage.php');
    exit();
?>