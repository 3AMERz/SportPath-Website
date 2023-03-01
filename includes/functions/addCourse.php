<?php

function createMyCoursesFile(){
    $path = '../../Files/MyCourses';
    if(!file_exists($path)){
        mkdir($path, 0777, true);
    }
}




if( isset($_POST["action"]) && ($_POST["action"] =='addCourse') ){

    $course_id = $_POST['course_id'];
    $user_id = $_POST['user_id'];
    $user_username = $_POST['user_username'];

    $MyCoursesFileName = $user_id . '-' . $user_username;
    $pathFile = '../../Files/MyCourses/' . $MyCoursesFileName . '.txt';

    createMyCoursesFile();

    if(!file_exists($pathFile)){
        file_put_contents($pathFile, ($course_id . '-'));
    }
    else{
        $lines = (file($pathFile));

        array_push($lines,($course_id . '-'));
    
        $content;
        foreach($lines as $line){
            $content .= preg_replace('/\s+/', '', $line);
            if($line == $lines[count($lines)-1]){ continue; }
            $content .= "\r\n";
        }
        
        file_put_contents($pathFile, $content);
    }



}