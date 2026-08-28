<?php

session_start();

require_once "../config/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login = trim($_POST["login"]);
    $password = $_POST["password"];

    if (empty($login) || empty($password)) {

        $error = "Please enter your username/email and password.";

    } else {

        $sql = "SELECT id, username, email, password 
                FROM admins 
                WHERE username = ? OR email = ?
                LIMIT 1";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "ss", $login, $login);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {

            $admin = mysqli_fetch_assoc($result);

            if (password_verify($password, $admin["password"])) {

                $_SESSION["admin_id"] = $admin["id"];
                $_SESSION["admin_username"] = $admin["username"];
                $_SESSION["admin_email"] = $admin["email"];

                header("Location: dashboard.php");
                exit();

            } else {

                $error = "Invalid username/email or password.";
            }

        } else {

            $error = "Invalid username/email or password.";
        }

        mysqli_stmt_close($stmt);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login | Quetta Super Shandar Hotel</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            background:
                linear-gradient(rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.65)),
                url('../images/hotel-exterior.jpg') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 450px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.35);
        }

        .login-top {
            background: #b5121b;
            color: #ffffff;
            text-align: center;
            padding: 30px 25px 25px;
            border-bottom: 5px solid #f5c400;
        }

        .hotel-icon {
            width: 65px;
            height: 65px;
            background: #f5c400;
            color: #b5121b;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 30px;
        }

        .login-top h1 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .login-top p {
            margin: 0;
            font-size: 13px;
            opacity: 0.9;
        }

        .login-body {
            padding: 30px;
        }

        .login-title {
            text-align: center;
            margin-bottom: 25px;
        }

        .login-title h2 {
            font-family: 'Playfair Display', serif;
            font-size: 25px;
            color: #222222;
            margin-bottom: 6px;
        }

        .login-title p {
            font-size: 13px;
            color: #777777;
            margin: 0;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #333333;
            margin-bottom: 8px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group-text {
            background: #f8f8f8;
            border: 1px solid #dddddd;
            color: #b5121b;
        }

        .form-control {
            height: 48px;
            border: 1px solid #dddddd;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #b5121b;
            box-shadow: 0 0 0 0.2rem rgba(181, 18, 27, 0.12);
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper .form-control {
            padding-right: 45px;
        }

        .password-toggle {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #777777;
            cursor: pointer;
            z-index: 5;
        }

        .login-btn {
            width: 100%;
            height: 50px;
            background: #b5121b;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 15px;
            transition: 0.3s ease;
        }

        .login-btn:hover {
            background: #8f0e15;
            color: #ffffff;
        }

        .alert {
            font-size: 13px;
            margin-bottom: 20px;
        }

        .back-home {
            text-align: center;
            margin-top: 22px;
        }

        .back-home a {
            color: #b5121b;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }

        .back-home a:hover {
            color: #8f0e15;
        }

        .login-footer {
            text-align: center;
            background: #f8f8f8;
            padding: 15px;
            color: #777777;
            font-size: 12px;
            border-top: 1px solid #eeeeee;
        }

        @media (max-width: 480px) {

            .login-body {
                padding: 25px 20px;
            }

            .login-top h1 {
                font-size: 24px;
            }

            .login-title h2 {
                font-size: 22px;
            }

        }

    </style>

</head>

<body>

    <div class="login-wrapper">

        <div class="login-card">

            <!-- Hotel Header -->

            <div class="login-top">

                <div class="hotel-icon">
                    <i class="bi bi-building"></i>
                </div>

                <h1>Quetta Super Shandar Hotel</h1>

                <p>Hotel Management System</p>

            </div>


            <!-- Login Body -->

            <div class="login-body">

                <div class="login-title">

                    <h2>Admin Login</h2>

                    <p>Sign in to manage your hotel website</p>

                </div>


                <?php if (!empty($error)): ?>

                    <div class="alert alert-danger d-flex align-items-center">

                        <i class="bi bi-exclamation-circle me-2"></i>

                        <?php echo htmlspecialchars($error); ?>

                    </div>

                <?php endif; ?>


                <form method="POST" action="">

                    <!-- Username / Email -->

                    <label class="form-label">
                        Username or Email
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-person"></i>
                        </span>

                        <input
                            type="text"
                            name="login"
                            class="form-control"
                            placeholder="Enter username or email"
                            required>

                    </div>


                    <!-- Password -->

                    <label class="form-label">
                        Password
                    </label>

                    <div class="input-group password-wrapper">

                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="Enter your password"
                            required>

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword()">

                            <i class="bi bi-eye" id="eyeIcon"></i>

                        </button>

                    </div>


                    <!-- Login Button -->

                    <button type="submit" class="login-btn">

                        <i class="bi bi-box-arrow-in-right me-2"></i>

                        Login to Admin Panel

                    </button>

                </form>


                <!-- Back to Website -->

                <div class="back-home">

                    <a href="../index.php">

                        <i class="bi bi-arrow-left me-1"></i>

                        Back to Hotel Website

                    </a>

                </div>

            </div>


            <!-- Footer -->

            <div class="login-footer">

                © <?php echo date("Y"); ?> Quetta Super Shandar Hotel

            </div>

        </div>

    </div>


    <script>

        function togglePassword() {

            const password = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");

            if (password.type === "password") {

                password.type = "text";

                eyeIcon.classList.remove("bi-eye");
                eyeIcon.classList.add("bi-eye-slash");

            } else {

                password.type = "password";

                eyeIcon.classList.remove("bi-eye-slash");
                eyeIcon.classList.add("bi-eye");

            }

        }

    </script>

</body>

</html>