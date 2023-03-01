<?php

include 'connect.php';


function UsernameFormat($username){
    if(preg_match('/^[a-zA-Z][0-9a-zA-Z_]{2,19}$/', $username)) {
        return true;
    }else{
        return false;
    }
}

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

function PhoneNumberFormat($phoneNumber){
    if(preg_match('/^[0-9]{10}+$/', $phoneNumber) && substr($phoneNumber,0,2) == '05'){
        return true;
    }
    return false;
}

function birthdayValid($birthday){
    $userYear = explode('-', $birthday)[0];
    $allowAge = 7;
    
    if((date("Y")-$userYear) >= $allowAge){
        return true;
    }
    return false;
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

function phoneNumberExists($phoneNumber){
    global $conn;

    $sql = "SELECT PhoneNumber FROM users WHERE PhoneNumber='" . $phoneNumber ."'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

if(isset($_POST["action"]) && ($_POST["action"] =='CheckUsername') ){
    
    $Username   = filter_var($_POST['Username'], FILTER_SANITIZE_STRING);

    if(!usernameExists($Username) && UsernameFormat($Username) ){
        echo 'Available';
    }else{
        echo 'Unavailable';
    }
}

if(isset($_POST["action"]) && ($_POST["action"] =='insertUser') ){
    global $conn;

    $Username   = filter_var($_POST['Username'], FILTER_SANITIZE_STRING);
    $Password   = filter_var($_POST['Password'], FILTER_SANITIZE_STRING);
    $RePassword   = filter_var($_POST['RePassword'], FILTER_SANITIZE_STRING);
    $Email      = filter_var($_POST['Email'], FILTER_SANITIZE_EMAIL);
    $PhoneNumber= filter_var($_POST['PhoneNumber'], FILTER_SANITIZE_NUMBER_INT);
    $FirstName  = filter_var($_POST['FirstName'], FILTER_SANITIZE_STRING);
    $LastName   = filter_var($_POST['LastName'], FILTER_SANITIZE_STRING);
    $Gender     = $_POST['Gender'];
    $country_id = $_POST['country_id'];
    $city_id    = $_POST['city_id'];
    $Birthday   = preg_replace("([^0-9-])", "", $_POST['Birthday']);

    



    $Errors = array();

    if($Username === ''){
        array_push($Errors, array('message' => 'cannot be empty', 'type' => 'username', 'code' => 0));
    }
    else if(!UsernameFormat($Username)){
        array_push($Errors, array('message' => 'Username format invalid', 'type' => 'username', 'code' => 0));
    }
    else if(usernameExists($Username)){
        array_push($Errors, array('message' => "It's used in another account", 'type' => 'username', 'code' => 0));
    }


    if ($Password === ''){
        array_push($Errors, array('message' => 'cannot be empty', 'type' => 'password', 'code' => 0));
    }
    else if(!PassFormat($Password)){
            array_push($Errors, array('message' => 'Password format invalid', 'type' => 'password', 'code' => 0));
    }
    else if($RePassword === ''){
        array_push($Errors, array('message' => 'cannot be empty', 'type' => 'rePassword', 'code' => 0));
    }
    else if($Password !== $RePassword){
        array_push($Errors, array('message' => 'Password not equal RePassword', 'type' => 'rePassword', 'code' => 0));
    }      
    


    if ($Email === ''){
        array_push($Errors, array('message' => 'cannot be empty', 'type' => 'email', 'code' => 0));
    } 
    else if(!filter_var($Email, FILTER_VALIDATE_EMAIL)){
        array_push($Errors, array('message' => 'Email format invalid', 'type' => 'email', 'code' => 0));
    }
    else if(emailExists($Email)){
        array_push($Errors, array('message' => "It's used in another account", 'type' => 'email', 'code' => 0));
    }



    if ($PhoneNumber === ''){
        array_push($Errors, array('message' => 'cannot be empty', 'type' => 'phoneNumber', 'code' => 0));
    }
    else if(!PhoneNumberFormat($PhoneNumber)){
        array_push($Errors, array('message' => 'Phone Number format invalid', 'type' => 'phoneNumber', 'code' => 0));
    }
    else if(phoneNumberExists($PhoneNumber)){
        array_push($Errors, array('message' => "It's used in another account", 'type' => 'phoneNumber', 'code' => 0));
    }



    if ($FirstName === '') {
        array_push($Errors, array('message' => 'cannot be empty', 'type' => 'firstName', 'code' => 0));
    }
    else if(strlen($FirstName) < 3){
        array_push($Errors, array('message' => 'Must be at least 3 characters', 'type' => 'firstName', 'code' => 0));
    }



    if ($LastName === '') {
        array_push($Errors, array('message' => 'cannot be empty', 'type' => 'lastName', 'code' => 0));
    }
    else if(strlen($LastName) < 3){
        array_push($Errors, array('message' => 'Must be at least 3 characters', 'type' => 'lastName', 'code' => 0));
    }



    if ($Gender === '') {
        array_push($Errors, array('message' => 'Choose your gender', 'type' => 'gender', 'code' => 0));
    }


    if ($country_id === '') {
        array_push($Errors, array('message' => 'Choose your country', 'type' => 'country', 'code' => 0));
    }


    if ($city_id === '' && $country_id == 190) { // SA Id in database.
        array_push($Errors, array('message' => 'Choose your city', 'type' => 'city', 'code' => 0));
    }


    if ($Birthday === '') {
        array_push($Errors, array('message' => 'Enter your birthday', 'type' => 'birthday', 'code' => 0));
    }else if(!birthdayValid($Birthday)){
            array_push($Errors, array('message' => 'Sorry, minimum age is 7 years', 'type' => 'birthday', 'code' => 0));
    }




    if(!empty($Errors)){
        echo json_encode($Errors);
        exit();
    }
    


    $passHashed = sha1($Password);
    $Datetime   = date('Y/m/d H:i:s', time());

    if(!empty($city_id) && $country_id == 190) { // SA Id in database.
        $sql = "INSERT INTO users (Username, Password, Email, PhoneNumber, FirstName, LastName, Gender, country_id, city_id, Birthday, Datetime) VALUES 
        ('$Username', '$passHashed', '$Email', '$PhoneNumber', '$FirstName', '$LastName', '$Gender', '$country_id', '$city_id', '$Birthday', '$Datetime')";
    }else{
        $sql = "INSERT INTO users (Username, Password, Email, PhoneNumber, FirstName, LastName, Gender, country_id, Birthday, Datetime) VALUES 
        ('$Username', '$passHashed', '$Email', '$PhoneNumber', '$FirstName', '$LastName', '$Gender', '$country_id', '$Birthday', '$Datetime')";
    }
	
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array('message' => 'Registered successfully, enjoy!', 'code' => 1));
    } 
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


    

}


  



  
  