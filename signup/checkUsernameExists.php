<?php
    // check, ob ein Benutzername schon existiert
    require_once("../include/functions.inc.php");
    if (isset($_POST['username'])) {
        $result = SQL("SELECT COUNT(*) FROM benutzer WHERE benutzername LIKE ?", [htmlspecialchars($_POST['username'], ENT_QUOTES)]);
        $count = sqlReturn($result, 0, "COUNT(*)");
        if ($count > 0) {
            echo json_encode(array(
                "exists" => true
            ));
        } else {
            echo json_encode(array(
                "exists" => false
            ));
        }
    } else {
        echo json_encode(array(
            "exists" => true
        ));
    }
?>