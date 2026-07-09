<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../includes/PHPMailer-master/src/Exception.php';
require '../includes/PHPMailer-master/src/PHPMailer.php';
require '../includes/PHPMailer-master/src/SMTP.php';

header('Content-Type: application/json');

// تحقق من صحة البيانات المدخلة
if (empty($_POST['name']) || empty($_POST['subject']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  http_response_code(500);
  exit();
}

// تنظيف البيانات المدخلة
$name = strip_tags(htmlspecialchars($_POST['name']));
$email = strip_tags(htmlspecialchars($_POST['email']));
$subject = strip_tags(htmlspecialchars($_POST['subject']));
$message = strip_tags(htmlspecialchars($_POST['message']));

// إعداد البريد
$to = "email";  // البريد الذي سيصلك
$email_subject = "$subject: $name";
$email_body = "Name: $name\nEmail: $email\nSubject: $subject\nMessage:\n$message";

// ترويسة البريد
$headers = "From: $name <$email>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$mail = new PHPMailer(true);

try {
  // Server settings
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com'; // Your SMTP server
  $mail->SMTPAuth = true;
  $mail->Username = 'email'; // SMTP username
  $mail->Password = 'password';   // SMTP password
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port = 465;
  $mail->CharSet = 'UTF-8';

  print_r($mail);

  // Recipients
  $mail->setFrom($email, $name);
  $mail->addAddress('email');
  $mail->addReplyTo($email, $name);

  // Content
  $mail->isHTML(false);
  $mail->Subject = $subject;
  $mail->Body = $message;

  $mail->send();
  echo json_encode(['success' => true, 'message' => 'Message has been sent']);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(['success' => false, 'error' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
}