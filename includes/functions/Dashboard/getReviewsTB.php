<?php 

include '../connect.php';


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

function starsDesign($Stars){
    $html = '<div class="rating">';

    for($star = 1; $star <= 5; $star++){
        $class_name;
        if ($Stars >= $star) {
            $class_name = 'text-warning';
        } else {
            $class_name = 'star-light';
        }
        $html .= '<i class="fas fa-star '. $class_name .' mr-1 main_star"></i>';
    }

    $html .= '</div>';
    return $html;

}



// Database connection info 
$dbDetails = array( 
    'host' => 'localhost', 
    'user' => 'u677478709_sportpath', 
    'pass' => '2x*Uk];3Tx?4', 
    'db'   => 'u677478709_sportpath' 
); 
 
// DB table to use 
$table = 'reviews'; 
 
// Table's primary key 
$primaryKey = 'review_id'; 
 
// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array( 

    array( 'db' => 'review_id',   		'dt' => 0,
    'formatter' => function( $d, $row ) {
        return '<input id="checkbox-' . $d . '" type="checkbox" 
        class="form-check-input" review-id="' . $d . '"=>';
    }), 

    array( 'db' => 'review_id',   		'dt' => 1), 

    array( 'db' => 'course_id',      'dt' => 2,
    'formatter' => function( $d, $row ) {
        return '('.$d.') - '.getCourseName($d);
    }), 

    array( 'db' => 'user_id',      'dt' => 3,
    'formatter' => function( $d, $row ) {
        return '('.$d.') - '.getUsername($d);
    }), 

    array( 'db' => 'content',   		'dt' => 4,
    'formatter' => function( $d, $row ) {
        $file = "../../../Files/Reviews/". $d .".txt";
        if(file_exists($file)){
            return file_get_contents($file);
        }else{
            return "<b>(Text file)not found</b>";
        }
        
    }), 

    array( 'db' => 'stars',   'dt' => 5,
    'formatter' => function( $d, $row ) {
        return starsDesign($d);
    }),

    array( 'db' => 'datetime', 		'dt' => 6,
    'formatter' => function( $d, $row ) {
        return date( 'Y/m/d h:i A', strtotime($d));
    }),

    array( 'db' => 'review_id',  		'dt' => 7,
    'formatter' => function( $d, $row ) {
        return '<button class="btn btn-Edit btn-sm" 
        type="button" data-toggle="modal" data-target="#EditReviewModal"  
        onclick="UpdateReview(' . $d . ')"><i class="fa fa-edit"></i></button>';
    })

);
 



require( 'ssp.class.php' );

// Output data as json format 
echo json_encode( 
    SSP::complex( $_GET, $dbDetails, $table, $primaryKey, $columns)
);