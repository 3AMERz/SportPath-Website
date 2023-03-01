<?php 

session_start();

if( !(isset($_SESSION['UserID']) )){
    header('Location: index.php');
    exit();
}


include "init.php";
include $func . "connect.php";
$title = "SportPath - My Courses";




function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}





$sql = "SELECT * FROM courses";
$courses_TB = $conn->query($sql);



include $func . "getVideosFromPlaylist_YoutubeAPI.php";
function getNumOfVideos($API_id){
    global $videoList;

    insertPlaylist_id($API_id);
    getVideoList();

    return count($videoList->items);
}



function readDescriptionText($courseName){
    return file_get_contents("Files/Courses/". $courseName ."/Description.txt");
}

function getPath_CourseImage($courseName){
    return "Files/Courses/". $courseName ."/ImageCourse.png" ;
}

function formatingOfTime($datatime){
    return time_elapsed_string($datatime);
}


function getCourseType($type_id){
    global $conn;

    $sql = "SELECT type_name FROM types WHERE type_id ='$type_id'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {

		$row = $result->fetch_assoc();
        return $row['type_name'];
	} 
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
	}
}


function getMyCoursesUser(){

    if(!isset($_SESSION['UserID'])){
        return NULL;
    }

    $UserID = $_SESSION['UserID'];
    $Username = $_SESSION['Username'];

    $MyCoursesFileName = $UserID . '-' . $Username;
    $pathFile = 'Files/MyCourses/' . $MyCoursesFileName . '.txt';

    if(!file_exists($pathFile)){
        return NULL;
    }
    else{
        $MyCoursesUser = array();
        $lines = file($pathFile, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);

        foreach($lines as $line) {
            array_push($MyCoursesUser, explode('-', $line)[0]);
        }

        return $MyCoursesUser;
    }
}

$MyCoursesUser = getMyCoursesUser();




function getAverageRating($course_id){
    global $conn;

	$sql = "SELECT stars FROM reviews WHERE course_id ='$course_id' ";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {


		$average_rating = 0;
		$total_review = 0;
		$five_star_review = 0;
		$four_star_review = 0;
		$three_star_review = 0;
		$two_star_review = 0;
		$one_star_review = 0;
		$total_user_rating = 0;


	  	while($row = $result->fetch_assoc()) {

			if($row["stars"] == '5'){
				$five_star_review++;
			}
	
			if($row["stars"] == '4'){
				$four_star_review++;
			}
	
			if($row["stars"] == '3'){
				$three_star_review++;
			}
	
			if($row["stars"] == '2'){
				$two_star_review++;
			}
	
			if($row["stars"] == '1'){
				$one_star_review++;
			}
	
			$total_review++;
	
			$total_user_rating = $total_user_rating + $row["stars"];
	  	}

        $average = number_format( ($average_rating = $total_user_rating / $total_review) , 1);
        $average_arr = explode(".",$average);

        if($average_arr[1] == 0){
            return $average_arr[0];
        }
        else{
            return $average_arr[0] . "." . $average_arr[1];
        }

    }
    else{
        return 0;
    }
}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include $langs . "English.php";

    include $tpl . "head.php";
    ?>
</head>


