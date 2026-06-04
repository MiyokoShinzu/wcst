<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

/* =========================================
   GET ALL ACCOUNTS
========================================= */

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $sql = "
        SELECT
            id,
            username,
            email,
            role,
            status,
            date_created
        FROM accounts
        WHERE archived = 0 and role = 'student'
        ORDER BY id DESC
    ";

    $result =
        $mysqli->query($sql);

    $data = [];

    while (
        $row =
        $result->fetch_assoc()
    ) {

        $data[] = $row;
    }

    echo json_encode([

        'status' => true,

        'data' => $data

    ]);
}
