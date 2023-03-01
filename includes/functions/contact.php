<?php

require_once '../../apps/phpmailer-master/mail.php';

  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];
  $subject = $_POST['subject'];

  $Errors = array();

  if ($name === '') {
    array_push($Errors, array('message' => 'Name cannot be empty', 'type' => 'name', 'code' => 0));
  }

  if ($email === '') {
    array_push($Errors, array('message' => 'Email cannot be empty', 'type' => 'email', 'code' => 0));
  } 
  else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      array_push($Errors, array('message' => 'Email format invalid', 'type' => 'email', 'code' => 0));
    }
  }

  if ($subject === '') {
    array_push($Errors, array('message' => 'Subject cannot be empty', 'type' => 'subject', 'code' => 0));
  }

  if ($message === '') {
    array_push($Errors, array('message' => 'Message cannot be empty', 'type' => 'message', 'code' => 0));
  }




  if(!empty($Errors)){
    echo json_encode($Errors);
    exit();
  }


$content = "From: $name <br/>Email: $email <br/>Message: $message";


$mail->setFrom($email, $name);
$mail->addAddress('porject.web1@gmail.com');

$mail->isHTML(true);
$mail->Subject = $subject;
$mail->Body    = $content;
$mail->send();

echo json_encode(array('message' => 'Email sent successfully, thank you for contacting us.', 'code' => 1));
exit();
  
  

?>