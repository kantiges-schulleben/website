<?php
    session_start();

    if (isset($_SESSION['userADMIN'])) {
    } else {
        header("Location: ./login");
    }

    require_once("../../include/PHPMailer.php");
    require_once("../../include/SMTP.php");
    require_once("../../include/Exception.php");

    require_once("../../include/functions.inc.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exceptions;

    // ließt alle daten aus der Datenbank aus und bereitet sie auf die Übergabe zum Auswertungsscript vor
    $result = SQL("SELECT * FROM shsAnmeldung", ["empty"]);

    $output = [];


    while($news = mysqli_fetch_assoc($result)) {
        $facher = explode(',', $news['fach']);
        if ($facher !== $news['fach']) {
            for ($i = 0; $i < count($facher); $i++) {
                array_push($output, array(
                    'name' => $news['name'],
                    'mail' => $news['mail'],
                    'klasse' => $news['klasse'],
                    'telefon' => $news['telefon'],
                    'nachhilfe' => $news['nachhilfe'],
                    'facher' => $facher[$i],
                    'zeit' => $news['zeit'],
                    'einzelnachhilfe' => $news['einzelnachhilfe'],
                    'accountID' => $news['accountID'],
                    'Bemerkung' => $news['bemerkung'],
                    'zielKlasse' => $news['zielKlasse']
                ));
            }
        } else {
            array_push($output, array(
                'name' => $news['name'],
                'mail' => $news['mail'],
                'klasse' => $news['klasse'],
                'telefon' => $news['telefon'],
                'nachhilfe' => $news['nachhilfe'],
                'facher' => $news['fach'],
                'zeit' => $news['zeit'],
                'einzelnachhilfe' => $news['einzelnachhilfe'],
                'accountID' => $news['accountID'],
                'Bemerkung' => $news['bemerkung'],
                'zielKlasse' => $news['zielKlasse']
            ));
        }
    }

    $parameter = json_encode($output);

    // die($parameter);

    // Script starten (obviously)
    $output = json_decode(exec("python3 script.py " . "'" . $parameter . "'"), true);
    // $output = json_decode(exec("python3 script.py --use-default"), true);
    // die(json_encode($output));


    // Mailer initialisieren
    $mail = new PHPMailer(true);
    // $mail -> SMTPDebug = SMTP::DEBUG_SERVER;
    $mail -> isSMTP();
    $mail -> Host = "mail.gmx.net";
    $mail -> SMTPAuth = true;
    $mail -> Username = "kantiges-schulleben@gmx.de";
    $mail -> Password = "PASSWORD";
    $mail -> SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail -> Port = 587;
    $mail -> setFrom("kantiges-schulleben@gmx.de", "Schüler helfen Schülern");
    $mail -> isHTML(true);
    $mail -> Subject = "Rückmeldung Partner";
    $mail -> CharSet = 'UTF-8';

    sendMail("monsieurk1209@gmail.com", json_encode($output));

    $firstOrderGroups = ["einzel", "gruppe", "ohne"];

    // print_r(createText($output[$firstOrderGroups[0]][0], 0));

    // Datenbank löschen
    SQL("DELETE FROM handschlag", ["null"]);
    $counter = 0;
    // über alle Paare loopen und Emails mit den wichtigen Daten versenden, um die Schüler und Lehrer zu informieren
    for ($group = 0; $group < count($firstOrderGroups); $group++) {
        for ($i = 0; $i < count($output[$firstOrderGroups[$group]]); $i++) {
            $rawMailData = createText($output[$firstOrderGroups[$group]][$i], $group);
            $mailAddresses = $rawMailData[0];
            $texts = $rawMailData[1];

            for ($j = 0; $j < count($mailAddresses); $j++) {
                echo "to: " . $mailAddresses[$j] . "<br>content: " . $texts[$j] . "<br><br>=====================================<br>";
                sendMail($mailAddresses[$j], $texts[$j]);
            }
        }
        $counter++;
    }

    SQL("DELETE FROM shsAnmeldung", ["null"]);
    echo json_encode(array(
        "counter" => $counter,
        "status" => "fertig"
    ));


    // TODO ausgabe schöner formatieren vielleicht HTML/CSS mail?
    function createText($inputData, $mode) {
        /*
        * 0 ->  einzel
        * 1 ->  gruppe
        * 2 ->  ohne
        */


        $output = [];// 2d
        //             * D1 -> array der mail addressen
        //             * D2 -> array der texte

        $text = "";

        $partner = "";
        $mailPartner = "";
        $telefonPartner = "";
        $fachPartner ="";

        $name = $inputData['name'];
        $mail = $inputData['mail'];
        $telefon = $inputData['telefon'];
        $accountID = $inputData['accountID'];
        $klasse = $inputData['klasse'];
        $fach = $inputData['facher'];

        if ($mode === 0) { // einzel
            $partner = $inputData['partner']['name'];
            $mailPartner = $inputData['partner']["mail"];
            $telefonPartner = $inputData['partner']["telefon"];
            $fachPartner = $inputData['partner']['facher'];
            $accountIDPartner = $inputData['partner']['accountID'];
            $klassePartner = $inputData['partner']['klasse'];

            $output = array(
                array($mail, $mailPartner),
                array("Hallo $name,<br>
                Wir freuen uns, dass du dich an dem Projekt „Schüler helfen Schülern“ beteiligen möchtest.<br>
                Hiermit bestätigen wir dir die Teilnahme als Nachhilfelehrer/in.<br><br>
                Du wirst $partner in diesem Schuljahr im Fach $fachPartner unterstützen.<br>
                Sie/Ihn erreichst du unter: $mailPartner<br>
                oder mit ihrer/seiner Telefonnummer: $telefonPartner<br><br>
                Bei weiteren Fragen helfen wir gern über <a href = 'mailto:shs@kantgym-leipzig.de'>shs@kantgym-leipzig.de</a> weiter.<br>
                Wir wünschen dir Spaß am Lernen und ein schönes Schuljahr.<br><br>
                Bleib gesund!<br>
                Dein Schüler helfen Schülern-Team",
                
                "Hallo $partner,<br>
                Wir freuen uns, dass du dich an dem Projekt „Schüler helfen Schülern“ beteiligen möchtest.<br>
                Hiermit bestätigen wir dir die Teilnahme als Nachhilfeschüler/in.<br><br>
                $name wird dich in diesem Schuljahr im Fach $fachPartner unterstützen.<br>
                Sie/Ihn erreichst du unter: $mail<br>
                oder mit ihrer/seiner Telefonnummer: $telefon<br><br>
                Bei weiteren Fragen helfen wir gern über <a href = 'mailto:shs@kantgym-leipzig.de'>shs@kantgym-leipzig.de</a> weiter.<br>
                Wir wünschen dir Spaß am Lernen und ein schönes Schuljahr.<br><br>
                Bleib gesund!<br>
                Dein Schüler helfen Schülern-Team"
                )
            );

            //lehrer
            SQL("INSERT INTO handschlag (fach, id, partner, klasse, typ) VALUES (?, ?, ?, ?, ?)", [$fachPartner, $accountID, $accountIDPartner, $klasse, "lehrer"]);
            //schüler
            SQL("INSERT INTO handschlag (fach, id, partner, klasse, typ) VALUES (?, ?, ?, ?, ?)", [$fachPartner, $accountIDPartner, $accountID, $klassePartner, "schueler"]);

        } else if ($mode === 1) { // gruppe
            $namenPartner = [$name];
            $mailsPartner = [$mail];
            $telefonPartner = [$telefon];
            $accountIDPartner = [$accountID];
            $klassePartner = [$klasse];
            $texte = [];

            for ($person = 1; $person < intval($inputData["anzahlPartner"]) + 1; $person++) {
                array_push($namenPartner, $inputData["partner"][strval($person)]["name"]);
                array_push($mailsPartner, $inputData["partner"][strval($person)]["mail"]);
                array_push($telefonPartner, $inputData["partner"][strval($person)]["telefon"]);
                array_push($accountIDPartner, $inputData["partner"][strval($person)]["accountID"]);
                array_push($klassePartner, $inputData["partner"][strval($person)]["klasse"]);
            }

            $fach = $inputData['facher'];

            if (intval($inputData["anzahlPartner"]) > 1) {
                array_push($texte, "Hallo $name,<br>
                Wir freuen uns dir mitzuteilen, dass wir Lernpartner für dich gefunden haben.<br>
                " . substr(ignoreNConnect($namenPartner, $name, "", " & "), 0, -3) . " sind für das nächste Jahr deine Schützlinge.<br>
                Du kannst sie folgendermaßen erreichen:<br>
                Email:" . ignoreNConnect($mailsPartner, $mail, "<br>", "") ."<br>
                Telefon:" . ignoreNConnect($telefonPartner, $telefon, "<br>", "") ."<br>
                oder über unseren [Webchat](link zu chat)<br>
                Mit freundlichen Grüßen<br><br>
                das ShS-Team");
            } else {
                array_push($texte, "Hallo $name,<br>
                Wir freuen uns, dass du dich an dem Projekt „Schüler helfen Schülern“ beteiligen möchtest.<br>
                Hiermit bestätigen wir dir die Teilnahme als Nachhilfelehrer/in.<br><br>
                Du wirst $namenPartner[0] in diesem Schuljahr im Fach $fach unterstützen.<br>
                Sie/Ihn erreichst du unter: $mailsPartner[0]<br>
                oder mit ihrer/seiner Telefonnummer: $telefonPartner[0]<br><br>
                Bei weiteren Fragen helfen wir gern über <a href = 'mailto:shs@kantgym-leipzig.de'>shs@kantgym-leipzig.de</a> weiter.<br>
                Wir wünschen dir Spaß am Lernen und ein schönes Schuljahr.<br><br>
                Bleib gesund!<br>
                Dein Schüler helfen Schülern-Team");
            }
            // $partner = substr($partner, 0, -2);
            SQL("INSERT INTO handschlag (fach, id, partner, klasse, typ) VALUES (?, ?, ?, ?, ?)", [$fach, $accountID, ignoreNConnect($accountIDPartner, $accountID, "", ","), $klasse, "lehrer"]);


            for ($person = 1; $person < intval($inputData["anzahlPartner"]) + 1; $person++) {
                array_push($texte, "Hallo " . $inputData['partner'][strval($person)]['name'] . ",<br>
                Wir freuen uns, dass du dich an dem Projekt „Schüler helfen Schülern“ beteiligen möchtest.<br>
                Hiermit bestätigen wir dir die Teilnahme als Nachhilfeschüler/in.<br><br>
                $name wird dich in diesem Schuljahr im Fach $fachPartner unterstützen.<br>
                Sie/Ihn erreichst du unter: $mail<br>
                oder mit ihrer/seiner Telefonnummer: $telefon<br><br>
                Bei weiteren Fragen helfen wir gern über <a href = 'mailto:shs@kantgym-leipzig.de'>shs@kantgym-leipzig.de</a> weiter.<br>
                Wir wünschen dir Spaß am Lernen und ein schönes Schuljahr.<br><br>
                Bleib gesund!<br>
                Dein Schüler helfen Schülern-Team");

                SQL("INSERT INTO handschlag (fach, id, partner, klasse, typ) VALUES (?, ?, ?, ?, ?)", [$fach, $accountIDPartner[$person], ignoreNConnect($accountIDPartner, $accountIDPartner[$person], "", ","), $klassePartner[$person], "schueler"]);
            }

            $output = array(
                $mailsPartner,
                $texte
            );
        } else { // ohne
            $output = array(
                array($mail),
                array(
                    "Hallo $name,<br>
                    Es tut uns leid, aber es konnte kein Partner für dich gefunden werden. Es gibt keine passende Anmeldung für Nachhilfe in deinem Fach.<br>
                    Versuche es doch im neuen Schuljahr wieder.<br>
                    Wenn du noch konkretere Anliegen hast, kannst du dich an unsere E-Mail <a href = 'mailto:shs@kantgym-leipzig.de'>shs@kantgym-leipzig.de</a> wenden.<br><br>
                    Viele Grüße<br>
                    Euer ShS-Team"
                )
            );
        }

        return $output;
    }

    function ignoreNConnect($array, $toBeIgnored, $spacerStart, $spacerEnd) {
        $stringified = "";

        foreach ($array as $value) {
            if ($value !== $toBeIgnored) {
                $stringified .= $spacerStart . $value . $spacerEnd;
            }
        }

        return $stringified;
    }

    function sendMail($to, $content) {
        global $mail;
        try {
            $mail -> addAddress($to);
            
            $mail -> Body = $content;
        
            $mail -> send();
        } catch (Exception $e) {
            $mail -> ErrorInfo;
        } finally {
            $mail -> ClearAddresses();
        }
    }
?>