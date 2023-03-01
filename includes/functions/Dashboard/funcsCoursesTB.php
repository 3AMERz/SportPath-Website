<?php 

include '../connect.php';


function imageSeving($path) {


    if($_FILES['file']['name'] != ''){


        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION));
        $target_dir = $path;
        $target_file = $target_dir . "ImageCourse.png";
        
    
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
          $check = getimagesize($_FILES["file"]["tmp_name"]);
          if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".\n";
            $uploadOk = 1;
          } else {
            echo "File is not an image.\n";
            $uploadOk = 0;
          }
        }
        
        
        // Check file size
        if ($_FILES["file"]["size"] > 500000) {
          echo "Sorry, your file is too large.\n";
          $uploadOk = 0;
        }
        
    
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
          echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.\n";
          $uploadOk = 0;
        }
    
        
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
          echo "Sorry, your file was not uploaded.\n";
        // if everything is ok, try to upload file
        } else {
          if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.\n";
            echo '<img src="'.$target_file.'" height="100" width="100" />';
            
          } else {
            echo "Sorry, there was an error uploading your file.\n";
          }
        }

    }

}




function createCoursesFolder($path , $nameDir){
    mkdir($path . $nameDir, 0777, true);
}



function deleteCoursesFolder($path , $nameDir){
    rmdir($path . $nameDir);
}



function deleteFile($path, $file){
    if (unlink($path . "/" . $file)) {
        // echo ($file . " has been deleted");
    }
    else {
        echo ($file . " cannot be deleted due to an error");
    }
}



function createText($path,$name,$content){
    if(file_exists($path)){
        file_put_contents( ($path . '/' . $name . '.txt') , $content);
    }
    else{
        echo "Error: Path not found to create a text file.";
    }
}



function getCourseName($course_id){
    global $conn;

    $sql = "SELECT course_name FROM courses WHERE course_id ='$course_id'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 && $result->num_rows < 2) {
		
		$row = $result->fetch_assoc();
        
        return $row['course_name'];
	} 
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
	}
}






if(isset($_POST['arrayDel'])){
    
    $arrayDel = $_POST['arrayDel'];
    foreach($arrayDel as $id){
    
        $path = "../../../Files/Courses/";
        $directory = $id . '-' . getCourseName($id) ;

        if(file_exists($path . $directory)){
            deleteFile(($path . $directory), "Description.txt"); //($path, $file)
            deleteFile(($path . $directory), "Requirements.txt"); //($path, $file)
            deleteFile(($path . $directory), "ImageCourse.png"); //($path, $file)
            deleteCoursesFolder($path , $directory); //($path , $nameDir)
        }
        else{
            echo "Error: " . $directory . "dirocory is not found in path: ". $path ."\n";
        }



        $sql = "DELETE FROM courses WHERE course_id = '$id'";

        if ($conn->query($sql) === TRUE) {
            echo "Successful deletion.";

        } else {
            echo "Error deleting record: " . $conn->error . "\n";
        }
    
    }




}


if(isset($_POST["action"]) && ($_POST["action"] =='insertCourse') ){

    $API_ID = $_POST["API_ID"];
    $CourseName = $_POST["CourseName"];
    $Type = $_POST["Type"];
    $GroupOfAge = $_POST["GroupOfAge"];
    $Description = $_POST["Description"];
    $Requirements= $_POST["Requirements"];
    $Datetime = date('Y/m/d H:i:s', time());

    $message; 
    $inserted_id;

    $sql = "INSERT INTO courses (API_id, type_id, course_name, group_age, time) VALUES 
    ('$API_ID', '$Type', '$CourseName', '$GroupOfAge', '$Datetime')";
	
    if ($conn->query($sql) === TRUE) {
        $inserted_id = $conn->insert_id;
        $message = "Successful addition.";
        


        $path = '../../../Files/Courses/';
        $nameDir = $inserted_id . '-' . $CourseName;
        if(!file_exists($path . $nameDir)){
            createCoursesFolder($path , $nameDir);
        }
        else{
            echo "Error: Cant create a new directory.";
        }

        createText(($path.$nameDir),"Description",$Description); // (path,name,content)
        createText(($path.$nameDir),"Requirements",$Requirements); // (path,name,content)

        $output = array(
            'message'	=>	$message,
            'inserted_id'	=>	$inserted_id
        );

        echo json_encode($output);
        
    }else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

}


if(isset($_FILES['file']['name'])){

    $path = '../../../Files/Courses/' . $_POST['course_id'] . '-' . $_POST['course_name'] . '/';
    imageSeving($path);


}



if(isset($_POST["action"]) && ($_POST["action"] =='updateCourse') ){

    $course_id = $_POST['course_id'];
    $API_id = $_POST['API_ID'];
    $course_name = $_POST['CourseName'];
    $type_id = $_POST['Type'];
    $group_age = $_POST['GroupOfAge'];
    $Description = $_POST['Description'];
    $Requirements = $_POST['Requirements'];

    $path = "../../../Files/Courses/";
    $old_nameDir = $course_id . '-' . getCourseName($course_id);
    $new_nameDir = $course_id . '-' . $course_name;

    $sql = "UPDATE courses SET API_id ='$API_id', type_id='$type_id', course_name='$course_name', 
    group_age='$group_age' WHERE course_id = '$course_id'";
	
    if ($conn->query($sql) === TRUE) {

        global $old_nameDir;
        global $new_nameDir;

        rename( ($path . $old_nameDir), ($path . $new_nameDir)) ;

        file_put_contents( $path . $new_nameDir . '/Description.txt' , $Description);
        file_put_contents( $path . $new_nameDir . '/Requirements.txt' , $Requirements);

        echo "Successful Update.";
    } 
    else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

}





if(isset($_POST["action"]) && ($_POST["action"] =='getCourse') ){

    $course_id = $_POST['course_id'];
    
    $sql = "SELECT * FROM courses WHERE course_id ='$course_id'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 && $result->num_rows < 2) {
		
		$course = $result->fetch_assoc();

        $path = "../../../Files/Courses/";
        $directory = $course_id . '-' . $course['course_name'];
        
        $output = array(
			'API_id'	  =>	$course['API_id'],
			'type_id'	  =>	$course['type_id'],
			'course_name' =>    $course['course_name'],
			'group_age'   =>	$course['group_age'],
            'Description'   =>	file_get_contents($path . $directory . '/Description.txt'),
            'Requirements'   =>	file_get_contents($path . $directory . '/Requirements.txt'),
            'ImageCourse'   =>	"../Files/Courses/" . $directory . "/ImageCourse.png"
            
		);
	  
		echo json_encode($output);
	} 
    else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

}



if(isset($_POST["action"]) && ($_POST["action"] =='getPlaylistName&ID') ){

    $API_id = $_POST['API_id'];

    $sql = "SELECT playlist_name, playlist_id FROM courses_api WHERE id ='$API_id'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 && $result->num_rows < 2) {
		
		$row = $result->fetch_assoc();
        
        $output = array(
			'playlistName'	=>	$row['playlist_name'],
			'playlistId'	=>	$row['playlist_id'],
		);
	  
		echo json_encode($output);
	} 
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
	}

}