<body>

    <header>
        <?php
        include $tpl . "header.php";
        ?>
    </header>






    <center>


        <div class="courses-box bg-light">
            <div class="container py-4">

                <h1 class="text-center border-bottom pb-3 mb-4">My Courses</h1>

                <div class="search-box input-group group w-75 m-auto mb-5">
                    <input id="search-input" type="text">
                    <label class="form-label" for="search-input">Search</label>
                </div>

                <div id="course-col" class="col overflow-y-auto pt-3 px-3" >



                    <?php 

                // if the rows are not empty.
                if ( $courses_TB->num_rows > 0) {  

                    
                    while($row = $courses_TB->fetch_assoc()) {

                        if($MyCoursesUser == NULL){
                            echo "<p>No course has been added.</p>";
                            break;
                        }
                        else if(!in_array($row['course_id'], $MyCoursesUser)){
                            continue;
                        }

                        echo '<div class="card course-box m-auto course-card" course_id="'. $row['course_id'] .'">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="' . getPath_CourseImage($row['course_id']. '-' .$row['course_name']) . '" class="img-fluid course-img w-100" alt="course_img">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body row align-items-end h-100">
                                    <div class="row">

                                        <h5 class="card-title">'.$row['course_name'].'</h5>
                                        <p class="card-text">'. readDescriptionText($row['course_id']. '-' .$row['course_name']) .'</p>


                                        <div class="course-info row justify-content-between">
                                            <div class="col-md-3 ">
                                                <p>'. getNumOfVideos($row['API_id']) .' Videos</p>
                                            </div>
                                            <div class="col-md-4">
                                                <p>Group of age: '.$row['group_age'].'+</p>
                                            </div>
                                            <div class="col-md-4">
                                                <p>Rating rate: ' . getAverageRating($row['course_id']) . ' of 5</p>
                                            </div>
                                            <div class="col-md-4">
                                                <p>Type: ' . getCourseType($row['type_id']) . '</p>
                                            </div>                                            
                                        </div>
                                    </div>

                                        <div class="d-flex row justify-content-between align-items-center">
                                            <div class="col-md-6 col-sm-12  m-2 m-md-0">
                                                <p class="card-text"><small class="text-muted">Last updated '. formatingOfTime($row['time']) .'</small></p>
                                            </div>
                                            
                                            <div class="col-md-6 col-sm-12 text-end">
                                                <a course_id="' . $row['course_id'] . '" class="btn btn-danger course-btn addCourseBtn">Remove Course</a>
                                            </div>
                                     </div>

                                </div>
                            </div>
                        </div>
                    </div>';
                    }
                
                } else {
                    echo "there`s no courses in (courses) table.";
                }
                ?>



                </div>

            </div>


        </div>


    </center>


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





    <script>
    $(document).ready(function() {

        resizeCardsBox();


        $(window).resize(function() {
            resizeCardsBox();
        });


        $(".course-card").click(function() {
            let id = $(this).attr("course_id");
            window.location.href = `course.php?id=${id}`;
        })

        $("#search-input").on("keyup", function() {
            var value = $(this).val().toLowerCase();

            $(".card h5").filter(function() {
                $(this).parentsUntil('.col').toggle($(this).text().toLowerCase().indexOf(
                    value) > -1);
            });

        });


    });


    $(".addCourseBtn").click(function(event) {
        event.stopPropagation();

        let user_id = <?php if(isset($_SESSION['UserID'])){echo $_SESSION['UserID'];} else{echo -1;} ?>;
        let user_username = "<?php if(isset($_SESSION['Username'])){echo $_SESSION['Username'];} ?>";
        if (user_id == -1) {
            alert("You can't add a course, you must login first.");
            return;
        }

        let course_id = $(this).attr('course_id');
        let course_card = $('.course-card[course_id="' + course_id + '"]');
        let course_title = $('.course-card[course_id="' + course_id + '"] h5').text();
        let AddCourseBtn = $(this);

        $.ajax({
            url: "<?php echo $func; ?>removeCourse.php",
            method: "POST",
            data: {
                action: "removeCourse",
                course_id: course_id,
                user_id: user_id,
                user_username: user_username
            },
            success: function(data) {
                alert("(" + course_title + ") Course has been removed.");
                $(course_card).fadeToggle();

                setTimeout(function() {
                    $(course_card).remove();
                    if ($('#course-col').children().length == 0) {
                        $('#course-col').html('<p>No course has been added.</p>');
                    }
                }, 500);

            }
        })



        // console.log(course_id);
        // console.log(course_card);
    });


    function resizeCardsBox() {
        var cardsBox = $("#course-col");
        var cards = $("#course-col .card");
        var limit = 3; //show frist 3 Cards.
        var height = 0;

        if (cards.length != 0 && cards.length > limit) {
            for (var i = 0; i <= limit - 1; i++) {
                height += cards.eq(i).height();
                height += parseInt(cards.eq(i).css('marginBottom').replace('px', ''));
            }
            cardsBox.height(height - 10); // -10px
        }

    }
    </script>


</body>

</html>