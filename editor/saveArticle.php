<?php
    include_once("../include/functions.inc.php");

    /*
    * title
    * author
    * content
    * image
    * name
    * date  -> auto
    * id    -> auto
    */
    $message = [];
    $maxSize = 512000; // maximale Dateigröße in Byte -> 500 KB

    if (isset($_POST['title']) === false or isset($_POST['content']) === false or isset($_POST['blogname']) === false) {
        $message = array(
            'success' => 'false',
            'message' => 'Titel/Inhalt/Blog wurde nicht angegeben.'
        );

        die(json_encode($message));
    }

    $title = $_POST['title'];
    $content = $_POST['content'];
    $blogName = $_POST['blogname'];

    $user = $_SESSION['user'];
    $authorID = sqlReturn(SQL("SELECT id FROM handschlag WHERE name LIKE ?", [$user]), 0, "id");
    $imageName = "";

    if (isset($_FILES['imagefile'])) {
        $filename = $_FILES['imagefile']['name'];
        $filetype = $_FILES['imagefile']['type'];
        $tmppath = $_FILES['imagefile']['tmp_name'];
        $filesize = $_FILES['imagefile']['size'];
        $error = $_FILES['imagefile']['error'];

        if ($error === UPLOAD_ERR_OK) {
            switch ($error) {
                case UPLOAD_ERR_INI_SIZE:
                    $text = "Die hochgeladene Datei ist zu groß.";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $text = "Die hochgeladene Datei ist zu groß.";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $text = "Die Datei wurde nur zum Teil hochgeladen.";
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $text = "Die Datei konnte nicht gespeichert werden. Bitte kontaktiere uns über das Kontaktformular.";
                    break;
                default:
                    $text = "Es ist ein Fehler beim hochladen der Datei aufgetreten.";
                    break;
            }

            $message = array(
                'success' => 'false',
                'message' => $text
            );
            die(json_encode($message));
        }

        $filetype = explode("/", $filetype);
        if ($filetype[0] !== "image" or ($filetype[1] !== "bmp" and $filetype[1] !== "gif" and $filetype[1] !== "jpeg" and $filetype[1] !== "png")) {
            $message = array(
                'success' => 'false',
                'message' => 'Die Datei besitzt einen nicht erlaubten Dateityp.'
            );
            die(json_encode($message));
        }

        $filename = md5_file($filename) . "." . $filetype[1];

        move_uploaded_file($tmppath, "../images/" . $filename);

        $imageName = $filename;
    }

    $count = SQL("SELECT title FROM articles WHERE title LIKE ?", [$title])->num_rows;
    if ($count !== 0) {
        $message = array(
            'success' => 'false',
            'message' => 'Es existiert bereits ein Artikel mit diesem Namen.'
        );
        die(json_encode($message));
    }

    $success = SQL("INSERT INTO articles (title, author, content, image, name) VALUES (?, ?, ?, ?, ?)", [$title, $authorID, $content, $imageName, $blogName]);
    if ($success === TRUE) {
        $message = array(
            'success' => 'true'
        );
    } else {
        $message = array(
            'success' => 'false',
            'message' => 'Dein Artikel konnte nicht gespeichert werden. Bitte kontaktiere uns über das Kontaktformular.'
        );
    }

    die(json_encode($message));
?>