<?php
    // speichert alle Daten wieder in der Datenbank
    session_start();

    if (isset($_SESSION['userADMIN'])) {
    } else {
        header("Location: login");
    }
    require_once("../../include/functions.inc.php");
    
    $data = $_POST['data'];

    $result = SQL("UPDATE shs SET Klasse = '$data[1]', Mail = '$data[2]', Telefon = '$data[3]', Nachhilfe = '$data[4]', Fächer = '$data[5]', Zeit = '$data[6]', Einzelnachhilfe = '$data[7]', Bemerkung = '$data[8]' WHERE Name LIKE '$data[0]'");

    echo $result;
?>