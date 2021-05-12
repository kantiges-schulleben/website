<?php
    session_start();

    include_once("../../include/functions.inc.php");

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

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

        if ($output == []) {
            die(file_get_contents("./noContent.html"));
        }
    } else {
        header("Location: ../../");
    }
?>

<!doctype html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?php
            echo rawurldecode($output[0]['title']);
        ?>
    </title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400">
    <link rel="stylesheet" href="./beitrag.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav>
        <div class="menu-bar">
            <ul class="nav-links">
                <li class="active"><a href="../../index.php">Home</a>
                </li>
                <li>
                    <a href="../../shs/index.php">ShS</a>
                    <div class="sub-menu-1">
                        <ul>
                            <li><a href="../../shs/information/index.php">Informationen</a></li>
                            <li><a href="../../shs/anmeldung/index.php">Anmeldung</a></li>
                            <li><a href="../../shs/team/index.php">Team</a></li>
                            <li><a href="../../signup/index.php">Registrierung</a></li>
                            <li><a href="../../login/index.php">Login</a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="../../schuelerrat/aktuelles/index.php">Schülerrat</a>
                    <div class="sub-menu-1">
                        <ul>
                            <li><a href="../../schuelerrat/aktuelles/index.php">Aktuelles</a></li>
                            <li><a href="../../schuelerrat/allgemein/index.php">Allgemein</a></li>
                            <li><a href="../../schuelerrat/vorstand/index.php">Vorstand</a></li>
                            <li><a href="../../schuelerrat/arbeitsgruppen/index.php">Arbeitsgruppen</a></li>
                            <li><a href="../../schuelerrat/kontakt/index.php">Kontakt</a></li>
                            <?php
                                if (isset($_SESSION['user'])) {
                                    if (in_array(strval("1"), explode(",", $_SESSION['berechtigungen'])) === TRUE) {
                                        echo '<li><a href="../../editor/index.php?name=reden">neu: Statements</a></li>';
                                    }


                                    if (in_array(strval("0"), explode(",", $_SESSION['berechtigungen'])) === TRUE) {
                                        echo '<li><a href="../../editor/index.php?name=schuelerrat">neu: Relevantes</a></li>';
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="../../error/index.php">Schülerzeitung</a>
                    <div class="sub-menu-1">
                        <ul>
                            <li><a href="../../error/index.php">Informationen</a></li>
                            <li><a href="../../error/index.php">Vorstellung</a></li>
                            <li class="hover-me"><a href="../../error/index.php">Blog</a><i class="fa-angel-right"></i>
                                <div class="sub-menu-2">
                                    <ul>
                                        <li><a href="../../error/index.php">Schulleben</a></li>
                                        <li><a href="../../error/index.php">Tipps und Tricks</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li><a href="../../error/index.php">internes System</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="../../error/index.php">Projekte</a>
                    <div class="sub-menu-1">
                        <ul>
                            <li><a href="../../error/index.php">Schulband</a></li>
                            <li><a href="../../error/index.php">Schulclub</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
        <script>
            const navSlide = () => {
                const burger = document.querySelector('.burger');
                const nav = document.querySelector('.nav-links');
                const navLinks = document.querySelectorAll('.nav-links li');

                burger.addEventListener('click', () => {
                    nav.classList.toggle('nav-active');

                    navLinks.forEach((link, index) => {
                        link.style.animation = `navLinkFade 0.5s ease forwards`;
                    });

                    burger.classList.toggle('toggle');
                });
            }
            navSlide();
        </script>
    </nav>

    <div class="outersplash">
        <div class="splash">
            <h2>
                <?php
                    echo rawurldecode($output[0]['name']);
                ?>
            </h2>
            <h1>
                <?php
                    echo rawurldecode($output[0]['title']);
                ?>
            </h1>
        </div>
    </div>

    <div class="field">
        <h3>
            <?php
                echo rawurldecode($output[0]['title']);
            ?>
        </h3>
        <h4 id="Reden/Statements">
            <?php
                echo rawurldecode($output[0]['title']);
            ?>
        </h4>

        <img src=<?php echo "../" . rawurldecode($output[0]['image']); ?> alt="">
        <div class="text">
            <?php
                $contentToOutput = "";
                $content = rawurldecode($output[0]['content']);
                
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
                
                echo $contentToOutput;
            ?>
        </div><br><br><br>

    </div>

    <footer>
        <div class="footer">
            <ul>
                <li>
                    <div class="titleR">
                        Rechtliches
                    </div>
                    <div class="buttonsR">
                        <a href="../../general/datenschutz/index.php">Datenschutzerklärung</a><br>
                        <a href="../../general/impressum/index.php">Impressum</a><br>
                    </div>
                </li>
                <li>
                    <div class="titleS">
                        Socialmedia
                    </div>
                    <div class="buttonsS">
                        <a href="https://www.kantgym-leipzig.de">Webseite unserer Schule</a><br>
                        <a href="https://www.instagram.com/schuelerrat_kantgym/">Instagram</a><br>
                    </div>
                </li>
            </ul>
            <div class="cc">
                <span class="far fa-copyright"></span><span>2021 All rights reserved.</span>
            </div>
        </div>
    </footer>
</body>

</html>
