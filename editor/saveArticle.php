<?php
    session_start();

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

    if (isset($_POST['title']) === false or isset($_POST['content']) === false /*or isset($_POST['blogname']) === false*/) {
        // $message = array(
        //     'success' => 'false',
        //     'message' => 'Titel/Inhalt/Blog wurde nicht angegeben.'
        // );

        // die(json_encode($message));

        die(file_get_contents("./error.html"));
    }

    $title = $_POST['title'];
    $content = $_POST['content'];
    // $blogName = $_POST['blogname'];
    $blogName = "schuelerrat";

    $tags = "";
    if (isset($_POST['tags'])) {
        $tags = $_POST['tags'];
    }

    $user = $_SESSION['user'];
    $authorID = sqlReturn(SQL("SELECT id FROM benutzer WHERE benutzername LIKE ?", [$user]), 0, "id");
    $imageName = "";

    if (isset($_FILES['imagefile'])) {
        $file = $_FILES['imagefile'];

        $filename = $_FILES['imagefile']['name'];
        // $filetype = $_FILES['imagefile']['type'];
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

            // $message = array(
            //     'success' => 'false',
            //     'message' => $text
            // );
            // die(json_encode($message));

            die(file_get_contents("./error.html"));
        }

        // TODO prüfen, ob valider Dateityp
        
        // $filetype = explode("/", $filetype);
        // if ($filetype[0] !== "image" or ($filetype[1] !== "bmp" and $filetype[1] !== "gif" and $filetype[1] !== "jpeg" and $filetype[1] !== "png")) {
        //     $message = array(
        //         'success' => 'false',
        //         'message' => 'Die Datei besitzt einen nicht erlaubten Dateityp.',
        //         "filename" => $filename,
        //         "filetype" => $filetype,
        //         "tmppath" => $tmppath,
        //         "filesize" => $filesize,
        //         "error" => $error
        //     );
        //     die(json_encode($message));
        // }
        $filename = md5($filename[0], false) . "." . explode(".", $filename[0])[1];

        if (!move_uploaded_file($file['tmp_name'][0], "../images/" . $filename)) {
            die(file_get_contents("./error.html"));
        }

        $imageName = $filename;
    }

    $count = SQL("SELECT title FROM articles WHERE title LIKE ?", [$title])->num_rows;
    $count = 0;
    if ($count !== 0) {
        // $message = array(
        //     'success' => 'false',
        //     'message' => 'Es existiert bereits ein Artikel mit diesem Namen.'
        // );
        // die(json_encode($message));

        die(file_get_contents("./error.html"));
    }

    $success = SQL("INSERT INTO articles (title, author, content, image, name, tags) VALUES (?, ?, ?, ?, ?)", [$title, $authorID, $content, $imageName, $blogName, $tags], TRUE)[1];
    if ($success > 0) {
        // $message = array(
        //     'success' => 'true'
        // );

        die(file_get_contents("./success.html"));
    } else {
        // $message = array(
        //     'success' => 'false',
        //     'message' => 'Dein Artikel konnte nicht gespeichert werden. Bitte kontaktiere uns über das Kontaktformular.'
        // );

        die(file_get_contents("./error.html"));
    }

    // die(json_encode($message));
?>
