<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

/* =====================================
   INSERT SCHOOL YEAR
===================================== */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $school_year =
        trim(
            $_POST['school_year'] ?? ''
        );

    $semester =
        trim(
            $_POST['semester'] ?? ''
        );

    $is_active =
        intval(
            $_POST['is_active'] ?? 0
        );

    /* =====================================
       VALIDATION
    ====================================== */

    if (

        empty($school_year) ||

        empty($semester)

    ) {

        echo json_encode([

            'success' => 0,

            'message' =>
            'All fields are required.'

        ]);

        exit();
    }

    /* =====================================
       CHECK DUPLICATE
    ====================================== */

    $check =
        $mysqli->prepare("
        SELECT id
        FROM school_years
        WHERE school_year = ?
        AND semester = ?
        LIMIT 1
    ");

    $check->bind_param(
        "ss",
        $school_year,
        $semester
    );

    $check->execute();

    $result =
        $check->get_result();

    if ($result->num_rows > 0) {

        echo json_encode([

            'success' => 0,

            'message' =>
            'School year already exists.'

        ]);

        exit();
    }

    /* =====================================
       ONLY ONE ACTIVE SCHOOL YEAR
    ====================================== */

    if ($is_active == 1) {

        $mysqli->query("
            UPDATE school_years
            SET is_active = 0
        ");
    }

    /* =====================================
       INSERT
    ====================================== */

    $stmt =
        $mysqli->prepare("
        INSERT INTO school_years(

            school_year,
            semester,
            is_active

        )

        VALUES(

            ?, ?, ?
        )
    ");

    $stmt->bind_param(

        "ssi",

        $school_year,
        $semester,
        $is_active
    );

    if ($stmt->execute()) {

        echo json_encode([

            'success' => 1,

            'message' =>
            'School year added successfully.'

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
