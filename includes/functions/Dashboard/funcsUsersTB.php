<?php 

include '../connect.php';

function is_sha1($str) {
    return (bool) preg_match('/^[0-9a-f]{40}$/i', $str);
}

function UsernameFormat($username){
    if(preg_match('/^[a-zA-Z][0-9a-zA-Z_]{2,19}$/', $username)) {
        return true;
    }else{
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

function printNull($val){
    if(!$val == NULL){
        return "'". $val ."'";
    }
    else{
        return 'NULL';
    }
}

function PhoneNumberFormat($phoneNumber){
    if(preg_match('/^[0-9]{10}+$/', $phoneNumber) && substr($phoneNumber,0,2) == '05'){
        return true;
    }
    return false;
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



function usernameExists_Edit($username, $user_id){
    global $conn;

    $sql = "SELECT Username FROM users WHERE Username='$username' AND UserID != '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function emailExists_Edit($email, $user_id){
    global $conn;

    $sql = "SELECT Email FROM users WHERE Email='$email' AND UserID != '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function phoneNumberExists_Edit($phoneNumber, $user_id){
    global $conn;

    $sql = "SELECT PhoneNumber FROM users WHERE PhoneNumber='$phoneNumber'  AND UserID!='$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}
    

if(isset($_POST['usersDel'])){

    $usersDel = $_POST['usersDel'];
    foreach($usersDel as $id){
    
        $sql = "DELETE FROM users WHERE UserID = '$id'";
    
        if ($conn->query($sql) === TRUE) {
            echo "Successful deletion.\n";
        } else {
            echo "Error deleting record: " . $conn->error . "\n";
        }
    
    }

}


if(isset($_POST["action"]) && ($_POST["action"] =='insertUser') ){

    $Username = $_POST['Username'];

    $Password = $_POST['Password'];
    $passHashed = sha1($Password);
    
    $Email = !empty($_POST['Email']) ? $_POST['Email'] : NULL;
    $PhoneNumber = !empty($_POST['PhoneNumber']) ? $_POST['PhoneNumber'] : NULL;
    $FirstName = !empty($_POST['FirstName']) ? $_POST['FirstName'] : NULL;
    $LastName = !empty($_POST['LastName']) ? $_POST['LastName'] : NULL;
    $Gender = $_POST['Gender'];
    $country_id = !empty($_POST['country_id']) ? $_POST['country_id'] : NULL;
    $city_id = !empty($_POST['city_id']) ? $_POST['city_id'] : NULL;
    $loginWith = $_POST['loginWith'];
    $Birthday = !empty($_POST['Birthday']) ? $_POST['Birthday'] : NULL;
    $GroupID = $_POST['GroupID'];
    $Datetime = date('Y/m/d H:i:s', time());


    $Errors = array();

    if(!UsernameFormat($Username)  && $loginWith == 'Default'){
        array_push($Errors, array('message' => 'Username format invalid', 'type' => 'username', 'code' => 0));
    }
    else if(usernameExists($Username)){
        array_push($Errors, array('message' => "It's used in another account", 'type' => 'username', 'code' => 0));
    }


    if(!filter_var($Email, FILTER_VALIDATE_EMAIL)  && $loginWith == 'Default'){
        array_push($Errors, array('message' => 'Email format invalid', 'type' => 'email', 'code' => 0));
    }
    else if(emailExists($Email)){
        array_push($Errors, array('message' => "It's used in another account", 'type' => 'email', 'code' => 0));
    }


    if(!PhoneNumberFormat($PhoneNumber)  && $loginWith == 'Default'){
        array_push($Errors, array('message' => 'Phone Number format invalid', 'type' => 'phoneNumber', 'code' => 0));
    }
    else if(phoneNumberExists($PhoneNumber)){
        array_push($Errors, array('message' => "It's used in another account", 'type' => 'phoneNumber', 'code' => 0));
    }


    if(!empty($Errors)){
        echo json_encode($Errors);
        exit();
    }


    
    if(!empty($city_id) && $country_id == 190) { // SA Id in database.
        $sql = "INSERT INTO users (Username, Password, Email, PhoneNumber, FirstName, LastName, Gender, country_id, city_id, Birthday, GroupID, Datetime) VALUES 
        ('$Username', '$passHashed', ".printNull($Email).", ".printNull($PhoneNumber).", ".printNull($FirstName).", ".printNull($LastName).", '$Gender', ".printNull($country_id).", ".printNull($city_id).", ".printNull($Birthday).", '$GroupID', '$Datetime')";
    }else{
        $sql = "INSERT INTO users (Username, Password, Email, PhoneNumber, FirstName, LastName, Gender, country_id, Birthday, GroupID, Datetime) VALUES 
        ('$Username', '$passHashed', ".printNull($Email).", ".printNull($PhoneNumber).", ".printNull($FirstName).", ".printNull($LastName).", '$Gender', ".printNull($country_id).", ".printNull($Birthday).", '$GroupID', '$Datetime')";
    }
	
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array('message' => 'Successful addition.', 'code' => 1));
    } 
    else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    exit();
}



if(isset($_POST["action"]) && ($_POST["action"] =='getUser') ){

    $user_id = $_POST['user_id'];
    
    $sql = "SELECT * FROM users WHERE UserID ='$user_id'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 && $result->num_rows < 2) {
		
		$User = $result->fetch_assoc();
        
        $output = array(
			'Username'	=>	$User['Username'],
			'Password'	=>	$User['Password'],
			'Email'	    =>  $User['Email'],
			'PhoneNumber'=>	$User['PhoneNumber'],
			'FirstName'	=>	$User['FirstName'],
			'LastName'	=>	$User['LastName'],
			'Gender'	=>	$User['Gender'],
			'country_id'=>	$User['country_id'],
			'city_id'	=>	$User['city_id'],
			'loginWith'	=>	$User['loginWith'],
			'Birthday'	=>	$User['Birthday'],
			'GroupID'	=>	$User['GroupID']
		);
	  
		echo json_encode($output);
	} 
    else {
		echo "FALSE";
	}

}



if(isset($_POST["action"]) && ($_POST["action"] =='updateUser') ){

    $UserID = $_POST['UserID'];
    $Username = $_POST['Username'];

    $Password = $_POST['Password'];
    if(is_sha1($Password)){
        $passHashed = $Password;
    } else{
        $passHashed = sha1($Password);
    }
    
    $Email = !empty($_POST['Email']) ? $_POST['Email'] : NULL;
    $PhoneNumber = !empty($_POST['PhoneNumber']) ? $_POST['PhoneNumber'] : NULL;
    $FirstName = !empty($_POST['FirstName']) ? $_POST['FirstName'] : NULL;
    $LastName = !empty($_POST['LastName']) ? $_POST['LastName'] : NULL;
    $Gender = $_POST['Gender'];
    $country_id = !empty($_POST['country_id']) ? $_POST['country_id'] : NULL;
    $city_id = !empty($_POST['city_id']) ? $_POST['city_id'] : NULL;
    $loginWith = $_POST['loginWith'];
    $Birthday = !empty($_POST['Birthday']) ? $_POST['Birthday'] : NULL;
    $GroupID = $_POST['GroupID'];

    $Errors = array();

    if(!UsernameFormat($Username) && $loginWith == 'Default'){
        array_push($Errors, array('message' => 'Username format invalid', 'type' => 'username', 'code' => 0));
    }
    else if(usernameExists_Edit($Username, $UserID)){
        array_push($Errors, array('message' => "It's used in another account", 'type' => 'username', 'code' => 0));
    }


    if(!filter_var($Email, FILTER_VALIDATE_EMAIL) && $loginWith == 'Default'){
        array_push($Errors, array('message' => 'Email format invalid', 'type' => 'email', 'code' => 0));
    }
    else if(emailExists_Edit($Email, $UserID)){
        array_push($Errors, array('message' => "It's used in another account", 'type' => 'email', 'code' => 0));
    }


    if(!PhoneNumberFormat($PhoneNumber) && $loginWith == 'Default'){
        array_push($Errors, array('message' => 'Phone Number format invalid', 'type' => 'phoneNumber', 'code' => 0));
    }
    else if(phoneNumberExists_Edit($PhoneNumber, $UserID)){
        array_push($Errors, array('message' => "It's used in another account", 'type' => 'phoneNumber', 'code' => 0));
    }


    if(!empty($Errors)){
        echo json_encode($Errors);
        exit();
    }

    if(!empty($city_id) && $country_id == 190) { // SA Id in database.
        $sql = "UPDATE users SET Username ='$Username', Password = '$passHashed', Email = ".printNull($Email).", 
        PhoneNumber = ".printNull($PhoneNumber).", FirstName = ".printNull($FirstName).", LastName = ".printNull($LastName).", 
        Gender = '$Gender', country_id = ".printNull($country_id).", city_id = ".printNull($city_id).", Birthday = ".printNull($Birthday).", GroupID = '$GroupID' 
        WHERE UserID = '$UserID'";   
    }else{
        $sql = "UPDATE users SET Username ='$Username', Password = '$passHashed', Email = ".printNull($Email).", 
        PhoneNumber = ".printNull($PhoneNumber).", FirstName = ".printNull($FirstName).", LastName = ".printNull($LastName).", 
        Gender = '$Gender', country_id = ".printNull($country_id).", Birthday = ".printNull($Birthday).", GroupID = '$GroupID' 
        WHERE UserID = '$UserID'";
    }

	
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array('message' => 'Successful Update.', 'code' => 1));
    } 
    else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    exit();

}