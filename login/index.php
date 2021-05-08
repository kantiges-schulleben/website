<?php
    session_start();

    if (isset($_SESSION['user']) === true) {
        if (isset($_SESSION["redirect"])) {
            header("Location: ../" . $_SESSION['redirect']);
            die();
        }
        header("Location: ../");
        die();
    }
    
    echo file_get_contents("./main.html");
?>