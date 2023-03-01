<?php
session_start();

include "init.php";
include $func.'connect.php';
include $langs . "English.php";
$title = "SportPath";

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

function getCourseImage($course_id, $course_name){
  $path = "Files/Courses/";
  $directory = $course_id . '-' . $course_name;
  return ($path . $directory . "/ImageCourse.png");
}

function getDescription($course_id, $course_name){
  $path = "Files/Courses/";
  $directory = $course_id . '-' . $course_name;
  return file_get_contents($path . $directory . '/Description.txt');
}

include $func . "getVideosFromPlaylist_YoutubeAPI.php";
function getNumOfVideos($API_id){
    global $videoList;

    insertPlaylist_id($API_id);
    getVideoList();

    return count($videoList->items);
}

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
				$five_star_review++;}
	
			if($row["stars"] == '4'){
				$four_star_review++;}
	
			if($row["stars"] == '3'){
				$three_star_review++;}
	
			if($row["stars"] == '2'){
				$two_star_review++;}
	
			if($row["stars"] == '1'){
				$one_star_review++;}
	
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

function getUsers(){
    global $conn;
    
    $sql = "SELECT UserID FROM users";
    if($result = $conn->query($sql)){
        
        if ($result->num_rows > 0) {
            return $result->num_rows;
        } 
        else{
            return "0";
        }
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function getCourses(){
    global $conn;
    
    $sql = "SELECT course_id FROM courses";
    if($result = $conn->query($sql)){

        if ($result->num_rows > 0) {
            return $result->num_rows;
        } 
        else{
            return "0";
        }
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function getTypes(){
    global $conn;
    
    $sql = "SELECT type_id FROM types";
    if($result = $conn->query($sql)){
    
        if ($result->num_rows > 0) {
            return $result->num_rows;
        } 
        else{
            return "0";
        }
    
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function getReviews(){
    global $conn;
    
    $sql = "SELECT review_id FROM reviews";
    if($result = $conn->query($sql)){
    
        if ($result->num_rows > 0) {
            return $result->num_rows;
        } 
        else{
            return "0";
        }
    
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$totalUsers = getUsers();
$totalCourses =  getCourses();
$totalTypes = getTypes();
$totalReviews = getReviews();


function getUsername($user_id){
    global $conn;

    $sql = "SELECT Username FROM users WHERE UserID ='$user_id'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 && $result->num_rows < 2) {
		
		$row = $result->fetch_assoc();
        
        return $row['Username'];
	} 
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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

function getReviewContent($TextFileName){
    $file = "Files/Reviews/". $TextFileName .".txt";
    if(file_exists($file)){
        return file_get_contents($file);
    }else{
        return "<b>(Text file)not found</b>";
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


        <div id="mainSection" class="py-10 bg-image-full">

            <div class="row align-items-center justify-content-end m-0">

                <div class="col-md-4 text-white">
                    <div class="d-flex justify-content-end my-5">
                        <div class="fw-bolder">
                            <h1 class="m-0">ARE YOU</h1>
                            <h1 class="orangeTitle m-0">READY?</h1>
                            <h1 class="m-0">YOUR FIRST STEP STARTS HERE</h1>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="bg-dark" style="height:10px;"></div>

        <section class="py-5">
            <div id="inforamtion" class="container">
                <div class="row g-4">

                    <!-- Counter item -->
                    <div class="col-sm-6 col-xl-3">
                        <div class="d-flex justify-content-center align-items-center p-4 rounded-5"
                            style="background-color: rgba(247, 195, 46, 0.15) !important;">
                            <span class="display-6 lh-1 text-warning mb-0"><i class="fas fa-tv"></i></span>
                            <div class="ms-4 h6 fw-normal mb-0">
                                <div class="d-flex">
                                    <h5 id="TotalCourses" class="purecounter count-digit mb-0 fw-bold">
                                        <?php echo $totalCourses;?>
                                    </h5>
                                    <span class="mb-0 h5">+</span>
                                </div>
                                <p class="mb-0">Online Courses</p>
                            </div>
                        </div>
                    </div>

                    <!-- Counter item -->
                    <div class="col-sm-6 col-xl-3">
                        <div class="d-flex justify-content-center align-items-center p-4 rounded-5"
                            style="background-color: rgba(111, 66, 193, 0.10) !important;">
                            <span class="display-6 lh-1 text-purple mb-0"><i class="fas fa-user-graduate"></i></span>
                            <div class="ms-4 h6 fw-normal mb-0">
                                <div class="d-flex">
                                    <h5 id="TotalUsers" class="purecounter count-digit mb-0 fw-bold">
                                        <?php echo $totalUsers;?>
                                    </h5>
                                    <span class="mb-0 h5">+</span>
                                </div>
                                <p class="mb-0">Total Users</p>
                            </div>
                        </div>
                    </div>

                    <!-- Counter item -->
                    <div class="col-sm-6 col-xl-3">
                        <div class="d-flex justify-content-center align-items-center p-4 rounded-5"
                            style="background-color: rgba(29, 59, 83, 0.10) !important;">
                            <span class="display-6 lh-1 text-blue mb-0"><i class="fas fa-clipboard"></i></span>
                            <div class="ms-4 h6 fw-normal mb-0">
                                <div class="d-flex">
                                    <h5 id="TotalTypes" class="purecounter count-digit mb-0 fw-bold">
                                        <?php echo $totalTypes;?>
                                    </h5>
                                    <span class="mb-0 h5">+</span>
                                </div>
                                <p class="mb-0">Course Types</p>
                            </div>
                        </div>
                    </div>

                    <!-- Counter item -->
                    <div class="col-sm-6 col-xl-3">
                        <div class="d-flex justify-content-center align-items-center p-4 rounded-5"
                            style="background-color: rgba(23, 162, 184, 0.10) !important;">
                            <span class="display-6 lh-1 mb-0">
                                <i class="fas fa-comments" style="color: rgba(23, 162, 184) !important;"></i>
                            </span>
                            <div class="ms-4 h6 fw-normal mb-0">
                                <div class="d-flex">
                                    <h5 id="TotalReviews" class="purecounter count-digit mb-0 fw-bold">
                                        <?php echo $totalReviews;?>
                                    </h5>
                                    <span class="mb-0 h5">+</span>
                                </div>
                                <p class="mb-0">Users Reviews</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="cards-slider overflow-hidden px-md-5 py-5">
            <div class="container is-slider d-flex pb-4">
                <div class="slider_wrap">
                    <div class="slider_left cards-slider">
                        <div class="swiper is-content w-dyn-list">
                            <div class="swiper-wrapper is-content w-dyn-items" role="list">
                                <div class="swiper-slide is-content w-dyn-item" role="listitem">
                                    <div class="slider_info-top">
                                        <p class="slider_tagline">Our Features</p>
                                        <div class="slider_title">
                                            <p class="slider_title-text">Online Learning</p>
                                        </div>
                                    </div>
                                    <div class="slider_info-middle">
                                        <p class="slider_info-text">
                                            Supporting the educational process and its transformation from the stage of
                                            indoctrination to the stage of creativity, interaction and skill
                                            development, publishing and entertainment by adopting computers and their
                                            storage media and networks.
                                        </p>
                                    </div>
                                    <div class="slider_info-bottom"></div>
                                </div>
                                <div class="swiper-slide is-content w-dyn-item" role="listitem">
                                    <div class="slider_info-top">
                                        <p class="slider_tagline">Our Features</p>
                                        <div class="slider_title">
                                            <p class="slider_title-text">Experience Coaches</p>
                                        </div>
                                    </div>
                                    <div class="slider_info-middle">
                                        <p class="slider_info-text">
                                            We have many professional trainers in many different sports, and they have
                                            enough experience to provide good content to the trainees.
                                        </p>
                                    </div>
                                    <div class="slider_info-bottom"></div>
                                </div>
                                <div class="swiper-slide is-content w-dyn-item" role="listitem">
                                    <div class="slider_info-top">
                                        <p class="slider_tagline">Our Features</p>
                                        <div class="slider_title">
                                            <p class="slider_title-text">Various sports</p>
                                        </div>
                                    </div>
                                    <div class="slider_info-middle">
                                        <p class="slider_info-text">
                                            We have many different sports courses, and we are not specialized in a
                                            specific sport.
                                        </p>
                                    </div>
                                    <div class="slider_info-bottom"></div>
                                </div>

                                <div></div>

                                <div class="arrows">
                                    <a class="arrow is-left w-inline-block orange">
                                        <div class="arrow_svg w-embed">
                                            <p><i class="fa-solid fa-chevron-left"></i></p>
                                        </div>
                                    </a>

                                    <a class="arrow is-right w-inline-block orange">
                                        <div class="arrow_svg w-embed">
                                            <p><i class="fa-solid fa-chevron-right"></i></p>
                                        </div>
                                    </a>
                                </div>

                            </div>
                        </div>


                    </div>
                    <div class="slider_right">
                        <div class="swiper is-photos w-dyn-list">
                            <div class="swiper-wrapper is-photos w-dyn-items" role="list">
                                <div class="swiper-slide is-photos w-dyn-item" role="listitem" style="
                    background-image: url('images/OnlineLearning.jpg');
                  ">
                                    <div class="slider_height"></div>
                                </div>
                                <div class="swiper-slide is-photos w-dyn-item" role="listitem" style="
                    background-image: url('images/ExperienceCoaches.jpg');
                  ">
                                    <div class="slider_height"></div>
                                </div>
                                <div class="swiper-slide is-photos w-dyn-item" role="listitem" style="
                    background-image: url('images/VariousSports.jpg');
                  ">
                                    <div class="slider_height"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="divBar">
            <div class="blackBac"></div>
            <div class="imgBar"></div>
        </div>

        <!-- Latest Courses & Cards Slider -->
        <div class="container mt-5 mb-5">

            <div class="LatestCourses mb-5">
                <div class="d-flex border-bottom pb-2 mb-3">
                    <div class="col p-0">
                        <h2 class="m-0">Latest Courses</h2>
                    </div>
                    <div class="col d-flex align-items-center flex-row-reverse p-0">
                        <a href="courses.php" class="btn btn-outline-primary" type="button">View All</a>
                    </div>
                </div>


                <section class="splide">
                    <div class="splide__track">
                        <ul class="splide__list"> 

                            <?php

                          $sql = "SELECT * FROM courses ORDER BY course_id DESC LIMIT 9";
                          $result = $conn->query($sql);

                          if ($result->num_rows > 0) {
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                              echo '<li class="splide__slide">
                              <div class="card course-card" course_id="'. $row['course_id'] .'" >
                                  <img class="card-img-top"
                                      src="'. getCourseImage($row["course_id"], $row["course_name"]) .'"
                                      alt="'. $row["course_name"] .' Image" 
                                      style="height: 100%;"/>

                                  <div class="card-body">

                                  <div class="h-100 d-flex flex-column justify-content-between">
                                        <div class="align-self-start w-100">
                                        <h5 class="card-title">'. $row["course_name"] .'</h5>
                                        <p class="card-text">'. getDescription($row["course_id"], $row["course_name"]) .'</p>
                                        
                                        <div class="row course-info">
                                        <div class="col-6">
                                            <p>'. getNumOfVideos($row['API_id']) .' Videos</p>
                                        </div>

                                        <div class="col-6">
                                            <p>Group of age: '.$row['group_age'].'+</p>
                                        </div>

                                        <div class="col-6">
                                            <p>Rating rate: ' . getAverageRating($row['course_id']) . ' of 5</p>
                                        </div>

                                        <div class="col-6">
                                            <p>Type: ' . getCourseType($row['type_id']) . '</p>
                                        </div>
                                        </div>

                                        </div>
                                        <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center"><small class="text-muted">'. time_elapsed_string($row['time']) .'</small></div>';

                                        if(isset($_SESSION['UserID']) && !($MyCoursesUser == NULL) && in_array($row['course_id'], $MyCoursesUser) ){
                                                //in $MyCoursesUser.
                                        }else{
                                          echo '<div><a course_id="' . $row['course_id'] . '" class="btn btn-primary course-btn addCourseBtn">Add Course</a></div>';
                                        }
                                        
                                        echo '</div>
                                    </div>
                                  </div>
                              </div>
                          </li>';
                            }
                          } else {
                            echo "There's no courses";
                          }

                        ?>
                        </ul>
                    </div>
                </section>
            </div>


            <!-- Latest Reviews & Cards Slider -->
            <div class="d-flex border-bottom pb-2 mb-3">
                <div class="col p-0">
                    <h2 class="m-0">Latest Reviews</h2>
                </div>
                <div class="col d-flex align-items-center flex-row-reverse p-0"></div>
            </div>

            <section class="splide reviews-splide">
                <div class="splide__track">
                    <ul class="splide__list">

                        <?php

                            $sql = "SELECT * FROM reviews ORDER BY review_id DESC LIMIT 9";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                            // output data of each row
                            while($row = $result->fetch_assoc()) {

                                echo '<li class="splide__slide">
                                <div class="row text-center d-flex align-items-stretch h-100">
                                    <div class="mb-0 d-flex align-items-stretch">
                                        <div class="card testimonial-card w-100 reviewCard">
                                            <div class="card-up css-selector" ></div>
                                            <div class="avatar mx-auto bg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    class="bi bi-person-circle" viewBox="0 0 16 16">
                                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                                    <path fill-rule="evenodd"
                                                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                                </svg>
                                            </div>
                                            <div class="card-body pt-0">
                                                <h4 class="mb-3">'. getUsername($row['user_id']) .'</h4>
                                                <h6 class="courseTitle text-primary mb-1" course_id="'. $row['course_id'] .'">'. getCourseName($row['course_id']) .'</h6>
                                                <ul class="list-unstyled d-flex justify-content-center mb-0">';
                                            
                                            for ($star = 1; $star <= 5; $star++) {
                                                $class_name;
    
                                                if ($row['stars'] >= $star) {
                                                    $class_name = 'fa-solid';
                                                } else {
                                                    $class_name = 'fa-regular';
                                                }
    
                                                echo '<li>
                                                    <i class="fa-star '.  $class_name .' fa-sm text-warning"></i>
                                                    </li>';
                                            }

                                            echo '</ul>
    
                                                <hr class="w-80"/>
    
                                                <div class="dark-grey-text mt-4 mb-4">
                                                <i class="fa fa-quote-left pe-2 d-inline"></i>'. getReviewContent($row['content']) .'
                                                </div>

                                                <p class="m-0"><small class="text-muted">'. time_elapsed_string($row['datetime']) .'</small></p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>';

                            }
                            } else {
                            echo "There's no reviews.";
                            }
                    ?>

                    </ul>
                </div>
            </section>



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
    </script>

    <script>
    let photoSwiper = new Swiper(".swiper.is-photos", {
        effect: "cards",
        grabCursor: true,
        loop: true,
        // autoplay: true,
        keyboard: true,
        // Navigation arrows
        navigation: {
            nextEl: ".arrow.is-right",
            prevEl: ".arrow.is-left",
        },
    });

    let contentSwiper = new Swiper(".swiper.is-content", {
        speed: 0,
        loop: true,
        followFinger: false,
        effect: "fade",
        fadeEffect: {
            crossFade: true,
        },
    });

    photoSwiper.controller.control = contentSwiper;
    contentSwiper.controller.control = photoSwiper;
    </script>




    <script>
    $(document).ready(function() {

        var elms = document.getElementsByClassName('splide');

        for (var i = 0; i < elms.length; i++) {
            new Splide(elms[i], {

                perPage: 3,
                gap: '2rem',
                autoplay: true,

                breakpoints: {
                    991: {
                        perPage: 2,
                        gap: '.7rem',
                    },
                    767: {
                        perPage: 1,
                        gap: '.7rem',
                    },
                }
            }).mount();
        }

        $(".course-card").click(function() {
            let id = $(this).attr("course_id");
            window.location.href = `course.php?id=${id}`;
        })

        $(".courseTitle").click(function() {
            let id = $(this).attr("course_id");
            window.location.href = `course.php?id=${id}`;
        })



        $(".addCourseBtn").click(function(event) {
            event.stopPropagation();

            let user_id =
                <?php if(isset($_SESSION['UserID'])){echo $_SESSION['UserID'];} else{echo -1;} ?>;
            let user_username =
                "<?php if(isset($_SESSION['Username'])){echo $_SESSION['Username'];} ?>";
            if (user_id == -1) {
                alert("You can't add a course, you must login first.");
                return;
            }

            let course_id = $(this).attr('course_id');
            let course_card = $('.card[course_id="' + course_id + '"]');
            let course_title = $('.card[course_id="' + course_id + '"] h5').text();
            let AddCourseBtn = $(this);

            $.ajax({
                url: "<?php echo $func; ?>addCourse.php",
                method: "POST",
                data: {
                    action: "addCourse",
                    course_id: course_id,
                    user_id: user_id,
                    user_username: user_username
                },
                success: function(data) {
                    alert("(" + course_title +
                        ") Course has been added to My Courses page.");
                    $(AddCourseBtn).slideUp();
                }
            })
        });


    });
    </script>

</body>

</html>