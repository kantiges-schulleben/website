<?php
    require_once("../include/functions.inc.php");

    // prüfen ob der benuter angemeldet ist
    if (isset($_SESSION['user']) === true) {
        $user = htmlspecialchars(strtolower($_SESSION['user']), ENT_QUOTES);
        $pwd = htmlspecialchars($_POST['oldPassword'], ENT_QUOTES);

        $result = SQL("SELECT * FROM handschlag WHERE name LIKE ?", [$user]);
    
        if ($result->num_rows  === 1) {
            // prüfen, ob das alte Passwort mit dem realen überinstimmt
            if (password_verify($pwd, sqlReturn($result, 0, "password"))) {
                $newPassword = htmlspecialchars($_POST['newPassword'], ENT_QUOTES);
                // Passwort updaten
                $success = SQL("UPDATE handschlag SET password=? WHERE name LIKE ?", [password_hash($newPassword, PASSWORD_DEFAULT), $user]);

                echo json_encode(array("success" => "true"));
            } else {
                //TODO ordentliche Fehlermeldung/Rückmeldung
                echo json_encode(array("success" => "false"));
            }
        }
    } else {
        echo json_encode(array(
            "success" => "false",
            "target" => "htts://www.kantiges-schulleben.de/login"
        ));
    }
?>