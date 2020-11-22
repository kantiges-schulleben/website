<?php
    require_once("../include/functions.inc.php");

    $message = [];

    session_start();

    if (isset($_SESSION['user']) === true && isset($_SESSION['typ']) === true) {
        header("Location: ../");
    }

    if (isset($_POST['name']) === false or isset($_POST['password']) === false) {
        $message = array(
            'success' => 'false',
            'message' => ''
        );
        die(json_encode($message));
    }

    $name = $_POST['name'];
    $password = $_POST['password'];

    $mail = "";

    if (isset($_POST['mail'])) {
        $mail = $_POST['mail'];
    }

    $count = SQL("SELECT * FROM handschlag WHERE name LIKE ?", [$name])->num_rows;
    if ($count !== 0) {
        $message = array(
            'success' => 'false',
            'message' => 'Es existiert bereits ein Benutzer mit diesem Namen.'
        );
        die(json_encode($message));
    }

    $response = SQL("INSERT INTO handschlag (name, password, mail) VALUES (?, ?, ?)", [$name, $password, $mail]);

    if ($response === false) {
        $message = array(
            'success' => 'false'
        );
        die(json_encode($message));$count = SQL("SELECT * FROM apikeys WHERE api_key LIKE ?", [$key])->num_rows;
        if ($count !== 0) {
            $message = array(
                'success' => 'false',
                'message' => 'Es existiert bereits ein Artikel mit diesem Namen.'
            );
        }
    } else {
        $message = array(
            'success' => 'true'
        );
    }

    echo json_encode($message);
?>