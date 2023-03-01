<?php

$query = " SELECT * FROM courses_api ORDER BY id ASC ";
$result = $conn->query($query);

foreach($result as $row) {
    echo '<option value="'. $row["id"] .'">'.$row["id"].'</option>';
}
