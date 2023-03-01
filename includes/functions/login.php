<?php 
session_start();

include "connect.php";

if (isset($_POST['Email'])){

    $email = filter_var($_POST['Email'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['Password'], FILTER_SANITIZE_STRING);
    $hashedPass = sha1($password);

    $sql = "SELECT * FROM users WHERE Email ='$email' AND Password = '$hashedPass'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 && 2 > $result->num_rows) {
		
		$User = $result->fetch_assoc();

        $_SESSION['UserID'] = $User['UserID'];
        $_SESSION['Username'] = $User['Username'];
        $_SESSION['GroupID'] = $User['GroupID'];

        echo json_encode(array('code' => 1));
        exit();

    }else {
		echo json_encode(array('message' => 'The email or password or both are incorrect.', 'code' => 0));
        exit();
    }

}




if (isset($_POST['Username'])){

    $username = filter_var($_POST['Username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['Password'], FILTER_SANITIZE_STRING);
    $hashedPass = sha1($password);

    $sql = "SELECT * FROM users WHERE Username ='$username' AND Password = '$hashedPass'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 && 2 > $result->num_rows) {
		
		$User = $result->fetch_assoc();

        $_SESSION['UserID'] = $User['UserID'];
        $_SESSION['Username'] = $User['Username'];
        $_SESSION['GroupID'] = $User['GroupID'];

        echo json_encode(array('code' => 1));
        exit();

    }else {
		echo json_encode(array('message' => 'The username or password or both are incorrect.', 'code' => 0));
        exit();
    }

}


?>