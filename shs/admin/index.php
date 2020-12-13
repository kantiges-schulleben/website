<?php
    session_start();
    
    if (isset($_SESSION['userADMIN'])) {
        echo file_get_contents("main.html");
    } else {
        header('Location: ./login/index.php');
    }
?>