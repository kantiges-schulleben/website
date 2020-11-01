<?php
    include_once("/include/functions.inc.php");

    if (isset($_SESSION['user']) === true) {
        $user = htmlspecialchars(strtolower($_SESSION['user']), ENT_QUOTES);
        $pwd = $_POST['oldPassword'];

        $result = SQL("SELECT * FROM handschlag WHERE name LIKE ?", [$user]);
    
        if ($result->num_rows  === 1) {
            if (password_verify($pwd, sqlReturn($result, 0, "password"))) {

                $newPassword = $_POST['newPassword'];
                $success = SQL("UPDATE handschlag SET password=? WHERE name LIKE ?", [password_hash($newPassword, PASSWORD_DEFAULT), $user]);

                echo json_encode(array("success" => "true"));
            } else {
                //TODO ordentliche Fehlermeldung/Rückmeldung
                echo json_encode(array("success" => "false"));
            }
        }
    } else {
        //weiterleitung zu login
    }
?>