<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

/* =====================================
   INPUT
===================================== */

$academic_assignment_id =
    intval(
        $_GET['academic_assignment_id'] ?? 0
    );

/* =====================================
   DATA
===================================== */

$data = [];

/* =====================================
   SELECT STUDENTS
===================================== */

$query = "

    SELECT

        student_profiles.id
        AS student_profile_id,

        student_profiles.student_number,

        CONCAT(

            student_profiles.firstname,
            ' ',
            student_profiles.lastname

        ) AS full_name,

        student_profiles.year_level,

        student_profiles.section,

        IF(

            enrolled_subjects.id IS NULL,

            0,

            1

        ) AS assigned

    FROM student_profiles

    LEFT JOIN enrolled_subjects

        ON enrolled_subjects.student_profile_id =
        student_profiles.id

        AND enrolled_subjects.academic_assignment_id =
        '$academic_assignment_id'

    ORDER BY

        assigned DESC,

        student_profiles.lastname ASC

";

$result =
    $mysqli->query($query);

/* =====================================
   FETCH
===================================== */

while (

    $row =
    $result->fetch_assoc()

) {

    $data[] = [

        'student_profile_id' =>

        $row['student_profile_id'],

        'student_number' =>

        $row['student_number'],

        'full_name' =>

        $row['full_name'],

        'year_level' =>

        $row['year_level'],

        'section' =>

        $row['section'],

        'assigned' =>

        $row['assigned']

    ];
}

/* =====================================
   RESPONSE
===================================== */

echo json_encode([

    'data' => $data

]);
