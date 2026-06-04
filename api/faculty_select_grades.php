<?php

header("Content-Type: application/json");

include '../src/connection.php';

global $mysqli;

$academic_assignment_id =
    intval($_GET['academic_assignment_id'] ?? 0);

$data = [];

$query = "

    SELECT

        enrolled_subjects.id
        AS enrollment_id,

        enrolled_subjects.prelim,
        enrolled_subjects.midterm,
        enrolled_subjects.prefinal,
        enrolled_subjects.final,

        student_profiles.student_number,

        CONCAT(

            student_profiles.lastname,

            ', ',

            student_profiles.firstname,

            IF(
                student_profiles.middlename IS NULL
                OR student_profiles.middlename = '',
                '',
                CONCAT(
                    ' ',
                    student_profiles.middlename
                )
            ),

            IF(
                student_profiles.suffix IS NULL
                OR student_profiles.suffix = '',
                '',
                CONCAT(
                    ' ',
                    student_profiles.suffix
                )
            )

        ) AS full_name,

        student_profiles.year_level,

        student_profiles.section

    FROM enrolled_subjects

    INNER JOIN student_profiles

        ON student_profiles.id =
        enrolled_subjects.student_profile_id

    WHERE

        enrolled_subjects.academic_assignment_id =
        '$academic_assignment_id'

    ORDER BY

        student_profiles.lastname ASC,

        student_profiles.firstname ASC

";

$result = $mysqli->query($query);

while ($row = $result->fetch_assoc()) {

    $average = null;

    if (
        $row['prelim'] !== null &&
        $row['midterm'] !== null &&
        $row['prefinal'] !== null &&
        $row['final'] !== null
    ) {

        $average =
            (
                $row['prelim'] +
                $row['midterm'] +
                $row['prefinal'] +
                $row['final']
            ) / 4;
    }

    $data[] = [

        'enrollment_id' =>
        $row['enrollment_id'],

        'prelim' =>
        $row['prelim'],

        'midterm' =>
        $row['midterm'],

        'prefinal' =>
        $row['prefinal'],

        'final' =>
        $row['final'],

        'average' =>
        $average,

        'student_number' =>
        $row['student_number'],

        'full_name' =>
        $row['full_name'],

        'year_level' =>
        $row['year_level'],

        'section' =>
        $row['section']

    ];
}

echo json_encode([
    'data' => $data
]);
