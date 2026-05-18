<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

/* =====================================
   INSERT ACADEMIC ASSIGNMENT
===================================== */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $faculty_profile_id =
        intval(
            $_POST['faculty_profile_id'] ?? 0
        );

    $course_subject_id =
        intval(
            $_POST['course_subject_id'] ?? 0
        );

    $school_year_id =
        intval(
            $_POST['school_year_id'] ?? 0
        );

    /* =====================================
       VALIDATION
    ====================================== */

    if (

        $faculty_profile_id <= 0 ||

        $course_subject_id <= 0 ||

        $school_year_id <= 0

    ) {

        echo json_encode([

            'success' => 0,

            'message' =>
            'Invalid input.'

        ]);

        exit();
    }

    /* =====================================
       GET COURSE + SUBJECT
    ====================================== */

    $courseStmt =
        $mysqli->prepare("

        SELECT

            course_id,
            subject_id

        FROM course_subjects

        WHERE id = ?

        LIMIT 1

    ");

    if (!$courseStmt) {

        echo json_encode([

            'success' => 0,

            'message' =>
            $mysqli->error

        ]);

        exit();
    }

    $courseStmt->bind_param(
        "i",
        $course_subject_id
    );

    $courseStmt->execute();

    $courseResult =
        $courseStmt->get_result();

    if (
        $courseResult->num_rows == 0
    ) {

        echo json_encode([

            'success' => 0,

            'message' =>
            'Course subject not found.'

        ]);

        exit();
    }

    $courseData =
        $courseResult->fetch_assoc();

    $course_id =
        intval(
            $courseData['course_id']
        );

    $subject_id =
        intval(
            $courseData['subject_id']
        );

    /* =====================================
       CHECK DUPLICATE
    ====================================== */

    $check =
        $mysqli->prepare("

        SELECT id

        FROM academic_assignments

        WHERE

            faculty_profile_id = ?

        AND

            school_year_id = ?

        AND

            course_id = ?

        AND

            subject_id = ?

        LIMIT 1

    ");

    if (!$check) {

        echo json_encode([

            'success' => 0,

            'message' =>
            $mysqli->error

        ]);

        exit();
    }

    $check->bind_param(

        "iiii",

        $faculty_profile_id,
        $school_year_id,
        $course_id,
        $subject_id

    );

    $check->execute();

    $checkResult =
        $check->get_result();

    /* =====================================
       ALREADY EXISTS
    ====================================== */

    if (
        $checkResult->num_rows > 0
    ) {

        echo json_encode([

            'success' => 1,

            'message' =>
            'Already assigned.'

        ]);

        exit();
    }

    /* =====================================
       INSERT
    ====================================== */

    $stmt =
        $mysqli->prepare("

        INSERT INTO academic_assignments(

            course_id,
            subject_id,
            faculty_profile_id,
            school_year_id

        )

        VALUES(

            ?, ?, ?, ?

        )

    ");

    if (!$stmt) {

        echo json_encode([

            'success' => 0,

            'message' =>
            $mysqli->error

        ]);

        exit();
    }

    $stmt->bind_param(

        "iiii",

        $course_id,
        $subject_id,
        $faculty_profile_id,
        $school_year_id

    );

    if ($stmt->execute()) {

        echo json_encode([

            'success' => 1,

            'message' =>
            'Assignment inserted successfully.'

        ]);
    } else {

        echo json_encode([

            'success' => 0,

            'message' =>
            $stmt->error

        ]);
    }

    $stmt->close();

    $check->close();

    $courseStmt->close();
} else {

    echo json_encode([

        'success' => 0,

        'message' =>
        'Invalid request method.'

    ]);
}
