<?php
    // die(json_encode([]));
    include_once("../include/functions.inc.php");

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        header("Location: ./view?id=$id");
        die();
    } else {
        $name = $_POST["blogname"];

        if (isset($_POST['page'])) {
            $pageNumber = intval($_POST['page']);
        } else {
            $pageNumber = 0;
        }

        
        // ==========================================
        // $pages = sqlReturn(SQL("SELECT COUNT(id) AS pages FROM articles WHERE name LIKE ?", [$name]), 0, 'pages');
        // die(json_encode(array(
        //     "pages" => $pages
        // )));
        // ==========================================

        $result = SQL("SELECT * from articles WHERE name LIKE ? ORDER BY date DESC LIMIT ". 6 * $pageNumber . ",6", [$name]);

        $output = [];

        while($news = mysqli_fetch_assoc($result)){
            $array = str_split($news['date']);
            $date = "";

            foreach ($array as $value) {
                if ($value == " ") {
                    break;
                } else {
                    $date .= $value;
                }
            }

            array_push($output, array(
                'title' => rawurlencode($news['title']),
                'content' => rawurlencode(parseMarkdown(substr($news['content'], 0, 256) . "...")),
                'image' => rawurlencode("../images/" . $news['image']),
                'date' => rawurlencode($date),
                'id' => rawurlencode($news['id']),
                'name' => rawurlencode($name)
            ));
        }
    }

    die(json_encode($output));

    function parseMarkdown($content) {
        $contentToOutput = "";
        
        $boldStart = TRUE;
        $italicStart = TRUE;
        $durchStart = TRUE;
        $underLineStart = TRUE;
        $headlineStart = TRUE;
        $ignoreNext = FALSE;

        for ($i = 0; $i < strlen($content); $i++){
            $char = $content[$i];
            switch ($char) {
                // Zeilenumbruch
                case '\\':
                    if ($content[$i + 1] == " ") {
                        $contentToOutput .= $char;
                    } else {
                        $contentToOutput .= "<br>";
                    }
                    break;
                // fett
                case '*':
                    if ($content[$i + 1] == " " && $boldStart === TRUE) {
                        $contentToOutput .= $char;
                    } else {
                        $contentToOutput .= "<" . (($boldStart === TRUE) ? "" : "/") . "b>";
                        $boldStart = !$boldStart;
                    }
                    break;
                // kursiv
                case '~':
                    if ($content[$i + 1] == " " && $italicStart === TRUE) {
                        $contentToOutput .= $char;
                    } else {
                        $contentToOutput .= "<" . (($italicStart === TRUE) ? "" : "/") . "i>";
                        $italicStart = !$italicStart;
                    }
                    break;
                // durchgestrichen
                case '-':
                    if ($content[$i + 1] == " " && $durchStart === TRUE) {
                        $contentToOutput .= $char;
                    } else {
                        $contentToOutput .= "<" . (($durchStart === TRUE) ? "" : "/") . "s>";
                        $durchStart = !$durchStart;
                    }
                    break;
                // unterstrichen
                case '_':
                    if ($content[$i + 1] == " " && $underLineStart === TRUE) {
                        $contentToOutput .= $char;
                    } else {
                        $contentToOutput .= "<" . (($underLineStart === TRUE) ? "" : "/") . "u>";
                        $underLineStart = !$underLineStart;
                    }
                    break;
                // horizontale Linie
                case '=':
                    if ($ignoreNext === FALSE) {
                        if ($content[$i + 1] !== "=") {
                            $contentToOutput .= $char;
                        } else {
                            $contentToOutput .= "<hr>";
                            $ignoreNext = TRUE;
                        }
                    } else {
                        $ignoreNext = FALSE;
                    }
                    break;
                // Übershrift
                case '#':
                    if ($content[$i + 1] == " " && $headlineStart === TRUE) {
                        $contentToOutput .= $char;
                    } else {
                        $contentToOutput .= "<" . (($headlineStart === TRUE) ? "" : "/") . "h5><hr>";
                        $headlineStart = !$headlineStart;
                    }
                    break;
                // Rest
                default:
                    $contentToOutput .= $char;
                    break;
            }
        }

        if ($boldStart === FALSE) {
            $contentToOutput .= "</b>";
        }
        if ($italicStart === FALSE) {
            $contentToOutput .= "</i>";
        }
        if ($durchStart === FALSE) {
            $contentToOutput .= "</s>";
        }
        if ($underLineStart === FALSE) {
            $contentToOutput .= "</u>";
        }
        if ($headlineStart === FALSE) {
            $contentToOutput .= "</h5><hr>";
        }
        
        return $contentToOutput;
    }
?>