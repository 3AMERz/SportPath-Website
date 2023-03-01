<?php

include $func . "connect.php";

$query = " SELECT * FROM sa_cities ORDER BY nameEn ASC ";
$result = $conn->query($query);

foreach($result as $row) {
    echo '<option value="'.$row["id"].'">'.$row["nameEn"].'</option>';
}
