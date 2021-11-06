<?php
    require_once("../include/PHPMailer.php");
    require_once("../include/SMTP.php");
    require_once("../include/Exception.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exceptions;

    $mail = new PHPMailer(true);

    if (!isset($_POST['fromMail']) || !isset($_POST['msg']) || !isset($_POST['fromNameFirst'])  || !isset($_POST['fromNameLast'])) {
        die(file_get_contents("error.html"));
    } else {
        $senderMail = htmlspecialchars(strtolower($_POST['fromMail']), ENT_QUOTES);
        $senderName = htmlspecialchars(strtolower($_POST['fromNameFirst']), ENT_QUOTES) . " " . htmlspecialchars(strtolower($_POST['fromNameLast']), ENT_QUOTES);
        $msg = htmlspecialchars(strtolower($_POST['msg']), ENT_QUOTES);
    
        try {
            // $mail -> SMTPDebug = SMTP::DEBUG_SERVER;
            $mail -> isSMTP();
            $mail -> Host = "mail.gmx.net";
            $mail -> SMTPAuth = true;
            $mail -> Username = "kantiges-schulleben@gmx.de";
            $mail -> Password = "PASSWORD";
            $mail -> SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail -> Port = 587;
    
            $mail -> setFrom("kantiges-schulleben@gmx.de", "Kontaktformular");
            $mail -> addAddress("shs@kantgym-leipzig.de");
            $mail -> addReplyTo($senderMail, $senderName);
    
            $mail -> isHTML(true);
            $mail -> CharSet = 'UTF-8';
            $mail -> Subject = "Mitteilung über Kontaktformular";
            $mail -> Body = $msg;
    
            $mail -> send();
            die(file_get_contents("success.html"));
        } catch (Exception $e) {
            die(file_get_contents("error.html"));
        }
    }
?>
