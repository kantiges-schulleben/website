<?php
    session_start();

    if (isset($_SESSION['user'])) {
    } else {
        header("Location: login");
    }
    require_once("../../include/functions.inc.php");
    
    $mode = $_POST['mode'];
    $data = $_POST['data'];

    if ($mode == "0"/*nur ähnliche Namen und Vornamen zurücksenden*/) {
        $result = @SQL("SELECT Name FROM shsAnmeldung WHERE Name LIKE '%?%'", [$data]);

        $output = "";

        while ($news = mysqli_fetch_assoc($result)) {
            $output .= $news['Name'] . ":";
        }
    } else {
        //gesamte Daten zurücksenden
        $result = @SQL("SELECT * FROM shsAnmeldung WHERE Name LIKE '?'", [$data]);

        $output = "";

        while ($news = mysqli_fetch_assoc($result)) {
            $output .= $news['Name'] . ":" . $news['Klasse'] . ":" . $news['Mail'] . ":" . $news['Telefon'] . ":" . $news['Nachhilfe'] . ":" . $news['Fächer'] . ":" . $news['Zeit'] . ":" . $news['Einzelnachhilfe'] . ":" . $news['Bemerkung'] . ":";
        }
    }
    echo $output;
?>