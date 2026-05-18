<?php

session_start();

require_once "src/connection.php";

global $mysqli;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username =
        trim($_POST['email']);

    $password =
        trim($_POST['password']);

    if (
        empty($username) ||
        empty($password)
    ) {

        $error =
            "Please fill all fields.";
    } else {

        $stmt =
            $mysqli->prepare("
            SELECT
                id,
                username,
                password,
                role,
                archived
            FROM accounts
            WHERE username = ?
            LIMIT 1
        ");

        $stmt->bind_param(
            "s",
            $username
        );

        $stmt->execute();

        $result =
            $stmt->get_result();

        if ($result->num_rows > 0) {

            $user =
                $result->fetch_assoc();



            if ($user['archived'] == 1) {

                $error =
                    "Account archived.";
            } else {

            

                if (
                    password_verify(
                        $password,
                        $user['password']
                    )
                ) {

                  

                    $_SESSION['user_id'] =
                        $user['id'];

                    $_SESSION['username'] =
                        $user['username'];

                    $_SESSION['role'] =
                        $user['role'];

                    session_regenerate_id(true);

            

                    $role =
                        $user['role'];

                    switch ($role) {

                        case 'admin':

                            header(
                                "Location: ./admin"
                            );

                            break;

                        case 'student':

                            header(
                                "Location: ./student"
                            );

                            break;

                        case 'faculty':

                            header(
                                "Location: ./faculty"
                            );

                            break;

                        default:

                            header(
                                "Location: ./dashboard"
                            );

                            break;
                    }

                    exit();

                    
                } else {

                    $error =
                        "Invalid password.";
                }
            }
        } else {

            $error =
                "User not found.";
        }

        $stmt->close();
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
        Login - Worldstar College of Science and Technology
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

            height: auto;

            display: flex;

            align-items: center;

            justify-content: center;

            overflow-x: hidden;

            background:
                linear-gradient(135deg,
                    #031633,
                    #0d47a1,
                    #1565c0);

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
           LOGIN WRAPPER
        ======================================== */

        .login-wrapper {

            width: 100%;

            max-width: 500px;

            padding: 20px;

            position: relative;

            z-index: 2;
        }

        /* ========================================
           LOGIN CARD
        ======================================== */

        .login-card {

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

        .login-card::before {

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

            width: 115px;

            height: 115px;

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

        .login-title {

            text-align: center;

            font-size: 2.2rem;

            font-weight: 800;

            margin-bottom: 10px;
        }

        .login-subtitle {

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

        .form-control {

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

        /* ========================================
           SHOW PASSWORD
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
           SECURITY NOTE
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

            color: #74c0fc;
        }

        /* ========================================
           OPTIONS
        ======================================== */

        .login-options {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 28px;
        }

        .form-check-label {

            font-size: 0.9rem;
        }

        .forgot-link {

            color: white;

            text-decoration: none;

            font-size: 0.9rem;

            font-weight: 600;

            transition: 0.3s ease;
        }

        .forgot-link:hover {

            opacity: 0.8;
        }

        /* ========================================
           BUTTON
        ======================================== */

        .btn-login {

            width: 100%;

            border: none;

            border-radius: 18px;

            padding: 15px;

            background: white;

            color: #0d6efd;

            font-weight: 700;

            font-size: 1rem;

            transition: 0.35s ease;

            position: relative;

            overflow: hidden;
        }

        .btn-login:hover {

            transform: translateY(-4px);

            box-shadow:
                0 18px 40px rgba(255, 255, 255, 0.18);
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

        .login-footer {

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

            .login-card {

                padding: 40px 25px;
            }

            .login-title {

                font-size: 1.8rem;
            }

            .logo-wrapper img {

                width: 95px;

                height: 95px;
            }

            .login-options {

                flex-direction: column;

                gap: 15px;

                align-items: flex-start;
            }
        }
    </style>

</head>

<body>

    <!-- BACKGROUND -->
    <div class="bg-shape shape1"></div>
    <div class="bg-shape shape2"></div>
    <div class="bg-shape shape3"></div>

    <!-- LOGIN -->
    <div class="login-wrapper">

        <div class="login-card">

            <!-- LOGO -->
            <div class="logo-wrapper">

                <img
                    src="./assets/logo.jpg"
                    alt="WCST Logo">

            </div>

            <!-- TITLE -->
            <h1 class="login-title">

                Welcome Back

            </h1>

            <p class="login-subtitle">

                Worldstar College of Science
                and Technology Inc.<br>

                Secure Portal Authentication System

            </p>

            <!-- ERROR -->
            <?php if (isset($error)): ?>

                <div class="alert alert-danger">

                    <i class="bi bi-exclamation-circle-fill"></i>

                    <?php echo $error; ?>

                </div>

            <?php endif; ?>

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
                        class="form-control"
                        name="email"
                        placeholder="Enter your username"
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
                        class="form-control"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required>

                    <!-- SHOW PASSWORD -->
                    <button
                        type="button"
                        class="password-toggle"
                        onclick="togglePassword()">

                        <i
                            class="bi bi-eye-fill"
                            id="toggleIcon"></i>

                    </button>

                </div>

                <!-- SECURITY NOTE -->
                <div class="password-note">

                    <i class="bi bi-shield-lock-fill"></i>

                    Your credentials are securely encrypted.

                </div>

                <!-- OPTIONS -->
                <div class="login-options">

                  

                    

                </div>

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="btn btn-login">

                    Login to Portal

                </button>

            </form>

            <!-- REGISTER -->
            <div class="extra-links">

                Don’t have an account?

                <a href="register.php">

                    Create Account

                </a>

            </div>

            <!-- FOOTER -->
            <div class="login-footer">

                © 2025 WCST. All Rights Reserved.

            </div>

        </div>

    </div>

    <!-- BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        /* SHOW PASSWORD */

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