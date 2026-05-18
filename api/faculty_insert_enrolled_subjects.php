<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

$academic_assignment_id =
    intval(
        $_POST['academic_assignment_id'] ?? 0
    );

$students =
    $_POST['students'] ?? [];

/* =====================================
   DELETE OLD
===================================== */

$mysqli->query("

    DELETE FROM enrolled_subjects

    WHERE academic_assignment_id =
    '$academic_assignment_id'

");

/* =====================================
   INSERT NEW
===================================== */

foreach ($students as $student_profile_id) {

    $student_profile_id =
        intval(
            $student_profile_id
        );

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

echo json_encode([

    'success' => 1

]);
