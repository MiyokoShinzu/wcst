<?php

header(
    "Content-Type: application/json"
);

include '../src/connection.php';

global $mysqli;

/* =====================================
   INSERT ACCOUNT
===================================== */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username =
        trim(
            $_POST['username'] ?? ''
        );

    $email =
        trim(
            $_POST['email'] ?? ''
        );

    $password =
        trim(
            $_POST['password'] ?? ''
        );

    $role =
        trim(
            $_POST['role'] ?? ''
        );

    $status =
        intval(
            $_POST['status'] ?? 0
        );

    /* =====================================
       VALIDATION
    ====================================== */

    if (

        empty($username) ||

        empty($email) ||

        empty($password)

    ) {

        echo json_encode([

            'success' => 0,

            'message' =>
            'All fields are required.'

        ]);

        exit();
    } elseif (strlen($username) < 5) {

        echo json_encode([

            'success' => 0,

            'message' =>
            'Username must be at least 5 characters.'

        ]);

        exit();
    } elseif (strlen($password) < 4) {

        echo json_encode([

            'success' => 0,

            'message' =>
            'Password must be at least 4 characters.'

        ]);

        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        echo json_encode([

            'success' => 0,

            'message' =>
            'Invalid email address.'

        ]);

        exit();
    }

    /* =====================================
       CHECK EXISTING USER
    ====================================== */

    $checkStmt =
        $mysqli->prepare("
            SELECT id
            FROM accounts
            WHERE username = ?
            OR email = ?
            LIMIT 1
        ");

    if (!$checkStmt) {

        echo json_encode([

            'success' => 0,

            'message' =>
            $mysqli->error

        ]);

        exit();
    }

    $checkStmt->bind_param(
        "ss",
        $username,
        $email
    );

    $checkStmt->execute();

    $result =
        $checkStmt->get_result();

    if ($result->num_rows > 0) {

        echo json_encode([

            'success' => 0,

            'message' =>
            'Username or Email already exists.'

        ]);

        exit();
    }

    /* =====================================
       HASH PASSWORD
    ====================================== */

    $hashedPassword =
        password_hash(
            $password,
            PASSWORD_DEFAULT
        );

    /* =====================================
       INSERT ACCOUNT
    ====================================== */

    $stmt =
        $mysqli->prepare("
            INSERT INTO accounts
            (
                username,
                password,
                email,
                role,
                date_created,
                archived,
                date_archived,
                status
            )
            VALUES
            (
                ?, ?, ?, ?, NOW(), 0, NULL, ?
            )
        ");

    if (!$stmt) {

        echo json_encode([

            'success' => 0,

            'message' =>
            $mysqli->error

        ]);

        exit();
    }

    $stmt->bind_param(
        "ssssi",
        $username,
        $hashedPassword,
        $email,
        $role,
        $status
    );

    /* =====================================
       EXECUTE
    ====================================== */

    if ($stmt->execute()) {

        /* =====================================
           GET INSERTED ACCOUNT ID
        ====================================== */

        $account_id =
            $mysqli->insert_id;

        /* =====================================
           CREATE STUDENT PROFILE
        ====================================== */

        if ($role == 'student') {

            $studentStmt =
                $mysqli->prepare("
                    INSERT INTO student_profiles(

                        account_id

                    )

                    VALUES(

                        ?
                    )
                ");

            if ($studentStmt) {

                $studentStmt->bind_param(
                    "i",
                    $account_id
                );

                $studentStmt->execute();

                $studentStmt->close();
            }
        }

        /* =====================================
           CREATE FACULTY PROFILE
        ====================================== */

        if ($role == 'faculty') {

            $facultyStmt =
                $mysqli->prepare("
                    INSERT INTO faculty_profiles(

                        account_id, firstname, middlename, lastname

                    )

                    VALUES(

                        ?, ?, ?, ?
                    )
                ");
            $firstname = "N/A";
            $middlename = "N/A";
            $lastname = "N/A";

            if ($facultyStmt) {

                $facultyStmt->bind_param(
                    "isss",
                    $account_id,
                    $firstname,
                    $middlename,
                    $lastname

                );

                $facultyStmt->execute();

                $facultyStmt->close();
            }
        }

        echo json_encode([

            'success' => 1,

            'message' =>
            'Account added successfully.'

        ]);
    } else {

        echo json_encode([

            'success' => 0,

            'message' =>
            'Failed to add account.'

        ]);
    }

    $stmt->close();

    $checkStmt->close();
} else {

    echo json_encode([

        'success' => 0,

        'message' =>
        'Invalid request method.'

    ]);
}
