<?php
    require_once("../include/functions.inc.php");
    
    // prüfen, ob der Benutzer angemeldet ist und alle relevanten Daten für das Dashboard zurück geben
    if (isset($_SESSION["user"])) {
        $result = SQL("SELECT * FROM handschlag WHERE name LIKE ?", [$_SESSION["user"]]);

        $output = array(
            "success" => "true"
        );

        while($news = mysqli_fetch_assoc($result)){
            array_push($output, array(
                'fach' => $news['fach'],
                "klasse" => $news['klasse'],
                // 'schulden' => $news['schulden'],
                "me" => sqlReturn(SQL("SELECT name FROM benutzer WHERE id LIKE ?", [$news['id']]), 0, "name"),
                "partner" => sqlReturn(SQL("SELECT name FROM benutzer WHERE id LIKE ?", [$news['partner']]), 0, "name")
            ));
        }

    } else {
        $output = array(
            "success" => "false"
        );
    }

    echo json_encode($output);
?>
