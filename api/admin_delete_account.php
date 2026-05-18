<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

/* =====================================
   DELETE / ARCHIVE ACCOUNT
===================================== */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id =
        intval(
            $_POST['id']
        );

    $stmt =
        $mysqli->prepare("
        UPDATE accounts
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

            'success' => '1',

            'message' =>
            'Account archived successfully.'

        ]);
    } else {

        echo json_encode([

            'success' => '0',

            'message' =>
            'Failed to archive account.'

        ]);
    }
} else {

    echo json_encode([

        'success' => '0',

        'message' =>
        'Invalid request.'

    ]);
}
