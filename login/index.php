<?php
    session_start();

    if (isset($_SESSION['user']) === true) {
        if (isset($_SESSION["redirect"])) {
            header("Location: ../" . $_SESSION['redirect']);
            die();
        }
        header("Location: ../");
        die();
    }
?>

<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https:///fonts.googleapis.com/css?family=Roboto:300,400">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>

    <title>Registrierung ShS</title>
</head>

<body>
    <nav>
        <div class="menu-bar">
            <ul class="nav-links">
                <li class="active"><a href="../index.php">Home</a>
                </li>
                <li>
                    <a href="../shs/index.php">ShS</a>
                    <div class="sub-menu-1">
                        <ul>
                            <li><a href="../shs/information/index.php">Informationen</a></li>
                            <!--##-->
                            <li><a href="../shs/anmeldung/index.php">Anmeldung</a></li>
                            <li><a href="../shs/team/index.php">Team</a></li>
                            <li><a href="../signup/index.php">Registrierung</a></li>
                            <li><a href="../login/index.php">Login</a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="../schuelerrat/aktuelles/index.php">Schülerrat</a>
                    <!--##-->
                    <div class="sub-menu-1">
                        <ul>
                            <li><a href="../schuelerrat/aktuelles/index.php">Aktuelles</a></li>
                            <li><a href="../schuelerrat/allgemein/index.php">Allgemein</a></li>
                            <li><a href="../schuelerrat/vorstand/index.php">Vorstand</a></li>
                            <li><a href="../schuelerrat/arbeitsgruppen/index.php">Arbeitsgruppen</a></li>
                            <li><a href="../schuelerrat/kontakt/index.php">Kontakt</a></li>
                            <?php
                                if (isset($_SESSION['user'])) {
                                    if (in_array(strval("1"), explode(",", $_SESSION['berechtigungen'])) === TRUE) {
                                        echo '<li><a href="../editor/index.php?name=reden">neu: Statements</a></li>';
                                    }


                                    if (in_array(strval("0"), explode(",", $_SESSION['berechtigungen'])) === TRUE) {
                                        echo '<li><a href="../editor/index.php?name=schuelerrat">neu: Relevantes</a></li>';
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="../error/index.php">Schülerzeitung</a>
                    <div class="sub-menu-1">
                        <ul>
                            <li><a href="../error/index.php">Informationen</a></li>
                            <li><a href="../error/index.php">Vorstellung</a></li>
                            <li class="hover-me"><a href="../error/index.php">Blog</a><i class="fa-angel-right"></i>
                                <div class="sub-menu-2">
                                    <ul>
                                        <li><a href="../error/index.php">Schulleben</a></li>
                                        <li><a href="../error/index.php">Tipps und Tricks</a></li>
                                    </ul>
                                </div>

                            </li>
                            <li><a href="../error/index.php">internes System</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="../error/index.php">Projekte</a>
                    <div class="sub-menu-1">
                        <ul>
                            <li><a href="../error/index.php">Schulband</a></li>
                            <li><a href="../error/index.php">Schulclub</a></li>
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
    <main>

        <section class="home">
            <div class="container">
                <div class="img">
                    <img src="../assets/Login/shs_pic.png">
                </div>
                <div class="login-content">
                    <form action="login.php" method="post">
                        <h2 class="title">Login für die Anmeldung ShS</h2>
                        <div class="input-div pass">
                            <div class="i">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="div">
                                <h5>Benutzername</h5>
                                <input name="user" type="text" class="input" required auto autocomplete="off">
                            </div>
                        </div>
                        <div class="input-div pass">
                            <div class="i">
                                <i class="fas fa-lock"></i>
                            </div>
                            <div class="div">
                                <h5>Passwort</h5>
                                <input name="pass" type="password" class="input" required autocomplete="off">
                            </div>
                        </div>
                        <a href="../signup/index.php" onclick="location.reload()" class="abbrechen">Hast du dich noch nicht registriert? Dann klick hier ✔️</a>
                        <a onclick="location.reload()" class="abbrechen">Abbrechen? ❌</a>
                        <input type="submit" class="btn" value="Ich melde mich an">
                    </form>
                </div>
            </div>
            </div>
            <script type="text/javascript" src="../signup/regis.js"></script>
    </main>
    <footer>
        <div class="footer">
            <ul>
                <li>
                    <div class="titleR">
                        Rechtliches
                    </div>
                    <div class="buttonsR">
                        <a href="../general/datenschutz/index.php">Datenschutzerklärung</a><br>
                        <a href="../general/impressum/index.php">Impressum</a><br>
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