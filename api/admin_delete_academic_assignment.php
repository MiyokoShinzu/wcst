<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

/* =====================================
   DELETE ASSIGNMENT
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

            'success' => 0

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
       DELETE
    ====================================== */

    $stmt =
        $mysqli->prepare("

        DELETE FROM academic_assignments

        WHERE

            faculty_profile_id = ?

        AND

            school_year_id = ?

        AND

            course_id = ?

        AND

            subject_id = ?

    ");

    $stmt->bind_param(

        "iiii",

        $faculty_profile_id,
        $school_year_id,
        $course_id,
        $subject_id

    );

    if ($stmt->execute()) {

        echo json_encode([

            'success' => 1,

            'message' =>
            'Assignment removed.'

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

        'success' => 0

    ]);
}
