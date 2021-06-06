<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https:///fonts.googleapis.com/css?family=Roboto:300,400">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>


    <title>Informationen ShS</title>
    <link rel="stylesheet" href="./information.css">


    <style>
        .attribution {
            font-size: 11px;
            text-align: center;
        }
        
        .attribution a {
            color: hsl(228, 45%, 44%);
        }
    </style>
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
                            <!--##-->
                            <li><a href="../anmeldung/index.php">Anmeldung</a></li>
                            <li><a href="../../shs/team/index.php">Team</a></li>
                            <li><a href="../../signup/index.php">Registrierung</a></li>
                            <li><a href="../../login/index.php">Login</a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="../../schuelerrat/aktuelles/index.php">Schülerrat</a>
                    <!--##-->
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
    <section id="header">
        <div class="container">
            <!--<div class="nav">
            <div class="logo"><img src="../assets/Schülerrats-Logo querformat.JPG" alt="logo"></div>
            <a href="#" type="button" class="cta cta-header">Ab zu Moodle</a>
          </div>-->
            <div class="hero">
                <div class="hero-info">
                    <h1>Informationen Schüler helfen Schülern</h1>
                    <p> Herzlich Willkommen, auf der Informationenseite vom Projekt Schüler helfen Schülern. In den folgenden Abschnitten wirst du einige Informationen zum Projekt allgemein und dazu, wie du dich anmelden kannst, finden. </p>
                    <a href="../../signup/index.php" type="button" class="cta cta-hero">Zur Registrierung</a>
                </div>
                <div class="hero-img"><img src="../../assets/Main_shs/shs.png" alt=""></div>
            </div>
        </div>
    </section>
    <section id="cards">
        <div class="container">
            <div class="card-item">
                <div class="card-info">
                    <h3>Allgeime Informationen</h3>
                    <p>Schüler helfen Schülern ist ein Nachhilfeprojekt, welches euch Schülern ermöglicht euch gegenseitig unter die Arme zu greifen und von einander zu profitieren. Schüler treten in die Rolle der Nachhilfelehrer und unterstützen ihre Mitschüler.
                        Indem ihr an diesem Projekt teilnehmt, werdet ihr als Nachhilfelehrer online Nachhilfeunterricht geben und als Nachhilfeschüler diesen erhalten. Sobald wir wieder andere Möglichkeiten haben, werden wir uns natürlich auch wieder
                        analog sehen. Bis dahin könnt ihr per Videokonferenzen an diesem Projekt teilnehmen. </p>
                </div>
                <div class="card-img"><img src="../../assets/one.png" alt="img" class="test"></div>
            </div>
            <div class="card-item">
                <div class="card-info">
                    <h3>Online Informationen</h3>
                    <p>Indem wir unserer Organisation und unseren Unterricht, in den online Bereich verlegen, machen wir unser Projekt flexibel und innovativ. Das gibt uns die Chance zu jederzeit Nachhilfe für euch Schüler zu ermöglichen. </p>
                </div>
                <div class="card-img"><img src="../../assets/two.png" alt="img" class="test"></div>
            </div>
            <div class="card-item">
                <div class="card-info">
                    <h3>Registrierung</h3>
                    <p>Die Registrierung dient zur Sicherheit des Anmeldungsprozess für ShS. Du musst dich registrieren um an dem Projekt ShS teilzunehmen. </p>
                </div>
                <div class="card-img"><img src="../../assets/three.png" alt="img" class="test"></div>
            </div>
            <div class="card-item">
                <div class="card-info">
                    <h3>Login</h3>
                    <p>Beim Login gibst du dein Benutzername und Passwort von der Registrierung ein. Anschließend kommst du zur eigentlich Anmeldung.
                    </p>
                </div>
                <div class="card-img"><img src="../../assets/four.png" alt="img" class="test"></div>
            </div>
            <div class="card-item">
                <div class="card-info">
                    <h3>Anmeldung</h3>
                    <p>Melde dich an unserem Projekt an, um Teil unserer Nachhilfe zu werden. Sobald du dich bei uns angemeldet hast, werden deine Daten in unserer Datenbank gesichert. Keine Sorge, deine Daten sind dort geschützt! Mit Hilfe dieser Daten
                        können wir dir einen geeigneten Lernpartner zu teilen.
                        <b>Anmeldung ab 23.03.2021</b></p>
                </div>
                <div class="card-img"><img src="../../assets/five.png" alt="img" class="test"></div>
            </div>
            <div class="card-item">
                <div class="card-info">
                    <h3>Bestätigungsemail</h3>
                    <p>Wenn du dich erfolgreich bei uns registriert und angemeldet hast, bekommst du von uns eine Bestätigungsmail. In ihr findest du weitere Informationen zu deinem Partner und Details zu euren Lernstunden. </p>
                </div>
                <div class="card-img"><img src="../../assets/six.png" alt="img" class="test"></div>
            </div>
            <div class="card-item">
                <div class="card-info">
                    <h3>Bezahlung</h3>
                    <p>
                        Eine Bezahlung der Nachhilfeleherer*innen ist nicht auf üblichem Weg, per Übergabe bei den Nachhilfestunden, möglich, da wir online Konferenzen durchführen. Aus diesem Grund muss dies auf eine andere Art und Weise stattfinden. Es ist uns nicht möglich
                        über ein einheitliches Konto dies zu verwalten, daher muss diese Angelegenheit unter den beiden Lernpartnern ausgemacht werden. Die Bezahlung kann daher bei jedem Lernteam individuell von statten gehen (bspw. Überweisung). Dazu
                        sollten auch die Eltern beider Teilnehmer*innen in Kontakt miteinander treten, da die beteiligten Schüler noch nicht geschäftsfähig sind. Der Kontakt zwischen den Teilnehmern wird über shs vermittelt. Die Eltern müssen im Anschluss
                        über die Schüler selbstständig für die Bezahlung in Kontakt treten. Bei Problemen steht euch unser shs-Team zur Verfügung.
                    </p>
                </div>
                <div class="card-img"><img src="../../assets/geld.png" alt="img" class="test"></div>
            </div>
        </div>
    </section>


    <script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
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