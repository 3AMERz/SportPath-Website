<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    }

include '../../init.php';
include 'connect.php';

function checkIfPassExist($password, $loginWith){
    global $conn;
    
    $sql = "SELECT * FROM users WHERE Password = '$password' AND loginWith = '$loginWith'";
    if($result = $conn->query($sql)){
        if ($result->num_rows == 1) {
            return true;
        }else {
            return false;
        }

    }

}

function getUserId_loginWith($password, $loginWith){
    global $conn;
    
    $sql = "SELECT UserID FROM users WHERE Password = '$password' AND loginWith = '$loginWith'";
	$result = $conn->query($sql);
	
	if (!empty($result) && $result->num_rows == 1) {
        $User = $result->fetch_assoc();
        return $User['UserID'];
    }else {
        return 'UserID not founded by ' . $loginWith . 'login.';
    }
}

function getUsername_loginWith($password, $loginWith){
    global $conn;
    
    $sql = "SELECT Username FROM users WHERE Password = '$password' AND loginWith = '$loginWith'";
	$result = $conn->query($sql);
	
	if (!empty($result) && $result->num_rows == 1) {
        $User = $result->fetch_assoc();
        return $User['Username'];
    }else {
        return 'UserID not founded by ' . $loginWith . 'login.';
    }
}

function emailExists($email){
    global $conn;

    $sql = "SELECT Email FROM users WHERE Email='" . $email ."'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function usernameExists($username){
    global $conn;

    $sql = "SELECT Username FROM users WHERE Username='" . $username ."'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function getUsername($fristName, $lastName){
    $Username = $fristName;
    if(is_string($lastName)){
        $Username .= ucfirst($lastName);
    }

    if(!usernameExists($Username)){
        return $Username;
    }

    $number = 1;
    while(true){
        if(usernameExists($Username . strval($number))){
            $number++;
        }else{
            $Username .= $number;
            break;
        }
    }

    return $Username;
}

function getCorrectUsername($Username){

    if(!usernameExists($Username)){
        return $Username;
    }

    $number = 1;
    while(true){
        if(usernameExists($Username . strval($number))){
            $number++;
        }else{
            $Username .= $number;
            break;
        }
    }

    return $Username;
}



function getFristName($username){
    $str = explode(' ', $username)[0];
    return $str;
}

function getLastName($username){
    $arr = explode(' ', $username);
    unset($arr[0]);

    $str = implode('', array_map("ucfirst", $arr));
    return $str;
}




if(isset($_POST['action']) && $_POST['action'] == 'loginWithGoogle'){
    
    require_once('../../../../../vendor/autoload.php');

    // Get $id_token via HTTPS POST.
    $id_token = $_POST['id_token'];
    $client = new Google_Client(['client_id' => $client_id]);

    $payload = $client->verifyIdToken($id_token);
    if ($payload) {
        // echo json_encode($payload);
        $FirstName = $payload['given_name'];
        $LastName = $payload['family_name'];
        $password = $payload['sub'];
        $passHashed = sha1($password);
        $Email = $payload['email'];
        $Gender = 'Not Defined';
        $loginWith = 'Google';
        $Datetime   = date('Y/m/d H:i:s', time());

    if(!checkIfPassExist($passHashed, $loginWith)){

        $Username = getUsername($FirstName, $LastName);
        
        if(emailExists($Email)){
            echo 'Email is used in anouther account.';
            exit();
        }
        $sql = "INSERT INTO users (Username, Password, Email, FirstName, LastName, Gender, loginWith, Datetime) VALUES 
        ('$Username', '$passHashed', '$Email', '$FirstName', '$LastName', '$Gender', '$loginWith', '$Datetime')";

        if (!$conn->query($sql) === TRUE){
            echo "Error: " . $sql . "<br>" . $conn->error;
            exit();
        }
    }

    $_SESSION['UserID'] = getUserId_loginWith($passHashed, $loginWith);
    $_SESSION['Username'] = getUsername_loginWith($passHashed, $loginWith);
    $_SESSION['GroupID'] = 0;
    $_SESSION['loginWith'] = $loginWith;

    // echo $_SESSION['UserID'] . $_SESSION['Username'] . $_SESSION['GroupID'] . $_SESSION['loginWith'];
    echo true ;

    } else {
      echo 'Invalid ID token for login with google.';
    }
    
}


if(isset($_POST['action']) && $_POST['action'] == 'loginWithGithub' && isset($userArr)){
    
    $Username = getCorrectUsername($userArr['login']);
    $FirstName = $userArr['name'];
    $password = $userArr['id'];
    $passHashed = sha1($password);
    $Email = $userArr['email'];
    $Gender = 'Not Defined';
    $loginWith = 'GitHub';
    $Datetime   = date('Y/m/d H:i:s', time());

    if(!checkIfPassExist($passHashed, $loginWith)){
        
        if(emailExists($Email)){
            echo 'Email is used in anouther account.';
            header( "Refresh:5; url=https://sportpath.org/login.php", true, 303);
            exit();
        }
        $sql = "INSERT INTO users (Username, Password, Email, FirstName, Gender, loginWith, Datetime) VALUES 
        ('$Username', '$passHashed', '$Email', '$FirstName', '$Gender', '$loginWith', '$Datetime')";

        if (!$conn->query($sql) === TRUE){
            echo "Error: " . $sql . "<br>" . $conn->error;
            exit();
        }
    }

    $_SESSION['UserID'] = getUserId_loginWith($passHashed, $loginWith);
    $_SESSION['Username'] = getUsername_loginWith($passHashed, $loginWith);
    $_SESSION['GroupID'] = 0;
    $_SESSION['loginWith'] = $loginWith;

    echo $_SESSION['UserID'] . $_SESSION['Username'] . $_SESSION['GroupID'] . $_SESSION['loginWith'];

    header('Location: https://sportpath.org/');
    exit;

    
}





if(isset($_POST['action']) && $_POST['action'] == 'loginWithFacebook'){
    

    $id = $_POST['id'];
    $name = $_POST['name'];

    $FirstName = getFristName($name);
    $LastName = getLastName($name);
    $Username = getUsername($FirstName, $LastName);
    $passHashed = sha1($id);
    $Gender = 'Not Defined';
    $loginWith = 'Facebook';
    $Datetime   = date('Y/m/d H:i:s', time());

    if(!checkIfPassExist($passHashed, $loginWith)){

        $sql = "INSERT INTO users (Username, Password, FirstName, LastName, Gender, loginWith, Datetime) VALUES 
        ('$Username', '$passHashed', '$FirstName', '$LastName', '$Gender', '$loginWith', '$Datetime')";

        if (!$conn->query($sql) === TRUE){
            echo "Error: " . $sql . "<br>" . $conn->error;
            exit();
        }
    }

    $_SESSION['UserID'] = getUserId_loginWith($passHashed, $loginWith);
    $_SESSION['Username'] = getUsername_loginWith($passHashed, $loginWith);
    $_SESSION['GroupID'] = 0;
    $_SESSION['loginWith'] = $loginWith;

    // echo $_SESSION['UserID'] . " " . $_SESSION['Username'] . " " . $_SESSION['GroupID'] . " " . $_SESSION['loginWith'];
    
    echo true ;
}