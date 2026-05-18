<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

/* =====================================
   SELECT STUDENTS WITH ACCOUNTS
===================================== */

$data = [];

$sql = "
SELECT

    student_profiles.*,

    accounts.username,
    accounts.email,
    accounts.role,
    accounts.status AS account_status

FROM student_profiles

LEFT JOIN accounts

ON student_profiles.account_id = accounts.id

WHERE

    student_profiles.archived = 0

AND

    accounts.role = 'student'

ORDER BY student_profiles.id DESC
";

$result =
    $mysqli->query($sql);

while (
    $row =
    $result->fetch_assoc()
) {

    $data[] = $row;
}

echo json_encode([

    'data' => $data

]);
