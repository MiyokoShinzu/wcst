<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

/* =====================================
   SELECT FACULTY
===================================== */

$data = [];

$sql = "
SELECT

    faculty_profiles.*,

    accounts.username,
    accounts.email,
    accounts.role,
    accounts.status AS account_status

FROM faculty_profiles

LEFT JOIN accounts

ON faculty_profiles.account_id = accounts.id

WHERE

    faculty_profiles.archived = 0

AND

    accounts.role = 'faculty'

ORDER BY faculty_profiles.id DESC
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
