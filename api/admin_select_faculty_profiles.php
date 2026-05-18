<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

/* =====================================
   SELECT FACULTY PROFILES
===================================== */

$data = [];

$stmt =
    $mysqli->prepare("

    SELECT

        faculty_profiles.id,

        faculty_profiles.firstname,
        faculty_profiles.middlename,
        faculty_profiles.lastname,

        accounts.username,
        accounts.email

    FROM faculty_profiles

    INNER JOIN accounts

        ON accounts.id =
        faculty_profiles.account_id

    WHERE

        accounts.archived = 0

    ORDER BY

        faculty_profiles.lastname ASC

");

$stmt->execute();

$result =
    $stmt->get_result();

while (
    $row =
    $result->fetch_assoc()
) {

    $full_name = trim(

        $row['firstname']

            . ' ' .

            $row['middlename']

            . ' ' .

            $row['lastname']

    );

    $row['full_name'] =
        preg_replace(
            '/\s+/',
            ' ',
            $full_name
        );

    $data[] = $row;
}

echo json_encode([

    'data' => $data

]);
