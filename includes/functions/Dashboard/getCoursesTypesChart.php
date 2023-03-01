<?php

function getCourseType($id){
    global $conn;

    $sql = "SELECT type_name FROM types WHERE type_id ='$id'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 && 2 > $result->num_rows) {
		
		$row = $result->fetch_assoc();
        return $row['type_name'];

    	}
	else {
		echo "Not found type name from this id, 
        Or there`s tow types they have same id.";
	}
}

function getCoursesTypes(){
    global $conn;

    $Types = array();

    $sql = "SELECT type_id FROM courses";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {

		while($row = $result->fetch_assoc()) {
            if($row['type_id'] == NULL){continue;}
            array_push($Types, getCourseType($row['type_id']));
        }
	}
    else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
	}

    return $Types;
}


function getCoursesTypesChart_Xvalues($array){
    return array_keys($array);
}

function getCoursesTypesChart_Yvalues($array){
    return array_values($array);
}






$CoursesTypes = getCoursesTypes();

$count_CoursesTypes = array_count_values($CoursesTypes);
arsort($count_CoursesTypes);


$CoursesTypesChart_Xvalues = getUsersCountriesChart_Xvalues($count_CoursesTypes);
$CoursesTypesChart_Yvalues = getUsersCountriesChart_Yvalues($count_CoursesTypes);
