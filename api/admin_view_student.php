<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

/* =====================================
   VIEW STUDENT PROFILE
===================================== */

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $account_id =
        intval(
            $_GET['account_id'] ?? 0
        );

    if ($account_id <= 0) {

        echo json_encode([

            'success' => 0,

            'message' =>
            'Invalid account ID.'

        ]);

        exit();
    }

    $stmt =
        $mysqli->prepare("
        SELECT *
        FROM student_profiles
        WHERE account_id = ?
        LIMIT 1
    ");

    $stmt->bind_param(
        "i",
        $account_id
    );

    $stmt->execute();

    $result =
        $stmt->get_result();

    if ($result->num_rows > 0) {

        $student =
            $result->fetch_assoc();

        echo json_encode([

            'success' => 1,

            'data' => $student

        ]);
    } else {

        echo json_encode([

            'success' => 0,

            'message' =>
            'Student profile not found.'

        ]);
    }
} else {

    echo json_encode([

        'success' => 0,

        'message' =>
        'Invalid request method.'

    ]);
}
