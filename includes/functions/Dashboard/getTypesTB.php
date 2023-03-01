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
$table = 'types'; 
 
// Table's primary key 
$primaryKey = 'type_id'; 
 
// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array( 

    array( 'db' => 'type_id',   		'dt' => 0,
    'formatter' => function( $d, $row ) {
        return '<input id="checkbox-' . $d . '" type="checkbox" 
        class="form-check-input" type-id="' . $d . '"=>';
    }), 

    array( 'db' => 'type_id',   		'dt' => 1), 
    array( 'db' => 'type_name',   		'dt' => 2), 

    array( 'db' => 'type_id',  		'dt' => 3,
    'formatter' => function( $d, $row ) {
        return '<button class="btn btn-Edit btn-sm" 
        type="button" data-toggle="modal" data-target="#EditTypeModal"  
        onclick="UpdateType(' . $d . ')"><i class="fa fa-edit"></i></button>';
    })

);
 



require( 'ssp.class.php' );

// Output data as json format 
echo json_encode( 
    SSP::complex( $_GET, $dbDetails, $table, $primaryKey, $columns)
);