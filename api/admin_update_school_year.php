<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

/* =====================================
   UPDATE SCHOOL YEAR
===================================== */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id =
        intval(
            $_POST['id'] ?? 0
        );

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

        $id <= 0 ||

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
        AND id != ?
        LIMIT 1
    ");

    $check->bind_param(
        "ssi",
        $school_year,
        $semester,
        $id
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
       UPDATE
    ====================================== */

    $stmt =
        $mysqli->prepare("
        UPDATE school_years
        SET

            school_year = ?,
            semester = ?,
            is_active = ?

        WHERE id = ?
    ");

    $stmt->bind_param(

        "ssii",

        $school_year,
        $semester,
        $is_active,
        $id
    );

    if ($stmt->execute()) {

        echo json_encode([

            'success' => 1,

            'message' =>
            'School year updated successfully.'

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
