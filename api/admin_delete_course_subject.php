<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

/* =====================================
   DELETE COURSE SUBJECTS
===================================== */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $course_id =
        intval(
            $_POST['course_id'] ?? 0
        );

    if ($course_id <= 0) {

        echo json_encode([

            'success' => 0,

            'message' =>
            'Invalid course.'

        ]);

        exit();
    }

    $stmt =
        $mysqli->prepare("
        DELETE FROM course_subjects
        WHERE course_id = ?
    ");

    $stmt->bind_param(
        "i",
        $course_id
    );

    if ($stmt->execute()) {

        echo json_encode([

            'success' => 1

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
        'Invalid request.'

    ]);
}
