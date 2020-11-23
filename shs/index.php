<?php
    session_start();
    
    // prüfen, ob der Benutzer angemeldet ist und wenn ja richtige html-Seite senden
    if (isset($_SESSION['user']) === true && isset($_SESSION['typ']) === true) {
        if ($_SESSION['typ'] === 'schueler') {
            echo file_get_contents('schueler.html');
        } else {
            echo file_get_contents('lehrer.html');
        }
    } else {
        header("Location: ../login/");
    }
?>