<?php
    session_start();

    if (isset($_SESSION['user']) === true && isset($_SESSION['typ']) === true) {
        header("Location: ../index.php");
    }
    
    echo file_get_contents("index.html");
?>