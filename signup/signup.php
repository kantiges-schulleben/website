<?php
    require_once("../include/functions.inc.php");

    $message = [];

    session_start();

    // prüfen, ob der Benutzer schon angemeldet ist
    if (isset($_SESSION['user']) === true && isset($_SESSION['typ']) === true) {
        header("Location: ../");
    }

    // prüfen, ob alle kritischen Parameter übergeben wurden, sonst abbrechen und false zurückgeben
    if (isset($_POST['name']) === false or isset($_POST['password']) === false or isset($_POST['username']) === false) {
        $message = array(
            'success' => 'false',
            'message' => ''
        );
        die(json_encode($message));
    }

    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $mail = "";

    if (isset($_POST['mail'])) {
        $mail = $_POST['mail'];
    }

    // prüfen, ob bereits ein Benutzer mit diesem Benutzernamen existiert.
    $count = SQL("SELECT * FROM handschlag WHERE benutzername LIKE ?", [$name])->num_rows;
    if ($count !== 0) {
        $message = array(
            'success' => 'false',
            'message' => 'Es existiert bereits ein Benutzer mit diesem Namen.'
        );
        die(json_encode($message));
    }

    //Daten speichern
    $response = SQL("INSERT INTO handschlag (name, password, benutzername, mail) VALUES (?, ?, ?, ?)", [$name, $password, $username, $mail]);

    if ($response === false) {
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