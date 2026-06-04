<?php

header("Content-Type: application/json");

include '../src/connection.php';

global $mysqli;

$academic_assignment_id =
    intval(
        $_POST['academic_assignment_id'] ?? 0
    );

$students =
    $_POST['students'] ?? [];

/* =====================================
   CURRENT STUDENTS
===================================== */

$currentStudents = [];

$result =
    $mysqli->query("

        SELECT student_profile_id

        FROM enrolled_subjects

        WHERE academic_assignment_id =
        '$academic_assignment_id'

    ");

while ($row = $result->fetch_assoc()) {

    $currentStudents[] =
        intval(
            $row['student_profile_id']
        );
}

/* =====================================
   INSERT NEW STUDENTS
===================================== */

foreach ($students as $student_profile_id) {

    $student_profile_id =
        intval(
            $student_profile_id
        );

    if (

        !in_array(

            $student_profile_id,

            $currentStudents

        )

    ) {

        $stmt =
            $mysqli->prepare("

                INSERT INTO enrolled_subjects(

                    academic_assignment_id,
                    student_profile_id

                )

                VALUES(

                    ?, ?

                )

            ");

        $stmt->bind_param(

            "ii",

            $academic_assignment_id,
            $student_profile_id

        );

        $stmt->execute();
    }
}

/* =====================================
   REMOVE UNCHECKED STUDENTS
===================================== */

foreach ($currentStudents as $student_profile_id) {

    if (

        !in_array(

            $student_profile_id,

            $students

        )

    ) {

        $stmt =
            $mysqli->prepare("

                DELETE FROM enrolled_subjects

                WHERE

                    academic_assignment_id = ?

                    AND

                    student_profile_id = ?

            ");

        $stmt->bind_param(

            "ii",

            $academic_assignment_id,
            $student_profile_id

        );

        $stmt->execute();
    }
}

/* =====================================
   RESPONSE
===================================== */

echo json_encode([

    'success' => 1

]);
