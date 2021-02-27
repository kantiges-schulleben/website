<?php
    require_once("../include/functions.inc.php");

    session_start();

    // prüfen, ob der Benutzer schon angemeldet sein
    if (isset($_SESSION['user']) === true && isset($_SESSION['typ']) === true) {
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
            $_SESSION['user'] = $user;

            header("Location: ../");
        } else {
            header( "Location: index.php");
        }
    } else {
        header( "Location: index.php");
    }
?>
