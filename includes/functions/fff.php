<?php



// if($_FILES['file']['name'] != ''){


//     $uploadOk = 1;
//     $imageFileType = strtolower(pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION));
//     $target_dir = "";
//     $target_file = $target_dir . "ImageCourse." . $imageFileType;
    

//     // Check if image file is a actual image or fake image
//     if(isset($_POST["submit"])) {
//       $check = getimagesize($_FILES["file"]["tmp_name"]);
//       if($check !== false) {
//         echo "File is an image - " . $check["mime"] . ".\n";
//         $uploadOk = 1;
//       } else {
//         echo "File is not an image.\n";
//         $uploadOk = 0;
//       }
//     }
    
    
//     // Check file size
//     if ($_FILES["file"]["size"] > 500000) {
//       echo "Sorry, your file is too large.\n";
//       $uploadOk = 0;
//     }
    

//     // Allow certain file formats
//     if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
//     && $imageFileType != "gif" ) {
//       echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.\n";
//       $uploadOk = 0;
//     }

    
//     // Check if $uploadOk is set to 0 by an error
//     if ($uploadOk == 0) {
//       echo "Sorry, your file was not uploaded.\n";
//     // if everything is ok, try to upload file
//     } else {
//       if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
//         echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.\n";
//         echo '<img src="'.$target_file.'" height="100" width="100" />';
        
//       } else {
//         echo "Sorry, there was an error uploading your file.\n";
//       }
//     }
// }


require_once '../../apps/phpmailer-master/mail.php';

$mail->setFrom('porject.web1@gmail.com', 'Mailer');
$mail->addAddress('porject.web1@gmail.com');
$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';

$mail->send();


// $to       = 'porject.web1@gmail.com';
// $subject  = 'Testing sendmail.exe';
// $message  = 'Hi, you just received an email using sendmail!';
// $headers  = 'From: porject.web1@gmail.com' . "\r\n" ;
// if(mail($to, $subject, $message, $headers))
// echo "Email send";
// else
//     echo "Email sending failed";