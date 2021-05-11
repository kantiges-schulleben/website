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

    if (isset($_POST['title']) === false or isset($_POST['content']) === false or isset($_GET['blogname']) === false or isset($_SESSION['user']) === false) {
        die(file_get_contents("./error.html"));
    }
    // =============================================================
    $title = htmlspecialchars($_POST['title'], ENT_QUOTES);
    $content = htmlspecialchars($_POST['content'], ENT_QUOTES);
    $blogName = htmlspecialchars($_GET['blogname'], ENT_QUOTES);

    $berechtigungForBlog = sqlReturn(SQL("SELECT id from berechtigungen WHERE `name` LIKE ?", [$blogName], FALSE), 0, 'id');

    if (!in_array(strval($berechtigungForBlog), explode(",", $_SESSION['berechtigungen'])) === TRUE) {
        die(file_get_contents("./error.html"));
    }
    // =============================================================

    $tags = "";
    if (isset($_POST['tags'])) {
        $tags = htmlspecialchars($_POST['tags'], ENT_QUOTES);
    }

    $user = $_SESSION['user'];
    $authorID = sqlReturn(SQL("SELECT id FROM benutzer WHERE benutzername LIKE ?", [$user]), 0, "id");
    $imageName = "";

    if (isset($_FILES['imagefile'])) {
        if(!file_exists($_FILES['myfile']['tmp_name']) || !is_uploaded_file($_FILES['myfile']['tmp_name'])) {
        } else {
            $file = $_FILES['imagefile'];

            $filename = $_FILES['imagefile']['name'];
            $tmppath = $_FILES['imagefile']['tmp_name'];
            $filesize = $_FILES['imagefile']['size'];
            $error = $_FILES['imagefile']['error'];

            if ($error === UPLOAD_ERR_OK) {
                switch ($error) {
                    case UPLOAD_ERR_NO_FILE:
                        break;
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
                if (!$justNoFile) {
                    die(file_get_contents("./error.html"));
                }
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

            if ($filename === FALSE) {
                die(file_get_contents("./error.html"));
            }
        
            if (!move_uploaded_file($file['tmp_name'][0], "../images/" . $filename)) {
                die(file_get_contents("./error.html"));
            }
        
            $imageName = $filename;
        }
    }

    $count = SQL("SELECT title FROM articles WHERE title LIKE ?", [$title])->num_rows;
    $count = 0;
    if ($count !== 0) {
        die(file_get_contents("./error.html"));
    }

    $success = SQL("INSERT INTO articles (title, author, content, image, name, tags) VALUES (?, ?, ?, ?, ?, ?)", [$title, $authorID, $content, $imageName, $blogName, $tags], TRUE)[1];
    die(file_get_contents((($success > 0) ? "./success.html" : "./error.html")));
?>