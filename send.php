<?php
// Файлы phpmailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Переменные, которые отправляет пользователь
$name = $_POST['name'];
$email = $_POST['email'];
$text = $_POST['text'];

// Проверяем валидность EMail
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $msg = "ok";
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";                                          
    $mail->SMTPAuth   = true;

    
    $mail->Host = 'ssl://smtp.mail.ru'; // SMTP сервера
    $mail->Username = 'bebeshkomail'; // Логин на почте
    $mail->Password = 'hakatonhakaton'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('bebeshkomail@mail.ru', 'Алена'); // Адрес самой почты

    // Получатель письма
    $mail->addAddress('bebeshkomail@mail.ru');     

    // Прикрипление файлов к письму
if (!empty($_FILES['myfile']['name'][0])) {
    for ($ct = 0; $ct < count($_FILES['myfile']['tmp_name']); $ct++) {
        $uploadfile = tempnam(sys_get_temp_dir(), sha1($_FILES['myfile']['name'][$ct]));
        $filename = $_FILES['myfile']['name'][$ct];
        if (move_uploaded_file($_FILES['myfile']['tmp_name'][$ct], $uploadfile)) {
            $mail->addAttachment($uploadfile, $filename);
        } else {
            $msg .= 'Неудалось прикрепить файл ' . $uploadfile;
        }
    }   
}

        
				// письмо
			   
				$mail->isHTML(true);
			
				$mail->Subject = 'Заголовок письма';
				$mail->Body    = "<b>Имя:</b> $name <br>
				<b>Почта:</b> $email<br><br>
				<b>Сообщение:</b><br>$text";


// отравленность сообщения
if ($mail->send()) {
    echo "$msg";
} else {
echo "Сообщение не было отправлено. Неверно указаны настройки вашей почты";
}

} catch (Exception $e) {
    echo "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}

} else {
    echo 'mailerror';
}