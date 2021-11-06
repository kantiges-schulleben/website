<?php
    session_start();
?>

<!doctype html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Schülerrat - Arbeitsgruppen</title>
    <link rel="stylesheet" href="https:///fonts.googleapis.com/css?family=Roboto:300,400">
    <link rel="stylesheet" href="./arbeitsgruppen.css">
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
            <h2>Willkommen zur <b>Vorstellung der Arbeitsgruppen</b> vom</h2>
            <h1>Schülerrat</h1>
        </div>
    </div>

    <div class="field">
        <h3>Arbeitsgruppen</h3>
        <h4 id="Reden/Statements">Arbeitsgruppen</h4>

        <img src="" alt="">
        <h5>Schülerrat Arbeitsgruppen Vorstellung</h5><br><br>

        <h6><b>Kanterando:</b></h6><br><br>
        <img src="" alt="">
        <div class="text">
            Dass die Covid-19 Krise auch großartigen solidarischen Umgang schafft, beweist uns eine Gruppe von SchülerInnen ab der 8. Klasse. Diese hat nämlich ein tolles Projekt auf die Beine gestellt, um Risikogruppen in dieser schwierigen Zeit zu schützen und
            gleichzeitig zu helfen. In weiten Teilen Leipzigs wird von unseren SchülerInnen für Menschen eingekauft, die aufgrund körperlicher Beeinträchtigungen oder eines erhöhten Schutzaufkommens nicht selbst den örtlichen Supermarkt besuchen können.
            Für ihr Engagement wurde Kanterando schon in einen Artikel der Leipziger Volkszeitung gelobt. Du willst auch Teil des Teams werden und Leuten aus deiner Nachbarschaft helfen? Kein Problem, schreib dich einfach unter <a href="https://keinPlanWoHin.com">diesem Link </a>bei
            moodle ein oder wende dich an die Steuergruppe des Projekts (Freddy Völkner (12), Clara Niebisch (10d), Tina Völkner (10d), Hanna Möhring (10d), Jule Roßner (10d) und Kristian Lehmann (11)).
        </div>

        <h6><b>AG Mensa:</b></h6><br><br>
        <img src="../../assets/arbeitsgruppen/men.png" alt="">
        <div class="text">
            Das Essen schmeckt nicht, es gibt zu wenig vegetarische Gerichte, es ist laut und voll, die Ausgabe klappt nicht immer… Solche Beschwerden gehen immer häufiger beim Schülerrat ein und aus diesem Grund wird es zukünftig eine Arbeitsgruppe geben, die diese
            Probleme angeht. Es soll eine bereits geplante Mensarunde eingeführt werden, bei der Preis- und Qualitätsmängel der Gerichte mit dem Essensanbieter zusammen thematisiert und andere Beschwerden diskutiert werden sollen. Die Arbeitsgruppe kümmert
            sich darum, dass wir alle zukünftig in einer noch entspannteren Atmosphäre leckeres und vor allem für jeden(!) bezahlbares Essen genießen können.
        </div>

        <h6><b>Litfaßsäule:</b></h6><br><br>
        <img src="../../assets/arbeitsgruppen/lit.png" alt="">
        <div class="text">
            Falls es doch dem ein oder anderen noch nicht aufgefallen ist… Seit neustem schmückt eine Litfaßsäule das Erdgeschoss unserer Schule. Wo genau? Augen auf am Sekretariat, denn dort steht das bis jetzt noch das ungeschmückte Exemplar. Damit es in Zukunft
            nicht mehr so viele kahle Stellen gibt, braucht es ein paar motivierte SchülerInnen, um der Säule etwas Leben einzuhauchen. Erste Ideen gibt es da auch schon, zum Beispiel eine Sektion „Kantiges Schulleben“ oder eine Diskussionsecke. Es gibt
            noch viel Spielraum und kreative Entfaltungsmöglichkeiten, um den schulischen Austausch mit unserer eigenen Litfaßsäule anzuregen oder die Litfaßsäule als politische Austauschplattform zu nutzen. Und jetzt, wo sie schon mal da ist, können
            wir sie doch auch mit Wörtern bekleben, oder?
        </div>

        <h6><b>Grüner geht’s nicht:</b></h6><br><br>
        <img src="../../assets/arbeitsgruppen/gru.png" alt="">
        <div class="text">
            Nachdem beim neu angelaufenen Demokratieprojekt schon ein „grüner“ Vorschlag gewonnen hat, kommt gleich eine neue Arbeitsgruppe des Schülerrates hinterher. Diese hat sich zum Ziel gesetzt, das Kant-Gymnasium Leipzig neu auszustatten, und zwar mit Pflanzen,
            Bäumen und Beeten. Außerdem soll eine schon lang ersehnte Mülltrennung eingeführt werden, damit wir nicht nur in unserem Schulleben nachhaltiger agieren, sondern uns auch dessen besser bewusst werden. Auch auf eine erneute Müllsammelaktion
            freuen wir uns schon. Wer also Lust hat das Kant aktiv mitzugestalten und ein bisschen (grüne) Farbe ins Spiel zu bringen, kann sich gerne unter <a href="https://keinPlanWoHin.com">diesem Link</a> im moodle Kurs für die AG einschreiben.
            Besser und grüner geht’s wirklich nicht</h6><br><br><br><br><br><br><br><br>
        </div>
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
