<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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

    if (

        $subject_code == '' ||

        $subject_name == ''

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
        INSERT INTO subjects(

            subject_code,
            subject_name,
            year_level,
            semester,
            units,
            description

        )

        VALUES(

            ?, ?, ?, ?, ?, ?
        )
    ");

    $stmt->bind_param(

        "ssssds",

        $subject_code,
        $subject_name,
        $year_level,
        $semester,
        $units,
        $description
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
