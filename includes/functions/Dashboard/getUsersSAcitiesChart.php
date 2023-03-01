<?php

function getSAcity($id){
    global $conn;

    $sql = "SELECT nameEn FROM sa_cities WHERE id ='$id'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 && 2 > $result->num_rows) {
		
		$row = $result->fetch_assoc();
        return $row['nameEn'];

    	}
	else {
		echo "Not found city name from this id, 
        Or there`s tow city they have same id.";
	}
}

function getUsersCites(){
    global $conn;

    $Cites = array();

    $sql = "SELECT city_id FROM users";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {

		while($row = $result->fetch_assoc()) {
            if($row['city_id'] == NULL){continue;}
            array_push($Cites, getSAcity($row['city_id']));
        }
	}
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
	}

    return $Cites;
}

function getUsersCitesChart_Xvalues($array){
    return array_keys($array);
}

function getUsersCitesChart_Yvalues($array){
    return array_values($array);
}






$UsersCites = getUsersCites();

$count_UsersCites = array_count_values($UsersCites);
arsort($count_UsersCites);


$UsersSAcitesChart_Xvalues = getUsersCountriesChart_Xvalues($count_UsersCites);
$UsersSAcitesChart_Yvalues = getUsersCountriesChart_Yvalues($count_UsersCites);

