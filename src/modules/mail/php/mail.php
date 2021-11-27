<?php
    require_once("PHPMailer.php");
    require_once("SMTP.php");
    require_once("Exception.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exceptions;

    // TODO use json as parameter
    // AHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHH
    // IT HURTS SOOOOOOOOO MUCH!!!!!!!!!!
    $fromName = $argv[1];
    $fromMail = $argv[2];
    $toName = $argv[3];
    $toMail = $argv[4];
    $replyName = $argv[5];
    $replyMail = $argv[6];
    $subject = $argv[7];
    $content = $argv[8];

    $mail = new PHPMailer(true);

    try {
        // $mail -> SMTPDebug = SMTP::DEBUG_SERVER;
        $mail -> isSMTP();
        $mail -> Host = "mail.gmx.net";
        $mail -> SMTPAuth = true;
        $mail -> Username = "MAIL";
        $mail -> Password = "PASSWORD";
        $mail -> SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail -> Port = 587;

        $mail -> setFrom($fromMail, $fromName);
        $mail -> addAddress($toMail);
        $mail -> addReplyTo($replyMail, $replyName);

        $mail -> isHTML(true);
        $mail -> CharSet = 'UTF-8';
        $mail -> Subject = $subject;
        $mail -> Body = $content;

        $mail -> send();
        echo "success";
    } catch (Exception $e) {
        echo $e;
    }
?>
