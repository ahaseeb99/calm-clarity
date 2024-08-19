<?php
/**
 * Mailing System
 * @author Bylancer
 * @Copyright (c) 2015-18 Devendra Katariya (bylancer.com)
 */

include_once('class.phpmailer.php');
include_once('class.smtp.php');
include_once('PHPMailerAutoload.php');

if(get_option('quickad_debug')) {
    $config['smtp_debug'] = 2;
} else {
    $config['smtp_debug'] = 0;
}

$from_email = get_option("from_email", get_option("admin_email"));


# SMTP***********************************
if ($config['email_type'] == 'smtp') {

    $mail = new PHPMailer();
    $mail->IsSMTP();

   /* $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );*/

    $mail->Host = trim($config['smtp_host']);
    $mail->SMTPAuth = trim($config['smtp_auth']);
    $mail->SMTPDebug = trim($config['smtp_debug']);
    $mail->Debugoutput = 'html';
    $mail->SMTPKeepAlive = true;
    if ($config['smtp_secure'] == 1) {# SSL
        $mail->SMTPSecure = 'ssl';
    } else if ($config['smtp_secure'] == 2) {# TLS
        $mail->SMTPSecure = 'tls';
    }
    $mail->Username = trim($config['smtp_username']);
    $mail->Password = trim($config['smtp_password']);
    $mail->Port = trim($config['smtp_port']);
    $mail->Priority = 1;
    $mail->Encoding = 'base64';
    $mail->CharSet = "utf-8";
    $mail->IsHTML(true);
    $mail->ContentType = "text/html";
    $mail->AuthType = get_option('smtp_auth_type', 'LOGIN');

    $mail->SetFrom(trim($from_email), $name = trim($config['site_title']));
    if ($email_reply_to != null) {
        $mail->AddReplyTo($email_reply_to, $email_reply_to_name);
    }

    /* Clear Mails */
    $mail->clearAddresses();
    $mail->clearCustomHeaders();
    $mail->clearAllRecipients();
    $mail->AddAddress($email_to, $email_to_name);
    $mail->Subject = $email_subject;
    $mail->Body = $email_body;

    $errors = [];
    $mail->Debugoutput = function($string, $level) use(&$errors) {
        $errors[] = $string;
    };

    /* Send Error */
    if (!$mail->Send()) {
        return !empty($errors) ? $errors : false;
    } else {
        return !empty($errors) ? $errors : true;
    }
} # PHPMail*******************************************************************************
else if ($config['email_type'] == 'mail') {

    $mail = new PHPMailer(true);
    $mail->Debugoutput = 'html';
    $mail->Priority = 1;
    //$mail->Encoding = 'base64';
    $mail->CharSet = "utf-8";

    $mail->IsHTML(true);
    $mail->ContentType = "text/html";

    $mail->SetFrom(trim($from_email), $name = $config['site_title']);
    if ($email_reply_to != null) {
        $mail->AddReplyTo($email_reply_to, $email_reply_to_name);
    }

    /* Clear Mails */
    $mail->clearAddresses();
    $mail->clearCustomHeaders();
    $mail->clearAllRecipients();
    $mail->AddAddress($email_to, $email_to_name);
    $mail->Subject = $email_subject;
    $mail->Body = $email_body;

    $errors = [];
    $mail->Debugoutput = function($string, $level) use(&$errors) {
        $errors[] = $string;
    };

    /* Send Error */
    if (!$mail->Send()) {
        return !empty($errors) ? $errors : false;
    } else {
        return !empty($errors) ? $errors : true;
    }
} # Amazon SES*******************************************************************************
else if ($config['email_type'] == 'aws') {

    $mail = new PHPMailer();
    $mail->IsSMTP();

    $mail->Host = 'email-smtp.' . $config['aws_host'] . '.amazonaws.com';
    $mail->SMTPAuth = true;
    $mail->SMTPDebug = $config['smtp_debug'];
    $mail->Debugoutput = 'html';
    $mail->SMTPKeepAlive = true;
    $mail->SMTPSecure = 'tls';
    $mail->Username = $config['aws_access_key'];
    $mail->Password = $config['aws_secret_key'];
    $mail->Port = 587;

    $mail->Priority = 1;
    $mail->Encoding = 'base64';
    $mail->CharSet = "utf-8";
    $mail->IsHTML(true);
    $mail->ContentType = "text/html";

    $mail->SetFrom(trim($from_email), $name = $config['site_title']);
    if ($email_reply_to != null) {
        $mail->AddReplyTo($email_reply_to, $email_reply_to_name);
    }

    /* Clear Mails */
    $mail->clearAddresses();
    $mail->clearCustomHeaders();
    $mail->clearAllRecipients();
    $mail->AddAddress($email_to, $email_to_name);
    $mail->Subject = $email_subject;
    $mail->Body = $email_body;

    $errors = [];
    $mail->Debugoutput = function($string, $level) use(&$errors) {
        $errors[] = $string;
    };

    /* Send Error */
    if (!$mail->Send()) {
        return !empty($errors) ? $errors : false;
    } else {
        return !empty($errors) ? $errors : true;
    }

} # # Mandrill*******************************************************************************
else if ($config['email_type'] == 'mandrill') {

    $mail = new PHPMailer();
    $mail->IsSMTP();

    $mail->Host = 'smtp.mandrillapp.com';
    $mail->SMTPAuth = true;
    $mail->SMTPDebug = $config['smtp_debug'];
    $mail->Debugoutput = 'html';
    $mail->SMTPKeepAlive = true;
    $mail->SMTPSecure = 'tls';
    $mail->Username = $config['mandrill_user'];
    $mail->Password = $config['mandrill_key'];
    $mail->Port = 587;

    $mail->Priority = 1;
    $mail->Encoding = 'base64';
    $mail->CharSet = "utf-8";
    $mail->IsHTML(true);
    $mail->ContentType = "text/html";

    $mail->SetFrom(trim($from_email), $name = $config['site_title']);
    if ($email_reply_to != null) {
        $mail->AddReplyTo($email_reply_to, $email_reply_to_name);
    }

    # *************************************************************************
    /* Clear Mails */
    $mail->clearAddresses();
    $mail->clearCustomHeaders();
    $mail->clearAllRecipients();
    $mail->AddAddress($email_to, $email_to_name);
    $mail->Subject = $email_subject;
    $mail->Body = $email_body;

    $errors = [];
    $mail->Debugoutput = function($string, $level) use(&$errors) {
        $errors[] = $string;
    };

    /* Send Error */
    if (!$mail->Send()) {
        return !empty($errors) ? $errors : false;
    } else {
        return !empty($errors) ? $errors : true;
    }
    # *************************************************************************
} # ********************************************************************************************************************************
else if ($config['email_type'] == 'sendgrid') { # SendGrid
    $mail = new PHPMailer();
    $mail->IsSMTP();

    $mail->Host = 'smtp.sendgrid.net';
    $mail->SMTPAuth = true;
    $mail->SMTPDebug = $config['smtp_debug'];
    $mail->Debugoutput = 'html';
    $mail->SMTPKeepAlive = true;
    $mail->SMTPSecure = 'tls';
    $mail->Username = $config['sendgrid_user'];
    $mail->Password = $config['sendgrid_pass'];
    $mail->Port = 587;

    $mail->Priority = 1;
    $mail->Encoding = 'base64';
    $mail->CharSet = "utf-8";
    $mail->IsHTML(true);
    $mail->ContentType = "text/html";

    $mail->SetFrom(trim($from_email), $name = $config['site_title']);
    if ($email_reply_to != null) {
        $mail->AddReplyTo($email_reply_to, $email_reply_to_name);
    }

    /* Clear Mails */
    $mail->clearAddresses();
    $mail->clearCustomHeaders();
    $mail->clearAllRecipients();
    $mail->AddAddress($email_to, $email_to_name);
    $mail->Subject = $email_subject;
    $mail->Body = $email_body;

    $errors = [];
    $mail->Debugoutput = function($string, $level) use(&$errors) {
        $errors[] = $string;
    };

    /* Send Error */
    if (!$mail->Send()) {
        return !empty($errors) ? $errors : false;
    } else {
        return !empty($errors) ? $errors : true;
    }
}