<?php
    require_once("../include/functions.inc.php");

    session_start();

    // prüfen, ob der Benutzer schon angemeldet sein
    if (isset($_SESSION['user']) === true) {
        header("Location: ../");
    }

    $user = htmlspecialchars(strtolower($_POST['user']), ENT_QUOTES);
    $pwd = htmlspecialchars($_POST['pass'], ENT_QUOTES);

    $result = SQL("SELECT COUNT(*) FROM benutzer WHERE benutzername LIKE ?", [$user]);
    $count = mysqli_fetch_assoc($result)['COUNT(*)'];
    
    //check ob das reale Passwort mit dem übergebenen übereinstimmt
    if ($count  === 1) {
        $result = SQL("SELECT * FROM benutzer WHERE benutzername LIKE ?", [$user]);
        if (password_verify($pwd, sqlReturn($result, 0, "password"))) {
            $result = SQL("SELECT * FROM benutzer WHERE benutzername LIKE ?", [$user]);
            $_SESSION['user'] = $user;
            $_SESSION['berechtigungen'] = sqlReturn($result, 0, 'berechtigung');

            if (isset($_SESSION['redirect']) == TRUE) {
                header("Location: ../" . $_SESSION['redirect']);
                die();
            }
            header("Location: ../");
            die();
        } else {
            header( "Location: index.php"); 
        }
    } else {
        header( "Location: index.php");
    }
?>
