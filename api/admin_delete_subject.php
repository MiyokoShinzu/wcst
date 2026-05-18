<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id =
        intval($_POST['id']);

    $stmt =
        $mysqli->prepare("
        UPDATE subjects
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

            'success' => 1

        ]);
    } else {

        echo json_encode([

            'success' => 0,

            'message' =>
            $stmt->error

        ]);
    }
}
