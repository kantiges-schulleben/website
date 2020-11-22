<?php
    if (isset($_POST['username'])) {
        $result = SQL("SELECT COUNT(username) FROM benutzer WHERE username LIKE ?", [$_POST['username']]);

        if ($result->num_rows > 0) {
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