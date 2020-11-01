<?php
    session_start();

    if (isset($_SESSION['user']) === true && isset($_SESSION['typ']) === true) {
        header("Location: ../");
    }
    
    echo file_get_contents("./Signup.html");
?>