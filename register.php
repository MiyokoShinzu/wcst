<?php

require_once "src/connection.php";

global $mysqli;

$message = "";

/* =====================================
   REGISTER PROCESS
===================================== */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username =
        trim($_POST['username']);

    $email =
        trim($_POST['email']);

    $password =
        trim($_POST['password']);

    $role =
        trim($_POST['role']);

    /* =====================================
       VALIDATION
    ====================================== */

    if (
        empty($username) ||
        empty($email) ||
        empty($password)
    ) {

        $message = "
        <div class='alert alert-danger'>

            <i class='bi bi-exclamation-circle-fill'></i>

            All fields are required.

        </div>
        ";
    } elseif (strlen($username) < 5) {

        $message = "
        <div class='alert alert-warning'>

            <i class='bi bi-person-fill-exclamation'></i>

            Username must be at least 5 characters.

        </div>
        ";
    } elseif (strlen($password) < 4) {

        $message = "
        <div class='alert alert-warning'>

            <i class='bi bi-shield-lock-fill'></i>

            Password must be at least 4 characters.

        </div>
        ";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "
        <div class='alert alert-warning'>

            <i class='bi bi-envelope-x-fill'></i>

            Invalid email address.

        </div>
        ";
    } else {

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

        $checkStmt->bind_param(
            "ss",
            $username,
            $email
        );

        $checkStmt->execute();

        $result =
            $checkStmt->get_result();

        if ($result->num_rows > 0) {

            $message = "
            <div class='alert alert-warning'>

                <i class='bi bi-exclamation-triangle-fill'></i>

                Username or Email already exists.

            </div>
            ";
        } else {

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
                    ?, ?, ?, ?, NOW(), 0, NULL, 0
                )
            ");

            $stmt->bind_param(
                "ssss",
                $username,
                $hashedPassword,
                $email,
                $role
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

                                account_id

                            )

                            VALUES(

                                ?
                            )
                        ");

                    if ($facultyStmt) {

                        $facultyStmt->bind_param(
                            "i",
                            $account_id
                        );

                        $facultyStmt->execute();

                        $facultyStmt->close();
                    }
                }

                $message = "
                <div class='alert alert-success'>

                    <i class='bi bi-check-circle-fill'></i>

                    Registration successful.

                </div>
                ";
            } else {

                $message = "
                <div class='alert alert-danger'>

                    <i class='bi bi-x-circle-fill'></i>

                    Registration failed.

                </div>
                ";
            }

            $stmt->close();
        }

        $checkStmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        Register - Worldstar College of Science and Technology
    </title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
        rel="stylesheet">

    <!-- Google Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link
        rel="icon"
        href="./assets/logo.jpg">

    <style>
        * {

            margin: 0;

            padding: 0;

            box-sizing: border-box;
        }

        body {

            font-family: 'Poppins', sans-serif;

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            overflow-x: hidden;

            /* background:
                linear-gradient(135deg,
                    #064e3b,
                    #047857,
                    #10b981); */
            background:
                linear-gradient(135deg,
                    #c7e314,
                    #b4e308,
                    #cc9108);
            position: relative;
        }

        .bg-shape {

            position: absolute;

            border-radius: 50%;

            background:
                rgba(255, 255, 255, 0.06);

            backdrop-filter: blur(10px);
        }

        .shape1 {

            width: 350px;

            height: 350px;

            top: -120px;

            left: -120px;
        }

        .shape2 {

            width: 250px;

            height: 250px;

            bottom: -100px;

            right: -100px;
        }

        .shape3 {

            width: 180px;

            height: 180px;

            top: 50%;

            left: 8%;

            transform: translateY(-50%);
        }

        .register-wrapper {

            width: 100%;

            max-width: 520px;

            padding: 20px;

            position: relative;

            z-index: 2;
        }

        .register-card {

            background:
                rgba(255, 255, 255, 0.12);

            border:
                1px solid rgba(255, 255, 255, 0.18);

            backdrop-filter: blur(22px);

            border-radius: 32px;

            padding: 50px 40px;

            box-shadow:
                0 25px 60px rgba(0, 0, 0, 0.25);

            overflow: hidden;

            position: relative;

            color: white;
        }

        .logo-wrapper {

            text-align: center;

            margin-bottom: 25px;
        }

        .logo-wrapper img {

            width: 110px;

            height: 110px;

            border-radius: 50%;

            object-fit: cover;

            border:
                5px solid rgba(255, 255, 255, 0.20);

            box-shadow:
                0 12px 35px rgba(0, 0, 0, 0.20);
        }

        .register-title {

            text-align: center;

            font-size: 2.1rem;

            font-weight: 800;

            margin-bottom: 10px;
        }

        .register-subtitle {

            text-align: center;

            font-size: 0.95rem;

            color:
                rgba(255, 255, 255, 0.78);

            margin-bottom: 35px;

            line-height: 1.7;
        }

        .alert {

            border: none;

            border-radius: 18px;

            font-size: 0.92rem;

            margin-bottom: 25px;
        }

        .form-label {

            font-weight: 600;

            margin-bottom: 10px;
        }

        .input-group {

            background:
                rgba(255, 255, 255, 0.10);

            border:
                1px solid rgba(255, 255, 255, 0.15);

            border-radius: 18px;

            overflow: hidden;

            margin-bottom: 22px;
        }

        .input-group-text {

            background: transparent;

            border: none;

            color: white;

            padding-left: 18px;
        }

        .form-control,
        .form-select {

            background: transparent;

            border: none;

            color: white;

            padding: 15px;

            box-shadow: none !important;
        }

        .form-control::placeholder {

            color:
                rgba(255, 255, 255, 0.55);
        }

        .form-select option {

            color: black;
        }

        .password-toggle {

            width: 55px;

            border: none;

            background: transparent;

            color:
                rgba(255, 255, 255, 0.75);
        }

        .btn-register {

            width: 100%;

            border: none;

            border-radius: 18px;

            padding: 15px;

            background: white;

            color: #10b981;

            font-weight: 700;

            font-size: 1rem;
        }

        .extra-links {

            text-align: center;

            margin-top: 25px;

            font-size: 0.92rem;

            color:
                rgba(255, 255, 255, 0.78);
        }

        .extra-links a {

            color: white;

            text-decoration: none;

            font-weight: 700;
        }

        .register-footer {

            text-align: center;

            margin-top: 30px;

            font-size: 0.82rem;

            color:
                rgba(255, 255, 255, 0.60);
        }
    </style>

</head>

<body>

    <div class="bg-shape shape1"></div>
    <div class="bg-shape shape2"></div>
    <div class="bg-shape shape3"></div>

    <div class="register-wrapper">

        <div class="register-card">

            <div class="logo-wrapper">

                <img
                    src="./assets/logo.jpg"
                    alt="WCST Logo">

            </div>

            <h1 class="register-title">

                Create Account

            </h1>

            <p class="register-subtitle">

                Worldstar College of Science
                and Technology Inc.

            </p>

            <?php echo $message; ?>

            <form method="POST">
                <label class="form-label">

                    Account Role

                </label>
                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-person-badge-fill"></i>

                    </span>

                    <select
                        name="role"
                        class="form-select"
                        required>

                        <option value="student">

                            Student

                        </option>


                    </select>

                </div>


                <label class="form-label">

                    Username

                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-person-fill"></i>

                    </span>

                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        placeholder="Enter username"
                        required>

                </div>

                <label class="form-label">

                    Email Address

                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-envelope-fill"></i>

                    </span>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="Enter email address"
                        required>

                </div>

                <label class="form-label">

                    Password

                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-lock-fill"></i>

                    </span>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="Enter password"
                        required>

                    <button
                        type="button"
                        class="password-toggle"
                        onclick="togglePassword()">

                        <i
                            class="bi bi-eye-fill"
                            id="toggleIcon"></i>

                    </button>

                </div>



                <button
                    type="submit"
                    class="btn btn-register">

                    Create Account

                </button>

            </form>

            <div class="extra-links">

                Already have an account?

                <a href="login.php">

                    Login Here

                </a>

            </div>

            <div class="register-footer">

                © 2025 WCST. All Rights Reserved.

            </div>

        </div>

    </div>

    <script>
        function togglePassword() {

            const password =
                document.getElementById(
                    'password'
                );

            const icon =
                document.getElementById(
                    'toggleIcon'
                );

            if (password.type === 'password') {

                password.type = 'text';

                icon.classList.remove(
                    'bi-eye-fill'
                );

                icon.classList.add(
                    'bi-eye-slash-fill'
                );

            } else {

                password.type = 'password';

                icon.classList.remove(
                    'bi-eye-slash-fill'
                );

                icon.classList.add(
                    'bi-eye-fill'
                );
            }
        }
    </script>

</body>

</html>