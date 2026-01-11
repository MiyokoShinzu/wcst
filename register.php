<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Worldstar College</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="./assets/logo.jpg">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            padding: 20px;
        }

        .register-container {
            display: flex;
            flex-wrap: wrap;
            max-width: 800px;
            width: 100%;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            background: #fff;
        }

        /* Left panel */
        .register-left {
            flex: 1 1 40%;
            background: #0972c3;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            position: relative;
            overflow: hidden;
        }

        /* Circular pseudo element decoration */
        .register-left::after {
            content: '';
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.69);
            border-radius: 50%;
        }

        .register-left img {
            max-width: 100px;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .register-left h2 {
            font-weight: 600;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .register-left p {
            text-align: center;
            margin-top: 15px;
            position: relative;
            z-index: 1;
        }

        /* Right panel - form */
        .register-right {
            flex: 1 1 60%;
            background: #ffffff;
            padding: 50px 30px;
        }

        .register-right h2 {
            color: #0d6efd;
            font-weight: 600;
            margin-bottom: 25px;
            text-align: center;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }

        .btn-register {
            background-color: #0d6efd;
            color: #fff;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-register:hover {
            background-color: #0b5ed7;
        }

        .register-right a {
            text-decoration: none;
        }

        .register-right a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
            }

            .register-left {
                flex: 1 1 100%;
                padding: 30px 20px;
            }

            .register-right {
                flex: 1 1 100%;
                padding: 40px 20px;
            }
        }
    </style>
</head>

<body>

    <div class="register-container">
        <!-- Left Accent Panel -->
        <div class="register-left">
            <img src="./assets/logo.jpg" alt="Worldstar College Logo" style="border: 1px solid #fff; background: #fff; padding: 10px; border-radius: 50%;">
            <h2>Welcome to Worldstar College</h2>
            <p>Join us and start your journey towards excellence in education and technology.</p>
        </div>

        <!-- Right Form Panel -->
        <div class="register-right">
            <h2 style="border-bottom: 2px solid #000; padding-bottom: 5px;">Account Registration</h2>
            <form action="register_process.php" method="POST">
                <div class="mb-3 text-start">
                    <label for="fullname" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter your full name" required>
                </div>
                <div class="mb-3 text-start">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3 text-start">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Choose a username" required>
                </div>
                <div class="mb-3 text-start">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="mb-3 text-start">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Re-enter your password" required>
                </div>

                <button type="submit" class="btn btn-register w-100 rounded-pill">Register</button>
            </form>
            <p class="mt-3 text-center">Already have an account?
                <a href="login.php">Login Here</a>
            </p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>