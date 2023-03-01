<?php 
include '../connect.php';



if(isset($_POST['arrayDel'])){
    
    $arrayDel = $_POST['arrayDel'];
    foreach($arrayDel as $id){

        $sql = "DELETE FROM types WHERE type_id = '$id'";

        if ($conn->query($sql) === TRUE) {
            echo "Successful deletion.\n";

        } else {
            echo "Error deleting record: " . $conn->error . "\n";
        }
    
    }




}


if( isset($_POST["action"]) && ($_POST["action"] =='insertType') ){

    $type_name	=	$_POST["type_name"];    
    
    
    $sql = "INSERT INTO types (type_name) VALUES ('$type_name')";
        
    if ($conn->query($sql) === TRUE) {
        echo "Successful addition.";  
    }else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

}   


if( isset($_POST["action"]) && ($_POST["action"] =='updateType') ){

    $type_id	=	$_POST["type_id"];    
    $type_name	=	$_POST["type_name"];    

    $sql = "UPDATE types SET type_name ='$type_name' 
    WHERE type_id = '$type_id'";
	
    if ($conn->query($sql) === TRUE) {
        echo "Successful Update.";
    }
    else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

}





if( isset($_POST["action"]) && ($_POST["action"] =='getType') ){

    $type_id = $_POST['type_id'];
    
    $sql = "SELECT * FROM types WHERE type_id ='$type_id'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 && $result->num_rows < 2) {
		
		$review = $result->fetch_assoc();
        
        $output = array(
			'type_name'	  =>	$review['type_name'],
		);
		echo json_encode($output);
	} 
    else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

}


