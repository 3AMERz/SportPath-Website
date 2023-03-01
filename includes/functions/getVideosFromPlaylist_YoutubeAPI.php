<?php

$Playlist_ID;
$videoList;




function insertPlaylist_id($API_id){
    global $conn;

    $con_cousesAPI_TB = "SELECT playlist_id FROM courses_api WHERE id = $API_id";
    $res_cousesAPI_TB = $conn->query($con_cousesAPI_TB);

    // if the result is one row.
    if ( $res_cousesAPI_TB->num_rows > 0 && 2 > $res_cousesAPI_TB->num_rows) {  
        
        $courseAPI_TB = $res_cousesAPI_TB->fetch_assoc();
        $GLOBALS['Playlist_ID'] = ($courseAPI_TB["playlist_id"]);

    } else {
        echo "the (courses_api) table is empty, or there`s 2 rows they have same ID.";
    }
    
}




function getVideoList(){
    global $Playlist_ID, $API_Key;

    $Max_Results = 50; 
    
    // Get videos from Playlist by YouTube Data API 
    $apiData = @file_get_contents('https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=' . $Playlist_ID . '&maxResults=' . $Max_Results . '&key=' . $API_Key); 

    if($apiData){ 
        $GLOBALS['videoList'] = json_decode($apiData);
    }
    else{ 
        echo 'Invalid API key or Playlist ID.'.$Playlist_ID; 
    }
}



?>