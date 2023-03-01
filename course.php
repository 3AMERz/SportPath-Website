<?php 
    
    if( !(isset($_GET['id']) && is_numeric($_GET['id'])) ){
        header('Location: courses.php');
        exit();
    }

    session_start();
    include "init.php";
    include $func . "connect.php";
    include $langs . "English.php";
    $title = "SportPath - Course";

    

    $course_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
    
    $sql = "SELECT * FROM courses WHERE course_id = $course_id";
    $result = $conn->query($sql);

    // if the get is one row.
    if ( $result->num_rows > 0 && 2 > $result->num_rows) {  
        $course_TB = $result->fetch_assoc();

    } else {
        echo "there's no courses in (courses) table, or there`s 2 courses they have same ID.";
        header('Location: courses.php');
        exit();
    }
    $title = "SportPath - " . $course_TB["course_name"];

    include $func . "getVideosFromPlaylist_YoutubeAPI.php";
    insertPlaylist_id($course_TB['API_id']);
    getVideoList();
    
// $conn->close();



function getDurationOfVideo($vid_id){
    // API config 
    global $API_Key;
    
    // Get Details of the video by YouTube Data API 
    $apiData = @file_get_contents('https://www.googleapis.com/youtube/v3/videos?id='. $vid_id .'&part=contentDetails&key=' . $API_Key); 

    if($apiData){ 
        $videoDetails = json_decode($apiData); 
    }else{ 
        echo 'Invalid API key or Video ID.'; 
    }

    $duration = $videoDetails->items[0]->contentDetails->duration;

    $interval = new DateInterval($duration);
    return $interval->format("%I:%S");
}



function readDescriptionText(){
    global $course_TB;
    echo file_get_contents("Files/Courses/". $course_TB["course_id"] . '-' . $course_TB["course_name"] ."/Description.txt");
}


function RequirementsText_toArray(){
    global $course_TB;
    $requirs_arr = explode("\n", file_get_contents("Files/Courses/". $course_TB["course_id"] . '-' . $course_TB["course_name"] ."/Requirements.txt"));

    return $requirs_arr;
}


function CheckUserNotReviews(){
    global $conn,$course_TB;

    $course_id = $course_TB["course_id"];
    $user_id = $_SESSION['UserID'];

    $sql = "SELECT review_id FROM reviews WHERE course_id ='$course_id' AND user_id ='$user_id'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {

		$row = $result->fetch_assoc();
        return FALSE;
	} 
    else {
        return TRUE;
	}
}



function createMyCoursesFile(){
    $path = '../../Files/MyCourses';
    if(!file_exists($path)){
        mkdir($path, 0777, true);
    }
}


function visiter(){
    if(isset($_SESSION['UserID'])){
        return false;
    }else{
        return true;
    }
}


function getVideosWatchedUser(){

    if(visiter()){
        return;
    }

    global $course_id;
    $UserID = $_SESSION['UserID'];
    $Username = $_SESSION['Username'];

    $MyCoursesFileName = $UserID . '-' . $Username;
    $pathFile = 'Files/MyCourses/' . $MyCoursesFileName . '.txt';

    createMyCoursesFile();

    if(!file_exists($pathFile)){
        return ;
    }
    else{
        $lines = file($pathFile, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);

        foreach ($lines as $line) {
            if(strstr($line,$course_id.'-')){
                $videosWatchedUser = explode('-', $line)[1];
                $videosWatchedUserInArr = explode(',', $videosWatchedUser);

                if($videosWatchedUserInArr[0] == ""){
                    return ;
                }else{
                    return $videosWatchedUserInArr;
                }
                
            }
        }

    }
}

$videosWatchedUser = getVideosWatchedUser();


//set videosNotWatched array.
$videosNotWatched = array();

if(!empty($videosWatchedUser)){
    $tempArr = array();
    for ($i = 1; $i <= count($videoList->items) ; $i++) {
        array_push($tempArr, $i);
    }

    if(($videosWatchedUser == $tempArr)){
        $videosNotWatched = $tempArr;
    }else{
        for ($i = 1; $i <= count($videoList->items) ; $i++) {
            if(!in_array($i,$videosWatchedUser)){
                array_push($videosNotWatched, $i);
            }
        }
    }
}else{
    for ($i = 1; $i <= count($videoList->items) ; $i++) {
        array_push($videosNotWatched, $i);
    }
}

