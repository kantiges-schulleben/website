<?php
    require_once("./include/PHPMailer.php");
    require_once("./include/SMTP.php");
    require_once("./include/Exception.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exceptions;

    $mail = new PHPMailer(true);

    if (!isset($_POST['fromMail']) || !isset($_POST['msg']) || !isset($_POST['grund']) || !isset($_POST['fromName'])) {
        die(json_encode(array(
            "success" => false
        )));
    } else {
        $senderMail = htmlspecialchars(strtolower($_POST['fromMail']), ENT_QUOTES);
        $senderName = htmlspecialchars(strtolower($_POST['fromName']), ENT_QUOTES);
        $msg = htmlspecialchars(strtolower($_POST['msg']), ENT_QUOTES);
        $grund = htmlspecialchars($_POST['grund'], ENT_QUOTES);
    
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
            $mail -> addReplyTo($senderName, $senderMail);
    
            $mail -> isHTML(false);
            $mail -> Subject = "Mitteilung über Kontaktformular - " + $grund;
            $mail -> Body = $msg;
    
            $mail -> send();
            die(json_encode(array(
                "success" => true
            )));
        } catch (Exception $e) {
            die(json_encode(array(
                "success" => false,
                "msg" => $mail -> ErrorInfo
            )));
        }
    }
?>