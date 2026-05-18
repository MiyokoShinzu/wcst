<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

/* =====================================
   GET PARAMETERS
===================================== */

$faculty_profile_id =
    intval(
        $_GET['faculty_profile_id'] ?? 0
    );

$school_year_id =
    intval(
        $_GET['school_year_id'] ?? 0
    );

$course_id =
    intval(
        $_GET['course_id'] ?? 0
    );

/* =====================================
   VALIDATION
===================================== */

if (

    $faculty_profile_id <= 0 ||

    $school_year_id <= 0 ||

    $course_id <= 0

) {

    echo json_encode([

        'data' => []

    ]);

    exit();
}

/* =====================================
   SELECT ASSIGNMENTS
===================================== */

$data = [];

$stmt =
    $mysqli->prepare("

    SELECT

        academic_assignments.id,

        course_subjects.id
        AS course_subject_id

    FROM academic_assignments

    INNER JOIN course_subjects

        ON

        course_subjects.course_id =
        academic_assignments.course_id

        AND

        course_subjects.subject_id =
        academic_assignments.subject_id

    WHERE

        academic_assignments.faculty_profile_id = ?

    AND

        academic_assignments.school_year_id = ?

    AND

        academic_assignments.course_id = ?

    AND

        academic_assignments.archived = 0

");

$stmt->bind_param(

    "iii",

    $faculty_profile_id,
    $school_year_id,
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
