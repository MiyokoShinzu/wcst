<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

/* =====================================
   UPDATE COURSE
===================================== */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id =
        intval(
            $_POST['id'] ?? 0
        );

    $course_name =
        trim(
            $_POST['course_name'] ?? ''
        );

    $course_code =
        trim(
            $_POST['course_code'] ?? ''
        );

    $program_type =
        trim(
            $_POST['program_type'] ?? ''
        );

    $duration_years =
        intval(
            $_POST['duration_years'] ?? 1
        );

    $strand =
        trim(
            $_POST['strand'] ?? ''
        );

    /* =====================================
       VALIDATION
    ====================================== */

    if (

        $id <= 0 ||

        empty($course_name) ||

        empty($course_code) ||

        empty($program_type)

    ) {

        echo json_encode([

            'success' => 0,

            'message' =>
            'All fields are required.'

        ]);

        exit();
    }

    /* =====================================
       CHECK DUPLICATE
    ====================================== */

    $check =
        $mysqli->prepare("
        SELECT id
        FROM courses
        WHERE course_code = ?
        AND id != ?
        LIMIT 1
    ");

    $check->bind_param(
        "si",
        $course_code,
        $id
    );

    $check->execute();

    $result =
        $check->get_result();

    if ($result->num_rows > 0) {

        echo json_encode([

            'success' => 0,

            'message' =>
            'Course code already exists.'

        ]);

        exit();
    }

    /* =====================================
       UPDATE
    ====================================== */

    $stmt =
        $mysqli->prepare("
        UPDATE courses
        SET

            course_name = ?,
            course_code = ?,
            program_type = ?,
            duration_years = ?,
            strand = ?

        WHERE id = ?
    ");

    $stmt->bind_param(

        "sssisi",

        $course_name,
        $course_code,
        $program_type,
        $duration_years,
        $strand,
        $id
    );

    if ($stmt->execute()) {

        echo json_encode([

            'success' => 1,

            'message' =>
            'Course updated successfully.'

        ]);
    } else {

        echo json_encode([

            'success' => 0,

            'message' =>
            $stmt->error

        ]);
    }
} else {

    echo json_encode([

        'success' => 0,

        'message' =>
        'Invalid request method.'

    ]);
}
