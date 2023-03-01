<?php 

include '../connect.php';


function createReviewName(){
	$newName = uniqid('review-');
	return $newName;
}

function readReviewContent($ReviewName){
    return file_get_contents('../../Files/Reviews/'.$ReviewName.'.txt');
}




function deleteFile($path, $file){
    if (unlink($path . $file . '.txt')) {
        // echo ($file . " has been deleted");
    }
    else {
        echo ($file . " cannot be deleted due to an error");
    }
}



function getContentName($review_id){
    global $conn;

    $sql = "SELECT content FROM reviews WHERE review_id ='$review_id'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0 && $result->num_rows < 2) {
		
		$row = $result->fetch_assoc();
        return $row['content'];
	} 
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
	}
}



function deleteReviewText($review_id){
    global $conn;

    $sql = "SELECT content FROM reviews WHERE review_id ='$review_id'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 && $result->num_rows < 2) {
		
		$row = $result->fetch_assoc();

        $path = "../../../Files/Reviews/";
        deleteFile($path, $row['content']); //($path, $file)

	} 
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
	}
}






if(isset($_POST['arrayDel'])){
    
    $arrayDel = $_POST['arrayDel'];
    foreach($arrayDel as $id){

        $path = "../../../Files/Reviews";
        if(file_exists($path)){
            deleteReviewText($id); //($review_id)
        }
        else{
            echo "Error: (" . $directory . ") dirocory is not found in path: ". $path ."\n";
        }

        $sql = "DELETE FROM reviews WHERE review_id = '$id'";

        if ($conn->query($sql) === TRUE) {
            echo "Successful deletion.";

        } else {
            echo "Error deleting record: " . $conn->error . "\n";
        }
    
    }




}


if( isset($_POST["action"]) && ($_POST["action"] =='insertReview') ){

    $nameReviewText = createReviewName();
    $path = '../../../Files/Reviews';
    if(!file_exists($path)){
        mkdir($path, 0777, true);
        echo "We create a (Reviews) Directory in path:(Files/Reviews).";
    }

    $course_id	=	$_POST["Course_ID"];    
    $user_id 	=	$_POST["User_ID"];
    $stars		=	$_POST["Star"];
    $content	=	$nameReviewText;
    $time	    =	date('Y/m/d H:i:s', time());
    
    
    $sql = "INSERT INTO reviews (user_id, course_id, stars, content, datetime) VALUES ('$user_id', '$course_id', '$stars', '$content', '$time')";
        
    if ($conn->query($sql) === TRUE) {

        file_put_contents($path.'/'.$nameReviewText.'.txt',$_POST["Content"]);
        echo "Successful addition.";  

    }else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

}   


if( isset($_POST["action"]) && ($_POST["action"] =='updateReview') ){

    $review_id	=	$_POST["review_id"];    
    $course_id	=	$_POST["Course_ID"];    
    $user_id 	=	$_POST["User_ID"];
    $stars		=	$_POST["Star"];
    $content	=	$_POST["Content"];
    $path = "../../../Files/Reviews/";

    $sql = "UPDATE reviews SET course_id ='$course_id', user_id='$user_id', 
    stars='$stars' WHERE review_id = '$review_id'";
	
    if ($conn->query($sql) === TRUE) {

        file_put_contents( $path . getContentName($review_id) . '.txt' , $content);
        echo "Successful Update.";
    } 
    else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

}





if( isset($_POST["action"]) && ($_POST["action"] =='getReview') ){

    $review_id = $_POST['review_id'];
    
    $sql = "SELECT * FROM reviews WHERE review_id ='$review_id'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 && $result->num_rows < 2) {
		
		$review = $result->fetch_assoc();

        $path = "../../../Files/Reviews/";
        
        $output = array(
			'course_id'	  =>	$review['course_id'],
			'user_id'	  =>	$review['user_id'],
            'content'     =>	file_get_contents($path . $review['content'] .'.txt'),
			'stars'       =>    $review['stars']
		);
	  
		echo json_encode($output);
	} 
    else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

}


