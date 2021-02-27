<?php
    require_once("../include/functions.inc.php");

    $message = [];

    session_start();

    // prüfen, ob der Benutzer schon angemeldet ist
    if (isset($_SESSION['user']) === true && isset($_SESSION['typ']) === true) {
        header("Location: ../");
    }

    // prüfen, ob alle kritischen Parameter übergeben wurden, sonst abbrechen und false zurückgeben
    if (isset($_POST['firstname']) === false or isset($_POST['lastname']) === false or isset($_POST['password']) === false or isset($_POST['username']) === false) {
        $message = array(
            'success' => 'false',
            'message' => ''
        );
        die(json_encode($message));
    }

    $firstname = htmlspecialchars($_POST['firstname'], ENT_QUOTES);
    $lastname = htmlspecialchars($_POST['lastname'], ENT_QUOTES);
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES);
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES);

    $mail = "";

    if (isset($_POST['mail'])) {
        $mail = htmlspecialchars($_POST['mail'], ENT_QUOTES);
    }

    // prüfen, ob bereits ein Benutzer mit diesem Benutzernamen existiert.
    $result = SQL("SELECT COUNT(*) from benutzer WHERE `benutzername` LIKE ?", [$username]);
    $count = mysqli_fetch_assoc($result)['COUNT(*)'];

    if ($count !== 0) {
        $message = array(
            'success' => 'false',
            'message' => 'Es existiert bereits ein Benutzer mit diesem Namen.'
        );
        die(json_encode($message));
    }

    //Daten speichern
    $response = SQL("INSERT INTO benutzer (name, password, benutzername, mail) VALUES (?, ?, ?, ?)", [$firstname . " " . $lastname, password_hash($password, PASSWORD_DEFAULT), $username, $mail], TRUE);

    if ($response[1] !== 1) {
        $message = array(
            'success' => 'false'
        );
        die(json_encode($message));
    } else {
        $message = array(
            'success' => 'true'
        );
    }

    echo json_encode($message);
?>