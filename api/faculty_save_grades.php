<?php

header("Content-Type: application/json");

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

if (!is_array($grades)) {

    echo json_encode([

        'success' => 0,

        'message' => 'Invalid grades data.'

    ]);

    exit;
}

/* =====================================
   SAVE
===================================== */

foreach ($grades as $gradeData) {

    $enrollment_id =
        intval(
            $gradeData['enrollment_id']
        );

    $prelim =
        ($gradeData['prelim'] === '')
        ? null
        : floatval($gradeData['prelim']);

    $midterm =
        ($gradeData['midterm'] === '')
        ? null
        : floatval($gradeData['midterm']);

    $prefinal =
        ($gradeData['prefinal'] === '')
        ? null
        : floatval($gradeData['prefinal']);

    $final =
        ($gradeData['final'] === '')
        ? null
        : floatval($gradeData['final']);

    $average = null;

    $remarks = null;

    if (

        $prelim !== null &&

        $midterm !== null &&

        $prefinal !== null &&

        $final !== null

    ) {

        $average = round(

            (

                $prelim +

                $midterm +

                $prefinal +

                $final

            ) / 4,

            2

        );

        $remarks =
            ($average >= 75)
            ? 'PASSED'
            : 'FAILED';
    }

    $stmt =
        $mysqli->prepare("

            UPDATE enrolled_subjects

            SET

                prelim = ?,

                midterm = ?,

                prefinal = ?,

                final = ?,

                average = ?,

                remarks = ?,

                grade_updated = NOW()

            WHERE id = ?

        ");

    $stmt->bind_param(

        "ddddssi",

        $prelim,

        $midterm,

        $prefinal,

        $final,

        $average,

        $remarks,

        $enrollment_id

    );

    $stmt->execute();
}

echo json_encode([

    'success' => 1

]);
