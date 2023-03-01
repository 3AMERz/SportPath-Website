<?php

function createMyCoursesFile(){
    $path = '../../Files/MyCourses';
    if(!file_exists($path)){
        mkdir($path, 0777, true);
    }
}

function deleteLineInFile($file,$string){
	$i=0;$array=array();
	
	$read = fopen($file, "r") or die("can't open the file");
	while(!feof($read)) {
		$array[$i] = fgets($read);	
		++$i;
	}
	fclose($read);
	
	$write = fopen($file, "w") or die("can't open the file");
	foreach($array as $a) {
		if(!strstr($a,$string)){
            fwrite($write,$a);
        } 
	}
	fclose($write);
}


if( isset($_POST["action"]) && ($_POST["action"] =='removeCourse') ){

    $course_id = $_POST['course_id'];
    $user_id = $_POST['user_id'];
    $user_username = $_POST['user_username'];

    $MyCoursesFileName = $user_id . '-' . $user_username;
    $pathFile = '../../Files/MyCourses/' . $MyCoursesFileName . '.txt';

    createMyCoursesFile();

    if(!file_exists($pathFile)){
        echo "Error: (".$MyCoursesFileName.")File text in not founded in path: (Files/MyCourses/)";
    }
    else{
        deleteLineInFile($pathFile, ($course_id."-"));
        if(empty(trim(file_get_contents($pathFile)))){
            unlink($pathFile);
        }
    }


}