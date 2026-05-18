<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id =
        intval($_POST['id']);

    $subject_code =
        trim($_POST['subject_code']);

    $subject_name =
        trim($_POST['subject_name']);

    $year_level =
        trim($_POST['year_level']);

    $semester =
        trim($_POST['semester']);

    $units =
        floatval($_POST['units']);

    $description =
        trim($_POST['description']);

    $stmt =
        $mysqli->prepare("
        UPDATE subjects
        SET

            subject_code = ?,
            subject_name = ?,
            year_level = ?,
            semester = ?,
            units = ?,
            description = ?

        WHERE id = ?
    ");

    $stmt->bind_param(

        "ssssdsi",

        $subject_code,
        $subject_name,
        $year_level,
        $semester,
        $units,
        $description,
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
