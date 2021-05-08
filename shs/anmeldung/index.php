<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        $_SESSION['redirect'] = "shs/anmeldung/";
        header("Location: ../../login/");
        die();
    }
    echo file_get_contents("./main.html");
?>