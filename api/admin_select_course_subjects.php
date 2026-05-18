<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

/* =====================================
   SELECT COURSE SUBJECTS
===================================== */

$course_id =
    intval(
        $_GET['course_id'] ?? 0
    );

$data = [];

$stmt =
    $mysqli->prepare("
    SELECT *
    FROM course_subjects
    WHERE

        course_id = ?

    AND

        archived = 0
");

$stmt->bind_param(
    "i",
    $course_id
);

$stmt->execute();

$result =
    $stmt->get_result();

while (
    $row =
    $result->fetch_assoc()
) {

    $data[] = $row;
}

echo json_encode([

    'data' => $data

]);
