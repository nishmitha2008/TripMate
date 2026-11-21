
<?php
require_once __DIR__ . "/../config/auth.php";
require_once __DIR__ . "/../config/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($name === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter valid details.";
    } elseif (strlen($password) < 8) {
        $error = "Password must contain at least 8 characters.";
    } else {

        $check = $conn->prepare(
            "SELECT id FROM users WHERE email = ?"
        );

        $check->bind_param("s", $email);
        $check->execute();

        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $error = "Email already registered. Please login.";

        } else {

            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = $conn->prepare(
                "INSERT INTO users (name, email, password)
                 VALUES (?, ?, ?)"
            );

            $stmt->bind_param(
                "sss",
                $name,
                $email,
                $hashedPassword
            );

            if ($stmt->execute()) {
                header("Location: login.php?registered=1");
                exit;
            } else {
                $error = "Registration failed. Please try again.";
            }

            $stmt->close();
        }

        $check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Account | TripMate</title>

    <link rel="stylesheet" href="../assets/css/style.css">

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #dff6f5, #e9efff);
        }

        .login-page {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px 15px;
        }

        .login-card {
            width: 100%;
            max-width: 450px;
            background: white;
            padding: 40px;
            border-radius: 18px;
            box-shadow: 0 10px 35px rgba(0,0,0,0.12);
        }

        .tagline {
            text-align: center;
            color: #087e8b;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 15px;
        }

        .login-card h1 {
            text-align: center;
            color: #087e8b;
            margin-bottom: 10px;
            font-size: 30px;
        }

        .login-subtitle {
            text-align: center;
            color: #777;
            margin-bottom: 28px;
            line-height: 1.5;
        }

        .login-form label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
        }

        .login-form input {
            width: 100%;
            padding: 14px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
        }

        .login-form input:focus {
            border-color: #087e8b;
            box-shadow: 0 0 5px #087e8b33;
        }

        .login-form button {
            width: 100%;
            padding: 15px;
            background: #087e8b;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-form button:hover {
            background: #06636d;
        }

        .register-text {
            text-align: center;
            margin-top: 25px;
            color: #666;
        }

        .register-text a,
        .back-home {
            color: #087e8b;
            font-weight: bold;
            text-decoration: none;
        }

        .back-home {
            display: block;
            text-align: center;
            margin-top: 18px;
        }

        .login-error {
            background: #ffe5e5;
            color: #c62828;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        @media(max-width: 480px) {
            .login-card {
                padding: 25px;
            }

            .login-card h1 {
                font-size: 25px;
            }
        }

    </style>

</head>

<body>

<main class="login-page">

    <div class="login-card">

        <p class="tagline">✦ YOUR JOURNEY STARTS HERE</p>

        <h1>Create Account!</h1>

        <p class="login-subtitle">
            Join TripMate and start planning your next adventure.
        </p>

        <?php if ($error): ?>

            <div class="login-error">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>

        <form method="POST" class="login-form">

            <label for="name">Full Name</label>

            <input
                type="text"
                id="name"
                name="name"
                placeholder="Enter your full name"
                maxlength="100"
                required
            >

            <label for="email">Email Address</label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your email"
                required
            >

            <label for="password">Password</label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Minimum 8 characters"
                minlength="8"
                required
            >

            <button type="submit">
                Create My Account →
            </button>

        </form>

        <p class="register-text">
            Already have an account?
            <a href="login.php">Login</a>
        </p>

        <a href="../index.php" class="back-home">
            ← Back to Home
        </a>

    </div>

</main>

</body>
</html>
