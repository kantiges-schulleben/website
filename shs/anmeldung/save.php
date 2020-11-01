<?php
    include_once("/include/functions.inc.php");
    /*
    * Name
    * Klasse
    * Mail
    * Telefon
    * Nachhilfe
    * Fächer
    * Zeit
    * Einzelnachhilfe
    * Bemerkung
    */

    $message = [];

    if (isset($_POST['name']) === false
        or
        isset($_POST['klasse']) === false
        or
        isset($_POST['mail']) === false
        or
        isset($_POST['telefon']) === false
        or
        isset($_POST['nachhilfe']) === false
        or
        isset($_POST['fach']) === false
        or
        isset($_POST['zeit']) === false
        or
        isset($_POST['einzelnachhilfe']) === false) {
            $message = array(
                'success' => 'false',
                'message' => 'Nicht alle benötigten Daten wurden angegeben.'
            );
            die(json_encode($message));
    }

    $name = htmlspecialchars($_POST['name'], ENT_QUOTES);
    $klasse = htmlspecialchars($_POST['klasse'], ENT_QUOTES);
    $mail = htmlspecialchars($_POST['mail'], ENT_QUOTES);
    $telefon = htmlspecialchars($_POST['telefon'], ENT_QUOTES);
    $nachhilfe = htmlspecialchars($_POST['nachhilfe'], ENT_QUOTES);
    $fach = htmlspecialchars($_POST['fach'], ENT_QUOTES);
    $zeit = htmlspecialchars($_POST['zeit'], ENT_QUOTES);
    $einzelnachhilfe = htmlspecialchars($_POST['einzelnachhilfe'], ENT_QUOTES);

    $bemerkung = "";
    if (isset($_POST['bemerkung'])) {
        $bemerkung = htmlspecialchars($_POST['bemerkung'], ENT_QUOTES);
    }

    $ziel = "";
    if (isset($_POST['ziel'])) {
        $ziel = htmlspecialchars($_POST['ziel'], ENT_QUOTES);
    }

    if (explode("@", $mail)[0] == $mail) {
        $message = array(
            'success' => 'false',
            'message' => 'Es wurde keine valide Emailadresse angegeben.'
        );

        die(json_encode($message));
    }

    $bemerkung = htmlspecialchars($bemerkung, ENT_QUOTES);

    $result = SQL("INSERT INTO shsAnmeldung (name, klasse, mail, telefon, nachhilfe, fach, zeit, einzelnachhilfe, bemerkung, zielKlasse) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$name, $klasse, $mail, $telefon, $nachhilfe, $fach, $zeit, $einzelnachhilfe, $bemerkung, $ziel]);
    if ($result === false) {
        $message = array(
            'success' => 'false',
            'message' => 'Deine Daten konnte nicht gespeichert werden. Bitte kontaktiere uns über das Kontaktformular.'
        );
        die(json_encode($message));
    }

    echo json_encode(array(
        'success' => 'true'
    ));
?>