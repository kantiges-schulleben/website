<?php
    session_start();

    if (isset($_SESSION['user']) === FALSE) {
        $_SESSION['redirect'] = "editor/";
        header("Location: ../login/");
        die();
    }

    echo file_get_contents("./editor.html");
?>