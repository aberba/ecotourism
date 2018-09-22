<?php

// Make sure your PHPMailer (an SMTP mail library, Google if you don't know) 
path is used instead
require_once("PHPMailer/class.phpmailer.php");
require_once("PHPMailer/class.smtp.php");

$Mailer = new PHPMailer();
$SMTP   = new SMTP();

class Email {
  
    //Sends email using SMTP credentials
    function send($to="", $subject="", $message="") {
       global $Mailer, $SMTP, $Settings; //create Settings class to use here
 
       $Mailer->isSMTP();
       $Mailer->Host     = $Settings->smtp_host();
       $Mailer->Port     = $Settings->smtp_port();
       $Mailer->SMTPAuth = true;
       $Mailer->Username = $Settings->smtp_user_name();
       $Mailer->Password = $Settings->smtp_password();
       
       $Mailer->FromName = $Settings->site_name();
       $Mailer->From     = $Settings->site_public_email();
       $Mailer->addAddress($to);
       $Mailer->Subject  = $subject;
       $message = wordwrap($message, 70);
       $Mailer->Body     = $message;
       
       return ($Mailer->send() === true) ? true : false;   
    }
}
$Email = new Email();
?>