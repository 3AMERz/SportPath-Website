<?php 

include '../connect.php';

function get_Type($TypeId){
    global $conn;

    $sql = "SELECT type_name FROM types WHERE type_id ='$TypeId'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 && 2 > $result->num_rows) {
		
		$typeRow = $result->fetch_assoc();
        return $typeRow['type_name'];

    	}
	else {
		echo "Not found this type name from this id, 
        Or there`s tow types they have same id.";
	}
}


function getPlaylistName($API_id){
    global $conn;

    $sql = "SELECT playlist_name FROM courses_api WHERE id ='$API_id'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 && 2 > $result->num_rows) {
		
		$typeRow = $result->fetch_assoc();
        return $typeRow['playlist_name'];

    	}
	else {
		echo "Not found this playlist name from this id, 
        Or there`s tow playlists they have same id.";
	}
}

function getPlaylistID($API_id){
    global $conn;

    $sql = "SELECT playlist_id FROM courses_api WHERE id ='$API_id'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 && 2 > $result->num_rows) {
		
		$typeRow = $result->fetch_assoc();
        return $typeRow['playlist_id'];

    	}
	else {
		echo "Not found this playlist_id from this id, 
        Or there`s tow playlists they have same id.";
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







// Database connection info 
$dbDetails = array( 
    'host' => 'localhost', 
    'user' => 'u677478709_sportpath', 
    'pass' => '2x*Uk];3Tx?4', 
    'db'   => 'u677478709_sportpath' 
); 
 
// DB table to use 
$table = 'courses'; 
 
// Table's primary key 
$primaryKey = 'course_id'; 
 
// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array( 

    array( 'db' => 'course_id',   		'dt' => 0,
    'formatter' => function( $d, $row ) {
        return '<input id="checkbox-' . $d . '" type="checkbox" 
        class="form-check-input" course-id="' . $d . '"=>';
    }), 

    array( 'db' => 'course_id',   		'dt' => 1), 
    array( 'db' => 'course_id',      'dt' => 2,
    'formatter' => function( $d, $row ) {
        return '<img src="../Files/Courses/'. $d.'-'.getCourseName($d) .'/ImageCourse.png" alt="CourseImage'.$d.'" style="height:80px;">';
    }), 

    array( 'db' => 'course_name',      'dt' => 3), 

    array( 'db' => 'type_id',   		'dt' => 4,
    'formatter' => function( $d, $row ) {
        if($d == NULL){
            return "<b>(NULL)</b>";
        }else{
            return get_Type($d);
        }
    }), 

    array( 'db' => 'group_age',   'dt' => 5),
    array( 'db' => 'API_id', 	'dt' => 6),

    array( 'db' => 'API_id', 	'dt' => 7,
    'formatter' => function( $d, $row ) {
        return getPlaylistName($d);
    }),
    array( 'db' => 'API_id', 	'dt' => 8,
    'formatter' => function( $d, $row ) {
        return getPlaylistID($d);
    }),

    array( 'db' => 'time', 		'dt' => 9,
    'formatter' => function( $d, $row ) {
        return date( 'Y/m/d h:i A', strtotime($d));
    }),

    array( 'db' => 'course_id',  		'dt' => 10,
    'formatter' => function( $d, $row ) {
        return '<button class="btn btn-Edit btn-sm" 
        type="button" data-toggle="modal" data-target="#EditCourseModal"  
        onclick="UpdateCourse(' . $d . ')"><i class="fa fa-edit"></i></button>';
    })

);
 



require( 'ssp.class.php' );

// Output data as json format 
echo json_encode( 
    SSP::complex( $_GET, $dbDetails, $table, $primaryKey, $columns)
);