<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

/* =====================================
   INPUT
===================================== */

$grades =
    json_decode(

        $_POST['grades'] ?? '[]',

        true

    );

/* =====================================
   VALIDATION
===================================== */

if (

    !is_array($grades)

) {

    echo json_encode([

        'success' => 0,

        'message' => 'Invalid grades data.'

    ]);

    exit;
}

/* =====================================
   SAVE GRADES
===================================== */

foreach ($grades as $gradeData) {

    $enrollment_id =
        intval(
            $gradeData['enrollment_id']
        );

    $grade =
        trim(
            $gradeData['grade']
        );

    /* =====================================
       EMPTY GRADE
    ===================================== */

    if ($grade === '') {

        $stmt =
            $mysqli->prepare("

            UPDATE enrolled_subjects

            SET

                grade = NULL,

                grade_updated = NOW()

            WHERE id = ?

        ");

        $stmt->bind_param(

            "i",

            $enrollment_id

        );

        $stmt->execute();

        continue;
    }

    /* =====================================
       UPDATE GRADE
    ===================================== */

    $stmt =
        $mysqli->prepare("

        UPDATE enrolled_subjects

        SET

            grade = ?,

            grade_updated = NOW()

        WHERE id = ?

    ");

    $stmt->bind_param(

        "di",

        $grade,
        $enrollment_id

    );

    $stmt->execute();
}

/* =====================================
   RESPONSE
===================================== */

echo json_encode([

    'success' => 1

]);
