<?php
    session_start();
    
    if (isset($_SESSION['user'])) {
        echo file_get_contents("index.html");
    } else {
        header('Location: ./login/index.php');
    }
?>