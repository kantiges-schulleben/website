<?php
    session_start();
    if (isset($_SESSION['userADMIN'])) {
        header("Location:../");
        die();
    }
    echo file_get_contents("main.html");
?>