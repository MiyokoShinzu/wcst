<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

/* =====================================
   INSERT COURSE
===================================== */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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
        LIMIT 1
    ");

    $check->bind_param(
        "s",
        $course_code
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
       INSERT
    ====================================== */

    $stmt =
        $mysqli->prepare("
        INSERT INTO courses(

            course_name,
            course_code,
            program_type,
            duration_years,
            strand

        )

        VALUES(

            ?, ?, ?, ?, ?
        )
    ");

    $stmt->bind_param(

        "sssis",

        $course_name,
        $course_code,
        $program_type,
        $duration_years,
        $strand
    );

    if ($stmt->execute()) {

        echo json_encode([

            'success' => 1,

            'message' =>
            'Course added successfully.'

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
