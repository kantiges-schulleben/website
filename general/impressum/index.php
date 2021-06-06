<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Impressum </title>
    <link rel="stylesheet" href="./impressum.css" />
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
                            <!--##-->
                            <li><a href="../../shs/anmeldung/index.php">Anmeldung</a></li>
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
    <main>


        <div class="container">

            <!--<span class="big-circle"></span>-->
            <!--<img src="Bilder/shape.png" class="square" alt="" />-->
            <div class="form">
                <div class="contact-info">
                    <h3 class="title">Impressum</h3>
                    <p class="text">
                        Hier findest du unser Impressum: Wenn du irgendwelche Fragen hast. Dann schreib uns per Kontaktformular.
                    </p>

                    <div class="info">
                        <div class="information">
                            <img src="../../assets/location.png" class="icon" alt="" />
                            <p>Immanuel-Kant-Schule, Gymnasium der Stadt Leipzig Scharnhorststraße 15 04275 Deutschland
                            </p>
                        </div>
                        <div class="information">
                            <img src="../../assets/email.png" class="icon" alt="" />
                            <p>shs@kantgym-leipzig.de</p>
                        </div>
                        <div class="information">
                            <img src="../../assets/phone.png" class="icon" alt="" />
                            <p>0341 303480</p>
                        </div>
                    </div>

                    <div class="social-media">
                        <p>Da findest du uns auch :</p>
                        <div class="social-icons">
                            <a href="#">
                                <i class="fas fa-envelope-square"></i>
                            </a>
                            <a href="https://www.kantgym-leipzig.de/">
                                <i class="fas fa-laptop-house"></i>
                            </a>
                            <a href="https://www.instagram.com/schuelerrat_kantgym/?igshid=1t27mbn5r03ir">
                                <i class="fab fa-instagram ouImSoSpecialGetFucked"></i>
                            </a>
                            <a href="https://moodle.kant-elearning.de/">
                                <img src="https://img.icons8.com/ios-filled/50/000000/moodle.png" class="moodle" />
                            </a>
                        </div>
                    </div>
                </div>

                <div class="contact-form">
                    <span class="circle one"></span>
                    <span class="circle two"></span>

                    <form action="../../contact/index.php" autocomplete="off" method="POST">
                        <h3 class="title">Kontaktiere uns</h3>
                        <div class="input-container">
                            <input type="text" name="fromNameFirst" class="input" />
                            <label for="">Vorname</label>
                            <span>Vorname</span>
                        </div>
                        <div class="input-container">
                            <input type="text" name="fromNameLast" class="input" />
                            <label for="">Nachname</label>
                            <span>Nachname</span>
                        </div>
                        <div class="input-container">
                            <input type="tel" name="fromMail" class="input" />
                            <label for="">Email</label>
                            <span>Email</span>
                        </div>
                        <div class="input-container textarea">
                            <textarea name="msg" class="input"></textarea>
                            <label for="">Nachricht</label>
                            <span>Nachricht</span>
                        </div>
                        <div class="check">
                            <input type="checkbox" class="ceckk" required> Ich habe die <a href="../../general/datenschutz/index.php">Datenschutzerklärung</a><br> gelesen und erkläre mich damit einverstanden!
                        </div>
                        <input type="submit" value="senden" class="btn" />
                    </form>
                </div>
            </div>
        </div>
        <script src="../../shs/team/teamtest.js"></script>
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

</html>