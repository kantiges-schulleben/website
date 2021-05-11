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
                'content' => rawurlencode(substr($news['content'], 0, 256) . "..."),
                'image' => rawurlencode("../images/" . $news['image']),
                'date' => rawurlencode($date),
                'id' => rawurlencode($news['id']),
                'name' => rawurlencode($name)
            ));
        }
    }

    die(json_encode($output));
?>