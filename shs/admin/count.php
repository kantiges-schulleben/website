<?php
    session_start();

    if (isset($_SESSION['user'])) {
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