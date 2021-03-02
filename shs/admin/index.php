<?php
    session_start();
    
    if (isset($_SESSION['userADMIN'])) {
        echo file_get_contents("index.php");
    } else {
        header('Location: ./login/index.php');
    }
?>