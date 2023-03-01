<?php
include "connect.php";
require_once('../../../../../vendor/autoload.php');

// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create();


function countiesIDs_InArr(){
    global $conn;

    $Arr = array();

    $query = " SELECT * FROM countries ORDER BY country_name ASC ";
    $result = $conn->query($query);

    foreach($result as $row) {
        array_push($Arr, $row["country_id"]);
    }
    return $Arr;
}
$countiesIDs = countiesIDs_InArr();


function SA_CitiesIDs_InArr(){
    global $conn;

    $Arr = array();

    $query = " SELECT * FROM sa_cities ORDER BY id ASC ";
    $result = $conn->query($query);

    foreach($result as $row) {
        array_push($Arr, $row["id"]);
    }
    return $Arr;
}


function getPhoneNumber(){
    global $faker;
    $numbers = "";
    for ($i=0; $i < 8; $i++) { 
        $numbers .= $faker->randomDigit();
    }
    return "05" . $numbers;
}




for ($i=0; $i < 0; $i++) { 
    $Gender = $faker->randomElement(['male', 'female']);

    // $name = $faker->name($Gender);
    // $Username = $faker->userName;
    $Email = $faker->safeEmail;
    $PhoneNumber = getPhoneNumber();
    $Gender = ucwords($Gender);
    $FirstName = $faker->firstName($Gender);
    $LastName = $faker->lastName($Gender);
    $Username = $FirstName . $LastName;
    $Birthday = $faker->date($format = 'Y/m/d', $max = 'now');
    $password = $faker->password;
    $passHashed = sha1($password);
    $country_id = $countiesIDs[$faker->numberBetween(0, count($countiesIDs))];
    $Datetime   = date('Y/m/d H:i:s', time());

    // echo $name . "\n" . $email . "\n" . $username . "\n" . $phone . "\n" .
    //  $Gender . "\n" . $FirstName . "\n" . $LastName . "\n" . $Birthday . "\n" 
    //  . $password . "\n" . $country_id . "\n" . $SA_Cities_id;

    if($country_id == 190) { // SA Id in database.
        $SA_CitiesIDs = SA_CitiesIDs_InArr();
        $SA_Cities_id = $SA_CitiesIDs[$faker->numberBetween(0, count($SA_CitiesIDs))];
        $sql = "INSERT INTO users (Username, Password, Email, PhoneNumber, FirstName, LastName, Gender, country_id, city_id, Birthday, Datetime) VALUES 
        ('$Username', '$passHashed', '$Email', '$PhoneNumber', '$FirstName', '$LastName', '$Gender', '$country_id', '$city_id', '$Birthday', '$Datetime')";
    }else{
        $sql = "INSERT INTO users (Username, Password, Email, PhoneNumber, FirstName, LastName, Gender, country_id, Birthday, Datetime) VALUES 
        ('$Username', '$passHashed', '$Email', '$PhoneNumber', '$FirstName', '$LastName', '$Gender', '$country_id', '$Birthday', '$Datetime')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Done!";
    } 
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}



