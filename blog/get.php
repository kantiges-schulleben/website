<?php
    include_once("../include/functions.inc.php");

    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        $result = SQL("SELECT * from articles WHERE id LIKE ?", [$id]);

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
                'content' => rawurlencode($news['content']),
                'image' => rawurlencode("../images/" . $news['image']),
                'date' => rawurlencode($date),
                'id' => rawurlencode($news['id']),
                'name' => rawurlencode($news['name'])
            ));
        }
    } else {
        $data = [];
        
        if (isset($_POST["data"])) {
            $data = json_decode($_POST["data"]);
        }

        $name = "";
        if (isset($data["blogname"])) {
            $name = $data["blogname"];
        }

        // ==========================================
        $pages = SQL("SELECT COUNT(id) AS pages FROM articles WHERE name LIKE ?" [$name]);
        $pages = sqlReturn($pages, 0, "pages");
        // ==========================================

        $pageNumber = 0;
        if (isset($data["page"])) {
            $pageNumber = $data["page"];
        }

        $result = SQL("SELECT * from articles WHERE name LIKE ? ORDER BY date DESC LIMIT " . $pages * $pageNumber . ", 25", [$name]);

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

    if ($output == []) {
        $result = SQL("SELECT DISTINCT name from articles", []);

        $output = [];

        while($news = mysqli_fetch_assoc($result)){
            array_push($output, array(
                'name' => rawurlencode($news['name'])
            ));
        }
    }

    echo json_encode($output);
?>