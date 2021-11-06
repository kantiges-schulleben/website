<?php
    // gibt die Anzahl von Einträgen -> Schülern, die sich für shs angemeldet haben
    session_start();

    if (isset($_SESSION['userADMIN'])) {
    } else {
        header("Location: login");
    }
    require_once("../../include/functions.inc.php");

    $result = @SQL("SELECT COUNT(*) FROM shsAnmeldung", ['empty']);

    $output = [];

    while ($news = mysqli_fetch_assoc($result)) {
        $output = array(
            "count" => $news['COUNT(*)']
        );
    }

    echo json_encode($output);
?>