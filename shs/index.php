<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https:///fonts.googleapis.com/css?family=Roboto:300,400">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>

</head>
<link rel="stylesheet" href="style.css">
<title>Startseite Schüler helfen Schülern</title>
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


    <section class="home">
        <div class="showcase">
            <h2>Schüler helfen Schülern</h2>
            <img src="../assets/Main_shs/shs.png" alt="" />
            <div class="info">
                <h3>Werde Teil von Schüler helfen Schülern</h3>
                <p>Du möchtest helfen oder du brauchst Hilfe dann kannst du dich bei über diese Webseite beim Projekt ShS anmelden.

                </p>
            </div>
        </div>
    </section>
    <div class="features-container">
        <section class="features">

            <h2>So kommst du zur Nachhilfe</h2>


            <div class="cards">
                <div class="card">

                    <img src="../assets/info.jpg" alt="" />
                    <!--<a class="test" href="registrierung_shs.1.html"></a>-->
                    <h4>Informationen</h4>
                    <p>Informiere dich über das Projekt! Klicke <b><a style="color: black" href="./information/">hier</a></b> und erfahre mehr. </p>
                </div>
                <div class="card">
                    <img src="../assets/regestrierung1 (3).jpg" alt="" />
                    <h4>Registrierung</h4>
                    <p>Wenn du an dem Projekt „Schüler helfen Schülern“ teilnehmen möchtest. Egal ob als Nachhilfeschüler oder Nachhilfelehrer. Dann registriere dich <b><a style="color: black" href="../signup/">hier</a></b>.</p>
                </div>
                <div class="card">
                    <img src="../assets/login.jpg" alt="" />
                    <h4>Login</h4>
                    <p>
                        Wenn ja, kommst du <b><a style="color: black" href="../login/">hier</a></b> zum Login.
                    </p>
                </div>
            </div>
        </section>
    </div>

    <section class="home">
        <div id="erstelle" class="showcase">

            <p>
                Viel Spaß beim gemeinsamen Lernen. Euer ShS Team
            </p>
        </div>
    </section>
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