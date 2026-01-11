<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Worldstar College</title>

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
            background: linear-gradient(135deg, #e3f2fd, #ffffff);
            padding: 20px;
        }

        .login-container {
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            padding: 50px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }



        .login-container::after {
            content: '';
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(13, 110, 253, 0.1);
            border-radius: 50%;
        }

        .login-container img {
            max-width: 120px;
            height: auto;
            margin-bottom: 25px;
            position: relative;
            z-index: 1;
        }

        .login-container h2 {
            font-weight: 600;
            margin-bottom: 25px;
            color: #0d6efd;
            position: relative;
            z-index: 1;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }

        .btn-login {
            background-color: #0d6efd;
            color: #fff;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-login:hover {
            background-color: #0b5ed7;
        }

        .login-container a {
            text-decoration: none;
        }

        .login-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <!-- Logo on top -->
        <img src="./assets/logo.jpg" alt="Worldstar College Logo">
        <h2 style="border-bottom: 2px solid #000; padding-bottom: 5px;">Account Login</h2>

        <form action="login_process.php" method="POST">
            <div class="mb-3 text-start">
                <label for="email" class="form-label">Username</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter your username" required>
            </div>
            <div class="mb-3 text-start">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>  
                <a href="forgot_password.html">Forgot Password?</a>
            </div>
            <button type="submit" class="btn btn-login w-100 rounded-pill">Login</button>
        </form>

        <p class="mt-3">Don't have an account?
            <a href="register.php" class="nav-link text-primary">Register Here</a>
        </p>
        <button class="btn btn-info"><a href="admin.php" class="text-white">Test Admin Page</a></button>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>