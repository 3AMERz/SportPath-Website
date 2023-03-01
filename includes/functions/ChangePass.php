<?php

include "connect.php";

function PassFormat($password){

    // Validate password strength
    $hasUppercase = preg_match('@[A-Z]@', $password);
    $hasLowercase = preg_match('@[a-z]@', $password);
    $hasNumber    = preg_match('@[0-9]@', $password);
    $hasSpecialChars = preg_match('@[^\w]@', $password);

    if(!$hasUppercase || !$hasLowercase || !$hasNumber || !$hasSpecialChars || strlen($password) < 8) {
        return false;
    }else{
        return true;
    }
}

function CheckPassword($password,$userID){
    global $conn;

    $password = sha1($password);

    $sql = "SELECT Password FROM users WHERE UserID='" . $userID ."'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
      } else {
        echo "0 results";
      }

    if($password == $row["Password"]){
        return true;
    }
    else{
        return false;
    }
}


if(isset($_POST['action']) && ($_POST['action'] == 'ChangePassword') ){
    $UserID = $_POST['UserID'];
    $OldPassword = filter_var($_POST['OldPassword'], FILTER_SANITIZE_STRING);
    $NewPassword = filter_var($_POST['NewPassword'], FILTER_SANITIZE_STRING);
    $RepeatNewPassword = filter_var($_POST['RepeatNewPassword'], FILTER_SANITIZE_STRING);

    $Errors = array();

    if($OldPassword === ''){
        array_push($Errors, array('message' => 'cannot be empty', 'type' => 'oldPassword', 'code' => 0));
    }
    else if(!CheckPassword($OldPassword,$UserID)){
        array_push($Errors, array('message' => 'Old password is not correct', 'type' => 'oldPassword', 'code' => 0));
    }
    else if ($NewPassword === ''){
        array_push($Errors, array('message' => 'cannot be empty', 'type' => 'newPassword', 'code' => 0));
    }
    else if(!PassFormat($NewPassword)){
            array_push($Errors, array('message' => 'Password format invalid', 'type' => 'newPassword', 'code' => 0));
    }
    else if($NewPassword === $OldPassword){
        array_push($Errors, array('message' => 'Old password and new password are not same', 'type' => 'newPassword', 'code' => 0));
    }
    else if($RepeatNewPassword === ''){
        array_push($Errors, array('message' => 'cannot be empty', 'type' => 'repeatNewPassword', 'code' => 0));
    }
    else if($NewPassword !== $RepeatNewPassword){
        array_push($Errors, array('message' => 'New password and repeat new password are not same', 'type' => 'repeatNewPassword', 'code' => 0));
    }  
    
    

    if(!empty($Errors)){
        echo json_encode($Errors);
        exit();
    }

    $NewPassword = sha1($NewPassword);
    $sql = "UPDATE users SET Password ='$NewPassword' WHERE UserID = '$UserID'";    
    if ($conn->query($sql) === TRUE) {
            echo json_encode(array('message' => 'Password changed successfully!', 'code' => 1));
    } 
    else {
        echo "Error changing record: " . $conn->error . "\n";
    }
    exit();
}




