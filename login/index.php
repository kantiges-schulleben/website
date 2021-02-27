<?php
    session_start();

    if (isset($_SESSION['user']) === true) {
        header("Location: ../");
    }
    
    echo file_get_contents("./main.html");
?>