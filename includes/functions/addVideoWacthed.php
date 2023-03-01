<?php

function createMyCoursesFile(){
    $path = '../../Files/MyCourses';
    if(!file_exists($path)){
        mkdir($path, 0777, true);
    }
}

function comma($line){
    $videosWatched = explode('-', $line)[1];
    if(empty($videosWatched)){
        return;
    }else{
        return ',';
    }
}


function addVideoWathcedInTextFile($file, $course_id, $video_id){

    $lines = (file($file));

    for($line=0; $line < count($lines); $line++){
        if(strstr($lines[$line],($course_id))){
            $lines[$line] = preg_replace('/\s+/', '', $lines[$line]) . comma($lines[$line]) . $video_id;
            break;
        }
    }

    $content;
    foreach($lines as $line){
        $content .= preg_replace('/\s+/', '', $line);
        if($line == $lines[count($lines)-1]){ continue; }
        $content .= "\r\n";
    }
    
    file_put_contents($file, $content);
}


if( isset($_POST["action"]) && ($_POST["action"] =='addVideoWacthed') ){

    $video_id = $_POST['video_id'];
    $course_id = $_POST['course_id'];
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];

    $MyCoursesFileName = $user_id . '-' . $username;
    $pathFile = '../../Files/MyCourses/' . $MyCoursesFileName . '.txt';

    createMyCoursesFile();

    if(file_exists($pathFile)){
        addVideoWathcedInTextFile($pathFile, ($course_id."-"), $video_id);
    }
    else{
        // echo "Error: (".$MyCoursesFileName.")File text in not founded in path: (Files/MyCourses/)";
    }


}