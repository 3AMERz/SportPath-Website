<?php
// include "../connect.php";

function getCountry($id){
    global $conn;

    $sql = "SELECT country_name FROM countries WHERE country_id ='$id'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 && 2 > $result->num_rows) {
		
		$countryRow = $result->fetch_assoc();
        return $countryRow['country_name'];

    	}
	else {
		echo "Not found country name from this id, 
        Or there`s tow countries they have same id.";
	}
}

function getUsersCountries(){
    global $conn;

    $Countries = array();

    $sql = "SELECT country_id FROM users";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {

		while($row = $result->fetch_assoc()) {
            if(!empty($row['country_id'])){
            array_push($Countries, getCountry($row['country_id']));
            }
        }
	}
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
	}

    return $Countries;
}

function getUsersCountriesChart_Xvalues($array){
    return array_slice(array_keys($array), 0, 10);
}

function getUsersCountriesChart_Yvalues($array){
    return array_slice(array_values($array), 0, 10);
}






$UsersCountries = getUsersCountries();

$count_UsersCountries = array_count_values($UsersCountries);
arsort($count_UsersCountries);


$UsersCountriesChart_Xvalues = getUsersCountriesChart_Xvalues($count_UsersCountries);
$UsersCountriesChart_Yvalues = getUsersCountriesChart_Yvalues($count_UsersCountries);

