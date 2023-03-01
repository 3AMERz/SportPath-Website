<?php

$query = " SELECT * FROM types ORDER BY type_name ASC ";
$result = $conn->query($query);

foreach($result as $row) {
    echo '<option value="'. $row["type_id"].'">'.$row["type_name"].'</option>';
}
