<?php
    session_start();
    $username = $_POST['username'];
    $password = $_POST['password'];
    // TODO mit Benutzerberechtigungen anmelden
    // sehr schechte anmeldung über hardcoded Values
    if ($username == "schulsprecher" && $password == "welovekant") {
        $_SESSION['userADMIN'] = $username;
        header('Location: ../index.php');
    } else {
        header('Location: index.php');
    }
?>