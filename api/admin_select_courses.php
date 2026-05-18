<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

/* =====================================
   SELECT COURSES
===================================== */

$data = [];

$sql = "
SELECT *
FROM courses
WHERE archived = 0
ORDER BY id DESC
";

$result =
    $mysqli->query($sql);

while (
    $row =
    $result->fetch_assoc()
) {

    $data[] = $row;
}

echo json_encode([

    'data' => $data

]);
