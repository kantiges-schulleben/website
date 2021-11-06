<?php
    session_start();
?>

<!doctype html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Schülerrat</title>
    <link rel="stylesheet" href="https:///fonts.googleapis.com/css?family=Roboto:300,400">
    <link rel="stylesheet" href="./allgemein.css">
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
            <h2>Willkommen zur <b>Allgemeinen Vorstellung</b> vom</h2>
            <h1>Schülerrat</h1>
        </div>
    </div>

    <div class="field">
        <h3>Allgemein</h3>
        <h4 id="Reden/Statements">Allgemein</h4>

        <h6><b>Wer sind wir?</b></h6><br><br>
        <img src="" alt="">
        <div class="text">
            Wir sind der Schülerrat. Unser Gremium wird von über 60 Klassen- & Kurssprecher*innen, sowie deren Stellvertreter*innen gebildet. Zusammen versuchen wir unsere Schülerschaft zu vertreten und einen Raum, um Demokratie zu erleben zu bieten. Wir sind Eure
            Ansprechpartner*innen für Probleme mit Lehrer*innen, Mitschüler*innen oder anderen Anliegen aber auch offen für Einwürfe und Ideen, wie unser Schulalltag schöner gestaltet werden kann. Dafür findet ein wöchentliches Treffen statt, in dem diskutiert,
            zugehört und mitgestaltet werden kann. Durch diese Art der Kommunikation haben wir es schon geschafft einen Klassenarbeitsplan für die Sek I, zur Entlastung der Schüler*innen, einzuführen, den Schulclub zu eröffnen und die Projekte „Schüler
            helfen Schüler“, sowie die Bildung von Arbeitsgruppen zu etablieren. Des Weiteren zeigen wir unser Engagement in Aktionen wie der Müllsammelaktion auf dem Schützplatz oder dem Gedenken vom 09.11 an den Holocaust. Wir versuchen uns dabei immer
            weiter zu entwickeln und selbst zu reflektieren, was zum Beispiel bei den jährlichen Seminarfahrten umgesetzt wird. Dort können wir uns mit aktuellen Thematiken intensiver auseinandersetzen und das Zusammenarbeiten stärken. Doch damit das
            alles auch umgesetzt werden kann, werden zum Beginn jedes Schuljahres die Klassen- & Kurssprecher*innen, sowie der Vorstand gewählt. Dieser besteht aus eine*r Schülersprecher*in, sein*er Vertreter*in , den Schulkonferenzmitgliedern und den
            StadtSchülerRats-Delegierten. Der Vorstand ist dafür zuständig Eure Interessen vor der Schulkonferenz und dem Stadtschülerrat zu vertreten. Unterstützt steht uns dabei unser*e Vertrauenslehrer*in zur Seite.
        </div>

        <h6><b>Doch was genau ist die Schulkonferenz?</b></h6><br><br>
        <img src="" alt="">
        <div class="text">
            In der Schulkonferenz trifft sich die Schulleitung mit der gewählten Eltern- & Schüler*innenvertretung. Diese Vertreter*innen werden auch Schulkonferenzmitglieder*innen genannt. Zusammen wird dann über zukünftige Schulentscheidungen und aktuelle schulinterne
            Problematiken diskutiert und abgestimmt. Die Schulkonferenz ist damit das höchste Gremium der Schule.
        </div>

        <h6><b>Und was ist der Stadtschülerrat?</b></h6><br><br>
        <img src="" alt="">
        <div class="text">
            In dem Stadtschülerrat treffen sich all die gewählten SchadtSchülerRats-Deligiert*innen. Diese kommen von den verschiedensten Schularten aus ganz Leipzig zusammen. Bei den vierteljährigen Treffen findet ein Austausch über allgemeine, relevante Probleme
            an Schulen statt. Genauso wird der Fokus aber auch auf die Entwicklung von Lösungsansätzen gesetzt.
        </div><br><br><br>
        <img src="../../assets/allgemein/plenum.jpg" alt=""><br><br><br><br><br>
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
