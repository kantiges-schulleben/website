<?php
    // check, ob ein Benutzername schon existiert
    require_once("../include/functions.inc.php");
    if (isset($_POST['username'])) {
        $result = SQL("SELECT COUNT(username) FROM benutzer WHERE benutzername LIKE ?", [$_POST['username']]);
        $count = sqlResult($result, 0, "count");
        if ($count > 0) {
            echo json_encode(array(
                "exists" => "true"
            ));
        } else {
            echo json_encode(array(
                "exists" => "false"
            ));
        }
    } else {
        echo json_encode(array(
            "exists" => "true"
        ));
    }
?>