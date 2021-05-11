<?php
    session_start();
    include_once("../include/functions.inc.php");

    if (isset($_SESSION['user']) === FALSE) {
        $_SESSION['redirect'] = "editor/" . (isset($_GET['name']) ? "?name=" . $_GET['name'] : "");
        header("Location: ../login/");
        die();
    }

    if (!isset($_GET['name'])) {
        die(file_get_contents("./noBlog.html"));
    } else {
        $targetBlog = htmlspecialchars($_GET['name'], ENT_QUOTES);

        $berechtigungForBlog = sqlReturn(SQL("SELECT id from berechtigungen WHERE `name` LIKE ?", [$targetBlog], FALSE), 0, 'id');

        if (!in_array(strval($berechtigungForBlog), explode(",", $_SESSION['berechtigungen'])) === TRUE) {
            die(file_get_contents("./noBerechtigung.html"));
        }
    }

    // echo file_get_contents("./editor.html");
?>
<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>


  <title>Editor</title>
  <link rel="stylesheet" href="./editor.css">
  
</head>

<body>    
    <section id="cards">
        <div class="container">
      
            <div class="buttons">
                <button id="editorButton" type="button" onclick="Editor();">
                    <h1>Editor</h1>
                </button>
                <button id="previewButton" type="button" onclick="Vorschau();">
                    <h1>Vorschau</h1>
                </button>
            </div>

            <form id="hochladen" action="saveArticle.php?blogname=<?php echo $_GET['name']?>" method="post" enctype="multipart/form-data" accept-charset="utf-8" autocomplete="off" novalidat>
                <div id="editor">
      
                    <div class="card-item">
                        <div class="card-info">
                            <h3>Überschrift</h3>
                            <div class="input-container">
                                <p>
                                    <input name="title" type="text" maxlength="120" placeholder="Hier bitte die Überschrift eingeben" id="überschrift" required>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-item">
                        <div class="card-info">
                            <h3>Inhalt</h3>
                            <div class="input-container">
                            <p>
                                <div id="textarea">
                                    <textarea name="content" rows="10" placeholder="Hier Bitte den Textinhalt eingeben" id="inhalt"></textarea>
                                </div>
                            </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-item">
                        <div class="card-info">
                            <div id="addImage-container">
                                <h3>Füge ein Bild hinzu</h3>
                                <div id="deleteThumbnailButton" onclick="removeJustThumbnail();"> &#x2715 </div>
                            </div>
                            <div class="drop-zone">
                                <span class="drop-zone__prompt">Lege es hier ab <br>oder klicke zum Auswählen</span>
                                <p id="uploadImage">
                                    <input type="file" accept="image/x-png,image/gif,image/jpeg" name="imagefile[]" id="uploadedImage" class="drop-zone__input">
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-item">
                        <div class="card-info">
                            <h3>Füge Tags hinzu</h3>
                            <div class="input-container">
                            <p>
                                <input name="tags" type="text" maxlength="120" placeholder="Füge Tags hinzu, über die sich dein Artikel finden lässt (nur einzelne Wörter)" id="tags">
                            </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="vorschau">
                    <div class="card-item" id="vorschau-design">
                        <div class="card-info">
                            <div id="vorschau-container" >
                                <h3 class="msg überschrift" id="vorschau-überschrift"></h3>
                                <p id="vorschau-datum" class="msg datum"> </p>
                            </div>
                            <img src="" id="bild">
                            <p id="vorschau-text" class="msg inhalt"></p>
                            <p id="vorschau-tags" class="msg tags"></p>
                        </div>
                    </div>
                </div>

                <input type="submit" id="speichern" value="Speichern">
                <input type="reset" id="Abbrechen" value="Abbrechen" onclick="removeThumbnail(); Editor();">

            </form>
            <script type="text/javascript" src="editor.js"></script>
        </div>
  </section>
</body>
</html>