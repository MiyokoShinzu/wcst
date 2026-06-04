<?php

header(
    "Content-Type: application/json"
);

include "../src/connection.php";

global $mysqli;

$account_id =
    intval(
        $_POST['account_id'] ?? 0
    );

$stmt =
    $mysqli->prepare("

        UPDATE accounts

        SET status = 1

        WHERE id = ?

    ");

$stmt->bind_param(

    "i",

    $account_id

);

if (

    $stmt->execute()

) {

    echo json_encode([

        'success' => 1

    ]);
} else {

    echo json_encode([

        'success' => 0,

        'message' =>
        'Unable to approve account.'

    ]);
}
