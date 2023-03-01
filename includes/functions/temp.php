<?php

// function createCoursesFolder(){
//     mkdir("Files/Courses", 0777, true);
// }



// if(!file_exists("Files/Courses")){
//     createCoursesFolder();
// }
// else{
//     // rmdir("Files/Courses");
//     // rmdir("Files");
// }

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

var_dump(getDirContents('../../Files/MyCourses'));
$arr = getDirContents('../../Files/MyCourses');
// echo $arr[0];

// deleteLineInFile($arr[0],'15-');

// var_dump(file($arr[0]));



