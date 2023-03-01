<?php 

include '../connect.php';

function getCountry($id){
    global $conn;

    $sql = "SELECT country_name FROM countries WHERE country_id ='$id'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 && 2 > $result->num_rows) {
		
		$countryRow = $result->fetch_assoc();
        return $countryRow['country_name'];

    	}
	else {
		echo "Not found country name from this id, 
        Or there`s tow country they have same id.";
	}
}


function getCity($id){

    if($id == NULL){
        return "(None)";
    }
    else{

        global $conn;

        $sql = "SELECT nameEn FROM sa_cities WHERE id ='$id'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0 && 2 > $result->num_rows) {
            
            $cityRow = $result->fetch_assoc();
            return $cityRow['nameEn'];

            }
        else {
            echo "Not found city name from this id, 
            Or there`s tow city they have same id.";
        }

    }
}


function GroubId($num){
    if($num == 0){
        return '<span class="badge bg-secondary">User</span>';
    }
    else{
        return '<span class="badge bg-primary">Admin</span>';
    }
}

// function DeCrypt($pass){
//     $pass = ;
// }









// Database connection info 
$dbDetails = array( 
    'host' => 'localhost', 
    'user' => 'u677478709_sportpath', 
    'pass' => '2x*Uk];3Tx?4', 
    'db'   => 'u677478709_sportpath' 
); 
 
// DB table to use 
$table = 'users'; 
 
// Table's primary key 
$primaryKey = 'UserID'; 
 
// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array( 

    array( 'db' => 'UserID',   		'dt' => 0,
    'formatter' => function( $d, $row ) {
        return '<input id="checkbox-' . $d . '" type="checkbox" class="form-check-input" user-id="' . $d . '"=>';
    }), 
    
    array( 'db' => 'UserID',   		'dt' => 1 ), 
    array( 'db' => 'Username',      'dt' => 2 ), 
    
    array( 'db' => 'Email',   		'dt' => 3,
    'formatter' => function( $d, $row ) {
        if(!empty($d)){
            return $d;
        }
        else{
            return 'NULL';
        }
    }), 

    array( 'db' => 'PhoneNumber',   'dt' => 4,
    'formatter' => function( $d, $row ) {
        if(!empty($d)){
            return $d;
        }
        else{
            return 'NULL';
        }
    }), 

    array( 'db' => 'FirstName', 	'dt' => 5,
    'formatter' => function( $d, $row ) {
        if(!empty($d)){
            return $d;
        }
        else{
            return 'NULL';
        }
    }),

    array( 'db' => 'LastName', 		'dt' => 6,
    'formatter' => function( $d, $row ) {
        if(!empty($d)){
            return $d;
        }
        else{
            return 'NULL';
        }
    }),

    array( 'db' => 'Gender', 		'dt' => 7,
    'formatter' => function( $d, $row ) {
        if(!empty($d)){
            return $d;
        }
        else{
            return 'NULL';
        }
    }),

    array( 'db' => 'country_id', 	'dt' => 8,
    'formatter' => function( $d, $row ) {
        if(!empty($d)){
            return getCountry($d);
        }
        else{
            return 'NULL';
        }
    }),

    array( 'db' => 'city_id', 		'dt' => 9,
    'formatter' => function( $d, $row ) {
        if(!empty($d)){
            return getCity($d);
        }
        else{
            return 'NULL';
        }
    }),

    array( 'db' => 'Birthday', 		'dt' => 10,      
    'formatter' => function( $d, $row ) {
        if(!empty($d)){
            return date( 'Y/m/d h:i A', strtotime($d));
        }
        else{
            return 'NULL';
        }
    }),

    array( 'db' => 'GroupID', 		'dt' => 11,
    'formatter' => function( $d, $row ) {
        return GroubId($d);
    }),

    array( 'db' => 'Datetime', 		'dt' => 12,
    'formatter' => function( $d, $row ) {
        if(!empty($d)){
            return date( 'Y/m/d h:i A', strtotime($d));
        }
        else{
            return 'NULL';
        }
    }),

    array( 'db' => 'loginWith', 		'dt' => 13 ),
    
    array( 'db' => 'UserID', 		'dt' => 14,
    'formatter' => function( $d, $row ) {
        return '<button class="btn btn-Edit btn-sm" 
        type="button" data-toggle="modal" data-target="#EditUserModal"  
        onclick="UpdateUser(' . $d . ')"><i class="fa fa-edit"></i></button>';
    })

);
 



require( 'ssp.class.php' );

// Output data as json format 
echo json_encode( 
    SSP::complex( $_GET, $dbDetails, $table, $primaryKey, $columns)
);