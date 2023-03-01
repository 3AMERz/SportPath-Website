<?php

include $func . "connect.php";

$query = " SELECT * FROM countries ORDER BY country_name ASC ";
$result = $conn->query($query);

foreach($result as $row) {
    echo '<option value="'.$row["country_id"].'">'.$row["country_name"].'</option>';
}
