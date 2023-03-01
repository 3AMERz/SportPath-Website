<?php

$query = " SELECT course_id, course_name FROM courses ORDER BY course_id ASC ";
$result = $conn->query($query);

foreach($result as $row) {
    echo '<option value="' . $row["course_id"] . '">(' . $row["course_id"] . ') - ' . $row["course_name"] . '</option>';
}
