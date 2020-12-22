<?php
    require_once("../include/functions.inc.php");

    // prüfen, ob der Schüler momentan eine Session hat, wenn ja, Link zurückgeben
    session_start();

    if (isset($_SESSION['user']) === false || isset($_SESSION['typ']) === false) {
        echo "login";
        exit();
    }

    $user = $_SESSION['user'];

    $result = sqlReturn(SQL("SELECT terminlink FROM handschlag WHERE name LIKE ?", [$user]), 0, "terminlink");
    if ($result !== "") {
        $link = "";
        $time = "";
        $endOfLink = false;

        for ($i = 0; $i < strlen($result); $i++){
            if ($endOfLink == true) {
                $time .= $result[$i];
            } else {
                if ($result[$i] != ";") {
                    $link .= $result[$i];
                } else {
                    $endOfLink = true;
                }
            }
        }

        $currentTime = time();
        $time = intval($time);

        if ($currentTime - $time > 4200) {
            SQL("UPDATE handschlag SET terminlink='' WHERE name LIKE ?", [$user]);
        } else {
            echo $link;
        }

    } else {
        echo "";
    }

    // echo "<br>" . sqlReturn(SQL("SELECT id FROM handschlag WHERE name LIKE '$user'"), 0, "id");
?>