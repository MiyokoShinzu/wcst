<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id =
        intval(
            $_POST['id'] ?? 0
        );

    $username =
        trim(
            $_POST['username'] ?? ''
        );

    $email =
        trim(
            $_POST['email'] ?? ''
        );

    $role =
        trim(
            $_POST['role'] ?? ''
        );

    $status =
        intval(
            $_POST['status'] ?? 0
        );

    if (

        $id <= 0 ||

        $username == '' ||

        $email == ''

    ) {

        echo json_encode([

            'success' => 0,

            'message' =>
            'All fields are required.'

        ]);

        exit();
    }

    $stmt =
        $mysqli->prepare("
        UPDATE accounts
        SET

            username = ?,
            email = ?,
            role = ?,
            status = ?

        WHERE id = ?
    ");

    $stmt->bind_param(

        "sssii",

        $username,
        $email,
        $role,
        $status,
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
