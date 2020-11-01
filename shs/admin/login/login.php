<?php
    session_start();
    $username = $_POST['username'];
    $password = $_POST['password'];
    // TODO mit Benutzerberechtigungen anmelden
    if ($username == "schulsprecher" && $password == "welovekant") {
        $_SESSION['user'] = $username;
        header('Location: ../index.php');
    } else {
        header('Location: index.php');
    }
?>