<?php


if(isset($_POST['Channel_ID'])) {

include '../connect.php';

class PlayList {
    public $name;
    public $playlist_ID;
  }

function findObject_PL_Id($val,$PlayLists_API){
    
    foreach($PlayLists_API as $row) {
        if($val == $row->playlist_ID){
            return TRUE;
        }
    }
    return FALSE;
}


function PLs_Not_in_Channel($PlayLists_TB, $PlayLists_API){

    $PLs = array();
    
    foreach($PlayLists_TB as $row_PLs){

        if (findObject_PL_Id($row_PLs['playlist_id'],$PlayLists_API) == FALSE){
            array_push($PLs,$row_PLs['id']);
        }
        
    }

    return $PLs ;
}


function Delete_PLs_From_Database($PLsNotIn){
    global $conn;
    
    foreach($PLsNotIn as $id){

        $sql = "DELETE FROM courses_api WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
        } else {
          echo "Error deleting record: " . $conn->error;
        }

    }
}


function deleteFile($path, $file){
    if (unlink($path . '/' .$file)) {
        // echo ($file . " has been deleted");
    }
    else {
        echo ($file . " cannot be deleted due to an error");
    }
}


function DeleteCourseFilder($CourseName){
    $path = "../../../Files/Courses/";

    if(file_exists($path . $CourseName)){
        deleteFile(($path . $CourseName), "Description.txt"); //($path, $file)
        deleteFile(($path . $CourseName), "Requirements.txt"); //($path, $file)
        deleteFile(($path . $CourseName), "ImageCourse.png"); //($path, $file)
        rmdir($path . $CourseName);
    }
    else{
        echo "Error: " . $CourseName . "dirocory is not found in path: ". $path ."\n";
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



function getCoursesHasAPI_ID($API_id){
    global $conn;

    $CoursesMustDel = array();

    $sql = "SELECT course_id, course_name FROM courses WHERE API_id ='$API_id'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {

		while($row = $result->fetch_assoc()) {
            array_push($CoursesMustDel,array(
                'course_id'   => $row['course_id'],
                'course_name' => $row['course_name']
            ));
        }
	}
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
	}

    return $CoursesMustDel;
}




function PLs_is_into_arr($val, $PlayLists_TB){

    foreach($PlayLists_TB as $row){
        if($val == $row['playlist_id']){
            return TRUE;
        }
    }
    return FALSE;
}


function PLs_new($PlayLists_TB, $PlayLists_API){

    $PLs_new = array();
    
    foreach($PlayLists_API as $row){
    
        if(PLs_is_into_arr($row->playlist_ID, $PlayLists_TB) == FALSE){
            array_push($PLs_new, $row);
        }
    }

    return $PLs_new ;
}



function insetrNewPLs($PLs_new){

    global $conn;
    
    foreach($PLs_new as $row){

        $name = $row->name;
        $playlist_ID = $row->playlist_ID;
        $Datetime = date('Y/m/d H:i:s', time());

        //insert into (courses_api) table.
        $insretCourse_API_TB = "INSERT INTO courses_api (playlist_name, playlist_id, Datetime) VALUES ('$name', '$playlist_ID', '$Datetime')";

        if ($conn->query($insretCourse_API_TB) === TRUE) {} 
        else {
        echo "Error: " . $insretCourse_API_TB . "<br>" . $conn->error;
        }
        
    }
}


function getDirContents($dir, &$results = array()) {
    $files = scandir($dir);

    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            $results[] = $path;
        } else if ($value != "." && $value != "..") {
            getDirContents($path, $results);
            $results[] = $path;
        }
    }

    return $results;
}

function deleteLineInFile($file,$string){
    $array = (file($file));
    $lines;

    for($line=0; $line < count($array); $line++){
        if(strstr($array[$line],($string))){ continue; }
        $lines[$line] = $array[$line];
    }

    $content;
    foreach($lines as $line){
        $content .= $line;
    }
    
    file_put_contents($file, $content);
}

function createMyCoursesFile(){
    $path = '../../Files/MyCourses';
    if(!file_exists($path)){
        mkdir($path, 0777, true);
    }
}
  



$API_Key    = 'AIzaSyDKF0vbU8e34vTs5IxDdm90U6eXPzTyo4k'; 

$Channel_ID = $_POST['Channel_ID'];
file_put_contents("../../../Files/Channel-ID.txt", $Channel_ID);

$Max_Results = 50; 
 
// Get videos from Playlist by YouTube Data API 
$apiData = @file_get_contents('https://youtube.googleapis.com/youtube/v3/playlists?part=snippet&channelId=' . $Channel_ID . '&maxResults=' . $Max_Results . '&key=' . $API_Key); 

if($apiData){ 

    $PlayLists = json_decode($apiData); 





    $PlayLists_API = array();
    
    foreach($PlayLists->items as $id){
        $PL = new PlayList();
        $PL->name = $id->snippet->title;
        $PL->playlist_ID = $id->id;

        array_push($PlayLists_API,$PL);
    }








    $PlayLists_TB = array();

    $get_cousesAPI_TB = "SELECT * FROM courses_api";
    $res_cousesAPI_TB = $conn->query($get_cousesAPI_TB);
    
    // if the result is one row.
    if ( $res_cousesAPI_TB->num_rows > 0) {  
            
    // output data of each row.
    while($row = $res_cousesAPI_TB->fetch_assoc()) {
        array_push($PlayLists_TB,$row);
    }

    } else {
        echo "the (courses_api) table is empty.";
    }    






    $PLsNotIn = PLs_Not_in_Channel($PlayLists_TB, $PlayLists_API);
    if(!empty($PLsNotIn)){

        foreach($PLsNotIn as $id){
            $Courses = getCoursesHasAPI_ID($id);

            if(!empty($Courses)){
                foreach($Courses as $course){
                    $CourseFileName = $course['course_id'] . '-' . $course['course_name'];
                    DeleteCourseFilder($CourseFileName);


                    $pathDir = '../../../Files/MyCourses';
                    createMyCoursesFile();
                    $MyCoursesContent = getDirContents($pathDir);
                
                    if(!file_exists($pathDir)){
                        echo "Error: (MyCourses) Directory is not founded.";
                    }
                    else{
                        foreach($MyCoursesContent as $textFolder){
                            deleteLineInFile($textFolder, ($course['course_id']."-"));
                            if(empty(trim(file_get_contents($textFolder)))){
                                unlink($textFolder);
                            }

                        }
                    }
                }
            }
        }

        Delete_PLs_From_Database($PLsNotIn);

        echo "Some courses have been deleted from the database.\n";
    }




    $PLs_new = PLs_new($PlayLists_TB, $PlayLists_API);
    if(!empty($PLs_new)){
        insetrNewPLs($PLs_new);
        echo "Some courses have been added to the database.\n";
    }

    
    
    if(empty($PLsNotIn) && empty($PLs_new)){
        echo "Nothing has changed.";
    }

    



    // $conn->close();



}else{ 
    echo 'Invalid API key or Playlist ID.'; 
}




}









?>