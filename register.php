<?php

require_once "src/connection.php";

global $mysqli;

$message = "";

/* REGISTER PROCESS */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username =
        trim($_POST['username']);

    $email =
        trim($_POST['email']);

    $password =
        trim($_POST['password']);

    $role =
        trim($_POST['role']);

    /* VALIDATION */

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

        /* CHECK EXISTING USER */

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

            /* HASH PASSWORD */

            $hashedPassword =
                password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

            /* INSERT ACCOUNT */

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
                    date_archived
                )
                VALUES
                (
                    ?, ?, ?, ?, NOW(), 0, NULL
                )
            ");

            $stmt->bind_param(
                "ssss",
                $username,
                $hashedPassword,
                $email,
                $role
            );

            if ($stmt->execute()) {

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

            background:
                linear-gradient(135deg,
                    #064e3b,
                    #047857,
                    #10b981);

            position: relative;
        }

        /* ========================================
           BACKGROUND SHAPES
        ======================================== */

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

        /* ========================================
           REGISTER WRAPPER
        ======================================== */

        .register-wrapper {

            width: 100%;

            max-width: 520px;

            padding: 20px;

            position: relative;

            z-index: 2;
        }

        /* ========================================
           REGISTER CARD
        ======================================== */

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

        .register-card::before {

            content: '';

            position: absolute;

            width: 260px;

            height: 260px;

            border-radius: 50%;

            background:
                rgba(255, 255, 255, 0.05);

            top: -120px;

            right: -120px;
        }

        /* ========================================
           LOGO
        ======================================== */

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

        /* ========================================
           TITLES
        ======================================== */

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

        /* ========================================
           ALERTS
        ======================================== */

        .alert {

            border: none;

            border-radius: 18px;

            font-size: 0.92rem;

            margin-bottom: 25px;
        }

        /* ========================================
           INPUTS
        ======================================== */

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

            transition: 0.3s ease;
        }

        .input-group:focus-within {

            border-color:
                rgba(255, 255, 255, 0.35);

            box-shadow:
                0 0 0 4px rgba(255, 255, 255, 0.06);
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

            font-size: 0.95rem;

            box-shadow: none !important;
        }

        .form-control::placeholder {

            color:
                rgba(255, 255, 255, 0.55);
        }

        .form-select option {

            color: black;
        }

        /* ========================================
           PASSWORD TOGGLE
        ======================================== */

        .password-group {

            position: relative;
        }

        .password-toggle {

            width: 55px;

            border: none;

            background: transparent;

            color:
                rgba(255, 255, 255, 0.75);

            transition: 0.3s ease;
        }

        .password-toggle:hover {

            color: white;

            transform: scale(1.05);
        }

        /* ========================================
           NOTES
        ======================================== */

        .password-note {

            margin-top: -8px;

            margin-bottom: 20px;

            font-size: 0.82rem;

            color:
                rgba(255, 255, 255, 0.70);

            display: flex;

            align-items: center;

            gap: 8px;
        }

        .password-note i {

            color: #6ee7b7;
        }

        /* ========================================
           BUTTON
        ======================================== */

        .btn-register {

            width: 100%;

            border: none;

            border-radius: 18px;

            padding: 15px;

            background: white;

            color: #10b981;

            font-weight: 700;

            font-size: 1rem;

            transition: 0.35s ease;
        }

        .btn-register:hover {

            transform: translateY(-4px);

            box-shadow:
                0 18px 40px rgba(16, 185, 129, 0.28);
        }

        /* ========================================
           EXTRA LINKS
        ======================================== */

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

        /* ========================================
           FOOTER
        ======================================== */

        .register-footer {

            text-align: center;

            margin-top: 30px;

            font-size: 0.82rem;

            color:
                rgba(255, 255, 255, 0.60);
        }

        /* ========================================
           RESPONSIVE
        ======================================== */

        @media(max-width:768px) {

            body {

                overflow: auto;

                padding: 20px;
            }

            .register-card {

                padding: 40px 25px;
            }

            .register-title {

                font-size: 1.8rem;
            }

            .logo-wrapper img {

                width: 95px;

                height: 95px;
            }
        }
    </style>

</head>

<body>

    <!-- BACKGROUND -->
    <div class="bg-shape shape1"></div>
    <div class="bg-shape shape2"></div>
    <div class="bg-shape shape3"></div>

    <!-- REGISTER -->
    <div class="register-wrapper">

        <div class="register-card">

            <!-- LOGO -->
            <div class="logo-wrapper">

                <img
                    src="./assets/logo.jpg"
                    alt="WCST Logo">

            </div>

            <!-- TITLE -->
            <h1 class="register-title">

                Create Account

            </h1>

            <p class="register-subtitle">

                Worldstar College of Science
                and Technology Inc.<br>

                Secure Registration Portal

            </p>

            <!-- MESSAGE -->
            <?php echo $message; ?>

            <!-- FORM -->
            <form method="POST">

                <!-- USERNAME -->
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

                <!-- EMAIL -->
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

                <!-- PASSWORD -->
                <label class="form-label">

                    Password

                </label>

                <div class="input-group password-group">

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

                    <!-- TOGGLE -->
                    <button
                        type="button"
                        class="password-toggle"
                        onclick="togglePassword()">

                        <i
                            class="bi bi-eye-fill"
                            id="toggleIcon"></i>

                    </button>

                </div>

                <!-- NOTE -->
                <div class="password-note">

                    <i class="bi bi-shield-lock-fill"></i>

                    Username: minimum 5 characters |
                    Password: minimum 4 characters

                </div>

                <!-- ROLE -->
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

                        <option value="faculty">

                            Faculty

                        </option>

                    </select>

                </div>

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="btn btn-register">

                    Create Account

                </button>

            </form>

            <!-- LOGIN -->
            <div class="extra-links">

                Already have an account?

                <a href="login.php">

                    Login Here

                </a>

            </div>

            <!-- FOOTER -->
            <div class="register-footer">

                © 2025 WCST. All Rights Reserved.

            </div>

        </div>

    </div>

    <!-- BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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