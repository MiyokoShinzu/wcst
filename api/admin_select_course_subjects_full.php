<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

/* =====================================
   GET COURSE SUBJECTS
===================================== */

$course_id =
    intval(
        $_GET['course_id'] ?? 0
    );

$data = [];

$stmt =
    $mysqli->prepare("

    SELECT

        course_subjects.id
        AS course_subject_id,

        course_subjects.course_id,

        course_subjects.subject_id,

        subjects.subject_code,
        subjects.subject_name,
        subjects.units,
        subjects.semester

    FROM course_subjects

    INNER JOIN subjects

        ON subjects.id =
        course_subjects.subject_id

    WHERE

        course_subjects.course_id = ?

    AND

        course_subjects.archived = 0

    ORDER BY subjects.subject_name ASC

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
