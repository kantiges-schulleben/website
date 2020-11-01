<?php
    include_once("../include/functions.inc.php");
    
    $key = $_POST['key'];
    $mode = $_POST['mode']; //1 -> in titel, 2 -> in text, 3 -> in titel und text
    
    $blogName = "";
    if (isset($_POST['blogname'])) {
        $blogName = $_POST['blogname'];
    }

    $result;

    if ($mode == "1") {
        $result = SQL("SELECT * FROM articles WHERE title LIKE '%?%' AND name LIKE '%?%'", [$key, $blogName]);
    } else if($mode == "2") {
        $result = SQL("SELECT * FROM articles WHERE content LIKE '%?%' AND name LIKE '%?%'", [$key, $blogName]);
    } else if($mode == "3") {
        $result = SQL("SELECT * FROM articles WHERE (title LIKE '%?%' OR content LIKE '%?%')  AND name LIKE '%?%'", [$key, $key, $blogName]);
    }

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

    echo json_encode($output);
?>