$StartVideo = $videosNotWatched[0];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    include $tpl . "head.php";

    ?>
</head>

<body class="bg-light">


    <header>
        <?php
        include $tpl . "header.php";
        ?>
    </header>

    <center>


        <section>
            <div class="container mt-5">

                <div class="row d-flex " id="High-part">

                    <h1 class="text-center mb-2"> <?php echo $course_TB["course_name"]; ?> </h1>

                    <hr class="mb-2">

                    <div class="video_player col-12 col-md-8">

                        <iframe id="mainVideo" class="mainVideo" width="100%" height="100%"
                            src="https://www.youtube.com/embed/<?php echo $videoList->items[$StartVideo-1]->snippet->resourceId->videoId; ?>?enablejsapi=1"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen video-id="<?php echo $StartVideo; ?>"></iframe>

                    </div>

                    <div class="col-12 col-md-4 pr-0">

                        <div class="playlist-Box">
                            <div class="header">
                                <h5 class="m-0 p-0"><?php echo count($videoList->items); ?> Lessons</h5>
                            </div>

                            <ul class="playlist m-0 p-0" id="playlist">

                                <?php
                                
                                $len = 1;



                                foreach ($videoList->items as $vid) {

                                    $vid_id = $vid->snippet->resourceId->videoId;
                                                                        
                                    if(!empty($videosWatchedUser) && in_array($len, $videosWatchedUser)){
                                        if($len == $StartVideo){
                                            echo '<li video-id="'. $len .'" youtube-video-id="'. $vid_id .'" class="watched watching">';
                                        }else{
                                            echo '<li video-id="'. $len .'" youtube-video-id="'. $vid_id .'" class="watched">';
                                        }
                                        echo '<div class="row align-items-center">
                                        <i class="col-1 p-0 fa-solid fa-square-check pos-s"></i>';
                                    }
                                    else{
                                        if($len == $StartVideo){
                                            echo '<li video-id="'. $len .'" youtube-video-id="'. $vid_id .'" class="watching">';
                                        }else{
                                            echo '<li video-id="'. $len .'" youtube-video-id="'. $vid_id .'">';
                                        }
                                        echo '<div class="row align-items-center">
                                        <i class="col-1 p-0 fa-regular fa-square pos-s"></i>';
                                    }
                                        echo '<span class="col-9 p-0 ">'. $len .'. '. $vid->snippet->title .'</span>
                                        <span class="col-2 duration pr-0">'. getDurationOfVideo($vid_id) .'</span>
                                    </div>
                                </li>';
                                    
                                    $len++;
                                }
                                

                                ?>


                            </ul>

                        </div>
                    </div>
                </div>



                <div class="row mt-4" id="Low-part">

                    <div class="col-12 col-md-8 p-0 m-0">

                        <div class="description-box mb-5">
                            <h3 class="mb-1">Description</h3>
                            <hr class="m-0 mb-2">
                            <p> <?php readDescriptionText() ?> </p>
                        </div>


                        <div class="requirements-box mb-5">
                            <h3 class="mb-1">Requirements</h3>
                            <hr class="m-0 mb-2">

                            <div class="row">
                                <div class="col-12 col-md-6">

                                    <?php 

                                $requirs_arr = RequirementsText_toArray();
                                

                                for($i=0; $i<count($requirs_arr); $i++){
                                        //if $i = EVEN number, or $i = 0.
                                        if(!($i%2 == 1) or $i == 0){
                                            echo '<li>'. $requirs_arr[$i] .'</li>';
                                        }
                                }
                                echo '</div>';


                                echo '<div class="col-12 col-md-6">';

                                for($i=0; $i<count($requirs_arr); $i++){
                                        //if $i = Odd number.
                                        if($i%2 == 1){
                                            echo '<li>'. $requirs_arr[$i] .'</li>';
                                        }
                                }
                                
                                ?>

                                </div>

                            </div>
                        </div>


                        <div class="reviews-box mb-5">
                            <div class="head d-flex justify-content-between">
                                <h3 class="mb-1">Reviews</h3>
                                <div class="d-flex align-items-end pb-1">
                                    <small id="numOfReviews" class="text-muted">(0 reviews)</small>
                                </div>
                            </div>
                            <hr class="m-0 mb-4">


                            <div id="reviews-list" class="reviews-list">


                            </div>


                        </div>
                    </div>

                    <div class="col-12 col-md-4 pr-0 m-0">

                        <div class="card">
                            <div class="card-header">User reviews</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="text-center">
                                        <h1 class="text-warning mt-4 mb-2">
                                            <b><span id="average_rating">0.0</span> / 5</b>
                                        </h1>
                                        <div id="rev-stars-box" class="mb-3">
                                            <i class="fas fa-star star-light mr-1 main_star"></i>
                                            <i class="fas fa-star star-light mr-1 main_star"></i>
                                            <i class="fas fa-star star-light mr-1 main_star"></i>
                                            <i class="fas fa-star star-light mr-1 main_star"></i>
                                            <i class="fas fa-star star-light mr-1 main_star"></i>
                                        </div>
                                        <h3><span id="total_review">0</span> Reviews</h3>
                                    </div>
                                    <div class="pb-3">
                                        <p>
                                        <div class="progress-label-left"><b>5</b> <i
                                                class="fas fa-star text-warning"></i>
                                        </div>

                                        <div class="progress-label-right">(<span id="total_five_star_review">0</span>)
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" id="five_star_progress"
                                                role="progressbar" aria-valuemax="100" aria-valuemin="0"
                                                aria-valuenow="0"></div>
                                        </div>
                                        </p>
                                        <p>
                                        <div class="progress-label-left"><b>4</b> <i
                                                class="fas fa-star text-warning"></i>
                                        </div>

                                        <div class="progress-label-right">(<span id="total_four_star_review">0</span>)
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" id="four_star_progress"
                                                role="progressbar" aria-valuemax="100" aria-valuemin="0"
                                                aria-valuenow="0"></div>
                                        </div>
                                        </p>
                                        <p>
                                        <div class="progress-label-left"><b>3</b> <i
                                                class="fas fa-star text-warning"></i>
                                        </div>

                                        <div class="progress-label-right">(<span id="total_three_star_review">0</span>)
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" id="three_star_progress"
                                                role="progressbar" aria-valuemax="100" aria-valuemin="0"
                                                aria-valuenow="0"></div>
                                        </div>
                                        </p>
                                        <p>
                                        <div class="progress-label-left"><b>2</b> <i
                                                class="fas fa-star text-warning"></i>
                                        </div>

                                        <div class="progress-label-right">(<span id="total_two_star_review">0</span>)
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" id="two_star_progress"
                                                role="progressbar" aria-valuemax="100" aria-valuemin="0"
                                                aria-valuenow="0"></div>
                                        </div>
                                        </p>
                                        <p>
                                        <div class="progress-label-left"><b>1</b> <i
                                                class="fas fa-star text-warning"></i>
                                        </div>

                                        <div class="progress-label-right">(<span id="total_one_star_review">0</span>)
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" id="one_star_progress"
                                                role="progressbar" aria-valuemax="100" aria-valuemin="0"
                                                aria-valuenow="0"></div>
                                        </div>
                                        </p>
                                    </div>

                                    <?php
                                    if(isset($_SESSION['UserID']) && CheckUserNotReviews() == TRUE){
                                        echo '<div class="text-center" id="Enter-rev-box">
                                        <hr>
                                        <h3 class="mt-2 mb-4">Enter Your Review</h3>
                                        <h4 class="text-center mt-2 mb-4" id="submit-stars-box">
                                            <i class="fas fa-star star-light submit_star mr-1" id="submit_star_1"
                                                data-rating="1"></i>
                                            <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2"
                                                data-rating="2"></i>
                                            <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3"
                                                data-rating="3"></i>
                                            <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4"
                                                data-rating="4"></i>
                                            <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5"
                                                data-rating="5"></i>
                                        </h4>

                                        <textarea id="user_review" class="form-control mb-3"
                                            placeholder="Write Your Review"></textarea>

                                        <button id="add_review" class="btn btn-primary" type="button">Submit</button>
                                    </div>';
                                };
                                    ?>

                                </div>
                            </div>
                        </div>

                    </div>


                </div>


            </div>





        </section>


        <div class="mt-5" id="review_content"></div>


        <center>



            <footer>
                <!-- inclodes footer -->
                <?php
                include $tpl . "footer.php";
                ?>
            </footer>



            <!-- inclodes Js libraries -->
            <?php
                include $tpl . "libraries.php";
            ?>


            <script src="https://www.youtube.com/iframe_api"></script>

            <script>
            var VideosWatchedUser <?php if($videosWatchedUser != NULL){echo '=' . json_encode($videosWatchedUser);} ?>;


            var player;

            function onYouTubeIframeAPIReady() {
                player = new YT.Player('mainVideo', {
                    events: {
                        'onReady': onPlayerReady,
                        'onStateChange': onPlayerStateChange
                    }
                });
            }

            function onPlayerReady(event) {
                // console.log('Video is ready to play');
            }

            function onPlayerStateChange(event) {
                if (event.data == 0) {
                    if (!visiter()) {
                        var videoId = $('#mainVideo').attr('video-id');
                        if (!inArray(videoId, VideosWatchedUser)) {
                            videoWatched(videoId);

                            if (isNull(VideosWatchedUser)) {
                                VideosWatchedUser = [];
                            }
                            VideosWatchedUser.push(videoId);
                        }
                    }
                }
            }


            function videoWatched(video_id) {

                var course_id = <?php echo $course_id; ?>;
                var user_id <?php if(isset($_SESSION['UserID'])) echo '=' . $_SESSION['UserID']; ?>;
                var username <?php if(isset($_SESSION['Username'])) echo '= "' . $_SESSION['Username'] . '"' ;?>;

                $.ajax({
                    url: "<?php echo $func ;?>addVideoWacthed.php",
                    method: "POST",
                    data: {
                        action: 'addVideoWacthed',
                        video_id: video_id,
                        course_id: course_id,
                        user_id: user_id,
                        username: username
                    },
                    success: function(data) {
                        var course_li = $('#playlist li.watching');
                        course_li.addClass("watched");

                        var icon = course_li.find('.fa-square');
                        icon.removeClass("fa-square");
                        icon.removeClass("fa-regular");
                        icon.addClass("fa-square-check");
                        icon.addClass("fa-solid");
                    }
                })
            }





            function visiter() {
                var visiter = <?php if(isset($_SESSION['UserID'])){echo 'false';}
                else{echo 'true';}?>;

                return visiter;
            }

            function isNull(el) {
                if (el == null) {
                    return true;
                } else {
                    return false;
                }
            }

            function inArray(val, array) {
                if (jQuery.inArray(val, array) !== -1) {
                    return true;
                } else {
                    return false;
                }
            }




            $(document).ready(function() {

                $('#playlist li').click(function() {
                    var videoId = $(this).attr("youtube-video-id");
                    player.cueVideoById({
                        'videoId': videoId
                    })

                    $('#mainVideo').attr("video-id", $(this).attr("video-id"));

                    $('#playlist li.watching').removeClass("watching");
                    $(this).addClass("watching");

                });


                var rating_data = 0;

                $('.submit_star').on('mouseenter', function() {

                    var rating = $(this).data('rating');
                    reset_background();

                    for (var count = 1; count <= rating; count++) {
                        $('#submit_star_' + count).addClass('text-warning');
                    }
                });


                $('#rev-stars-box').on('mouseleave', function() {
                    reset_background();

                    for (var count = 1; count <= rating_data; count++) {
                        $('#submit_star_' + count).removeClass('star-light');
                        $('#submit_star_' + count).addClass('text-warning');
                    }

                });


                $('.submit_star').click(function() {

                    rating_data = $(this).data('rating');

                });



                function reset_background() {
                    for (var count = 1; count <= 5; count++) {
                        $('#submit_star_' + count).addClass('star-light');
                        $('#submit_star_' + count).removeClass('text-warning');
                    }
                }










                $('#add_review').click(function() {

                    var user_id <?php if(isset($_SESSION['UserID'])){
                        echo '=' .$_SESSION['UserID'];
                    }
                    ?>;
                    var user_review = $('#user_review').val();
                    var course_id = <?php echo $course_TB["course_id"];?>;


                    if (rating_data < 1 || rating_data > 5) {
                        alert("Please Choose Your Rating");
                    } else if (user_id == '' || user_review == '') {
                        alert("Please Fill Review Field");
                    } else {
                        $.ajax({
                            url: "<?php echo $func ;?>submit_rating.php",
                            method: "POST",
                            data: {
                                rating_data: rating_data,
                                user_id: user_id,
                                course_id: course_id,
                                user_review: user_review
                            },
                            success: function(data) {

                                $("#Enter-rev-box").slideUp();
                                $("#Enter-rev-box").html('');

                                load_rating_data();

                                alert(data);
                            }
                        })
                    }
                });





                load_rating_data();

                function load_rating_data() {

                    var course_id = <?php echo $course_TB["course_id"];?>;

                    $.ajax({
                        url: "<?php echo $func ;?>submit_rating.php",
                        method: "POST",
                        data: {
                            action: 'load_data',
                            course_id: course_id
                        },
                        dataType: "JSON",
                        success: function(data) {

                            if (!data == 0) {


                                $('#average_rating').text(data.average_rating);
                                $('#total_review').text(data.total_review);

                                var count_star = 0;

                                $('#rev-stars-box .main_star').each(function() {
                                    count_star++;
                                    if (Math.round(data.average_rating) >= count_star) {
                                        $(this).addClass('text-warning');
                                        $(this).addClass('star-light');
                                    }
                                });

                                $('#total_five_star_review').text(data.five_star_review);
                                $('#total_four_star_review').text(data.four_star_review);
                                $('#total_three_star_review').text(data.three_star_review);
                                $('#total_two_star_review').text(data.two_star_review);
                                $('#total_one_star_review').text(data.one_star_review);

                                $('#five_star_progress').css('width', (data.five_star_review /
                                    data
                                    .total_review) * 100 + '%');
                                $('#four_star_progress').css('width', (data.four_star_review /
                                    data
                                    .total_review) * 100 + '%');
                                $('#three_star_progress').css('width', (data.three_star_review /
                                    data.total_review) * 100 + '%');
                                $('#two_star_progress').css('width', (data.two_star_review /
                                    data
                                    .total_review) * 100 + '%');
                                $('#one_star_progress').css('width', (data.one_star_review /
                                    data
                                    .total_review) * 100 + '%');


                                $('#numOfReviews').text("(" + data.total_review + " Reviews)");



                                if (data.review_data.length > 0) {
                                    var html = '';

                                    for (var count = 0; count < data.review_data
                                        .length; count++) {

                                        html += `<div id="review-${count}">
                                        <div class="head d-flex ">
                                            <div class="acc-icon">
                                                <i class="fa-solid fa-user fa-2x color-light"></i>
                                            </div>
                                            <div class="col acc-info d-flex flex-column">
                                                <h5 class="m-0"><b>${data.review_data[count].user_name}</b></h5>
                                                <div id="rating">`;


                                        for (var star = 1; star <= 5; star++) {
                                            var class_name = '';

                                            if (data.review_data[count].rating >= star) {
                                                class_name = 'text-warning';
                                            } else {
                                                class_name = 'star-light';
                                            }

                                            html +=
                                                `<i class="fas fa-star ${class_name} mr-1 main_star"></i>`;
                                        }


                                        html += `      </div>
                                            </div>
                                        </div>

                                        <p class="review-content m-0 pb-3">${data.review_data[count].user_review}</p>

                                    </div>
                                    
                                    <div class="d-flex justify-content-end ">
                                        <small id="numOfReviews"class="text-muted">${data.review_data[count].datetime}</small>
                                    </div>
                                    `;

                                        if (!(count == (data.review_data.length - 1))) {
                                            html += `<hr>`;
                                        }

                                    }

                                    $('#reviews-list').html(html);

                                }
                            }
                        }
                    })
                }



            });
            </script>








</body>

</html>