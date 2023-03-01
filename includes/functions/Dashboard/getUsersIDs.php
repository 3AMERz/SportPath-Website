<?php

$query = " SELECT UserID, Username FROM users ORDER BY UserID ASC ";
$result = $conn->query($query);

foreach($result as $row) {
    echo '<option value="' . $row["UserID"] . '">(' . $row["UserID"] . ') - ' . $row["Username"] . '</option>';
}
