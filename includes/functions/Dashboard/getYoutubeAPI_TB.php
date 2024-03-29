<?php 

include '../connect.php';

// Database connection info 
$dbDetails = array( 
    'host' => 'localhost', 
    'user' => 'u677478709_sportpath', 
    'pass' => '2x*Uk];3Tx?4', 
    'db'   => 'u677478709_sportpath'
); 
 
// DB table to use 
$table = 'courses_api'; 
 
// Table's primary key 
$primaryKey = 'id'; 
 
// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array( 


    array( 'db' => 'id',   		        'dt' => 0), 
    array( 'db' => 'playlist_name',     'dt' => 1), 
    array( 'db' => 'playlist_id',  		'dt' => 2),
    array( 'db' => 'datetime', 		    'dt' => 3,
    'formatter' => function( $d, $row ) {
        return date( 'Y/m/d h:i A', strtotime($d));
    }),

);
 



require( 'ssp.class.php' );

// Output data as json format 
echo json_encode( 
    SSP::complex( $_GET, $dbDetails, $table, $primaryKey, $columns)
);