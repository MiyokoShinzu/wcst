<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

/* =====================================
   DELETE COURSE
===================================== */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id =
        intval(
            $_POST['id'] ?? 0
        );

    if ($id <= 0) {

        echo json_encode([

            'success' => 0,

            'message' =>
            'Invalid course ID.'

        ]);

        exit();
    }

    $stmt =
        $mysqli->prepare("
        UPDATE courses
        SET

            archived = 1,
            date_archived = NOW()

        WHERE id = ?
    ");

    $stmt->bind_param(
        "i",
        $id
    );

    if ($stmt->execute()) {

        echo json_encode([

            'success' => 1,

            'message' =>
            'Course archived successfully.'

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
