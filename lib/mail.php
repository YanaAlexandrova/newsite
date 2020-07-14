<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';


$mail = new PHPMailer(true);

$post = xss($_POST);

if(isset($post['phone'])) {
    
    
    $mail = new PHPMailer();
    
    $mail->CharSet = 'utf-8';
	$mail->setFrom('team@fiatti.co', 'Fiatti');
    $mail->addAddress('london.ooo@yandex.ru');   // Адрес, на который отправляются письма
    $mail->addReplyTo(' team@fiatti.co', 'Information');
    $mail->isHTML(true);
    $mail->Subject = 'Новый заказ с сайта';
    
    
    $message = '';
    
    $message .= "Телефон: {$post['phone']}\r\n" . "<br>";
    
    if(isset($post['address'])) $message .= "Адрес сайта или наименование компании: {$post['address']}\r\n" . "<br>";
    if(isset($post['post'])) $message .= "Электронная почта: {$post['post']}\r\n" . "<br>";
    if(isset($post['address'])) $message .= "Запрос/комментарий: {$post['address']}\r\n";
    
    
    $mail->Body = $message;
    $mail->AltBody = $message;
    
    if($mail->send()) {
     echo "Письмо отправлено";   
    } else {
        echo 'Письмо не отправлено';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
    
}


function xss($data) {
    if(is_array($data)){
        $esc = array();
        foreach($data as $key => $value){
            $esc[$key] = xss($value);
        }
        return $esc;
    }
    return trim(htmlspecialchars($data));
}

?>