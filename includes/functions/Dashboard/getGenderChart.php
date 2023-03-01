<?php



function getUsersGender(){
    global $conn;

    $Male; 
    $Female; 

    $sql = "SELECT Gender FROM users";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
            if($row['Gender'] == 'Male'){
                global $Male;
                $Male++;
            }
            elseif($row['Gender'] == 'Female'){
                global $Female;
                $Female++;
            }
        }
	}
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
	}

    $Male = (empty($Male)) ? 0 : $Male;
    $Female = (empty($Female)) ? 0 : $Female;

    return array($Male,$Female);
}



$GenderChart_Yvalues = getUsersGender();
