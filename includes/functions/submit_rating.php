<?php


include "connect.php";




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

function formatingOfTime($datatime){
    return time_elapsed_string($datatime);
}





function getUsername($user_id){
	global $conn;

	$sql = "SELECT Username FROM users WHERE UserID ='$user_id'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 && 2 > $result->num_rows) {
		
		$row = $result->fetch_assoc();
		
		return $row['Username'];
	}
	else {
		echo "Error: there's no a user has (". $user_id . ") user id,
		 or there's users they have same (". $user_id .") id.";
	}
}


function createReviewName(){
	$newName = uniqid('review-');
	return $newName;
}

function createReviewText($nameReviewText,$content){
	if(file_exists('../../Files/Reviews/')){
		file_put_contents('../../Files/Reviews/'.$nameReviewText.'.txt',$content);
	}
	else{
		echo "ERROR: File not found (revisions).";
	}
	
}



function readReviewContent($ReviewName){
    return file_get_contents('../../Files/Reviews/'.$ReviewName.'.txt');
}










//submit_rating.php

if(isset($_POST["rating_data"])){
	
	$nameReviewText = createReviewName();
	createReviewText($nameReviewText,$_POST["user_review"]);
	
	$user_id 	=	$_POST["user_id"];
	$course_id	=	$_POST["course_id"];
	$stars		=	$_POST["rating_data"];
	$content	=	$nameReviewText;
	$time	    =	date("Y-m-d H:i:s");

	

	$sql = "INSERT INTO reviews (user_id, course_id, stars, content, datetime) VALUES ('$user_id', '$course_id', '$stars', '$content', '$time')";
	
	if ($conn->query($sql) === TRUE) {
		echo "Your Review & Rating Successfully Submitted";
	} 
	else {
	echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();

}



if(isset($_POST["action"])){

	$course_id = $_POST['course_id'];

	$sql = "SELECT * FROM reviews WHERE course_id ='$course_id' ORDER BY review_id DESC";
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
		$review_content = array();


	  	while($row = $result->fetch_assoc()) {

			$review_content[] = array(
				'user_name'		=>	getUsername($row["user_id"]),
				'user_review'	=>	readReviewContent($row["content"]),
				'rating'		=>	$row["stars"],
				'datetime'		=>	formatingOfTime($row["datetime"])
			);

			if($row["stars"] == '5')
			{
				$five_star_review++;
			}
	
			if($row["stars"] == '4')
			{
				$four_star_review++;
			}
	
			if($row["stars"] == '3')
			{
				$three_star_review++;
			}
	
			if($row["stars"] == '2')
			{
				$two_star_review++;
			}
	
			if($row["stars"] == '1')
			{
				$one_star_review++;
			}
	
			$total_review++;
	
			$total_user_rating = $total_user_rating + $row["stars"];
	  	}


		$average_rating = $total_user_rating / $total_review;

		$output = array(
			'average_rating'	=>	number_format($average_rating, 1),
			'total_review'		=>	$total_review,
			'five_star_review'	=>	$five_star_review,
			'four_star_review'	=>	$four_star_review,
			'three_star_review'	=>	$three_star_review,
			'two_star_review'	=>	$two_star_review,
			'one_star_review'	=>	$one_star_review,
			'review_data'		=>	$review_content
		);
	  
		echo json_encode($output);

	} 

	else {
	  echo "0";
	}

	$conn->close();

}

?>