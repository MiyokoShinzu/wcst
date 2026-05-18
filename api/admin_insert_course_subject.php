<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

/* =====================================
   INSERT COURSE SUBJECT
===================================== */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $course_id =
        intval(
            $_POST['course_id'] ?? 0
        );

    $subject_id =
        intval(
            $_POST['subject_id'] ?? 0
        );

    /* =====================================
       VALIDATION
    ====================================== */

    if (

        $course_id <= 0 ||

        $subject_id <= 0

    ) {

        echo json_encode([

            'success' => 0,

            'message' =>
            'Invalid data.'

        ]);

        exit();
    }

    /* =====================================
       CHECK DUPLICATE
    ====================================== */

    $check =
        $mysqli->prepare("
        SELECT id
        FROM course_subjects
        WHERE

            course_id = ?

        AND

            subject_id = ?

        AND

            archived = 0

        LIMIT 1
    ");

    $check->bind_param(

        "ii",

        $course_id,
        $subject_id
    );

    $check->execute();

    $result =
        $check->get_result();

    if ($result->num_rows > 0) {

        echo json_encode([

            'success' => 0,

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
        INSERT INTO course_subjects(

            course_id,
            subject_id

        )

        VALUES(

            ?, ?
        )
    ");

    $stmt->bind_param(

        "ii",

        $course_id,
        $subject_id
    );

    if ($stmt->execute()) {

        echo json_encode([

            'success' => 1,

            'message' =>
            'Assigned successfully.'

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
