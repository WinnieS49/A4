<?php
    session_start();
    session_destroy();
    echo "Signed out";
    header('Location: ' . 'showmodels.php');
    exit();
?>