<?php
    require_once("../include/functions.inc.php");

    session_start();

    // prüfen, ob der Benutzer schon angemeldet sein
    if (isset($_SESSION['user']) === true && isset($_SESSION['typ']) === true) {
        header("Location: ../");
    }

    $user = htmlspecialchars(strtolower($_POST['user']), ENT_QUOTES);
    $pwd = htmlspecialchars($_POST['pass'], ENT_QUOTES);

    $result = SQL("SELECT * FROM handschlag WHERE name LIKE ?", [$user]);
    
    //check ob das reale Passwort mit dem übergebenen übereinstimmt
    if ($result->num_rows  === 1) {
        if (password_verify($pwd, sqlReturn($result, 0, "password"))) {
            $result = SQL("SELECT * FROM handschlag WHERE name LIKE ?", [$user]);
            $typ = sqlReturn($result, 0, "typ");
            $_SESSION['user'] = $user;
            $_SESSION['typ'] = $typ;

            header("Location: ../");
        } else {
            header( "Location: index.php");
        }
    } else {
        header( "Location: index.php");
    }
?>
