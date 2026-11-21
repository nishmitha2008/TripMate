
<?php
session_start();
require_once "../config/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare(
        "SELECT id, name, password FROM users WHERE email = ?"
    );
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["name"];

        header("Location: ../index.php");
        exit;
    } else {
        $error = "Incorrect email or password. Please try again.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login | TripMate</title>

<link rel="stylesheet" href="../assets/css/style.css">

<style>
.login-page {
    min-height: calc(100vh - 85px);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 50px 20px;
    background: #f8f7f1;
}

.login-card {
    width: 100%;
    max-width: 440px;
    padding: 45px 40px;
    background: white;
    border-radius: 22px;
    box-shadow: 0 15px 45px rgba(38,53,42,.09);
    text-align: center;
}

.login-card .tagline {
    margin-bottom: 14px;
}

.login-card h1 {
    font-family: 'Playfair Display', serif;
    font-size: 36px;
    color: #26352a;
    margin-bottom: 12px;
}

.login-subtitle {
    color: #777d73;
    font-size: 14px;
    margin-bottom: 30px;
    line-height: 1.7;
}

.login-form {
    text-align: left;
}

.login-form label {
    display: block;
    margin-bottom: 9px;
    font-size: 14px;
    font-weight: 600;
    color: #344b3d;
}

.login-form input {
    width: 100%;
    padding: 14px;
    margin-bottom: 22px;
    border: 1px solid #d9e1d9;
    border-radius: 9px;
    background: #fafbf8;
    font-size: 14px;
    outline: none;
}

.login-form input:focus {
    border-color: #526b55;
}

.login-form button {
    width: 100%;
    padding: 15px;
    background: #526b55;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: .3s;
}

.login-form button:hover {
    background: #26352a;
}

.login-error {
    background: #fff0ed;
    color: #b33c30;
    padding: 12px;
    border-radius: 8px;
    font-size: 13px;
    margin-bottom: 20px;
}

.register-text {
    margin-top: 25px;
    font-size: 14px;
    color: #777d73;
}

.register-text a {
    color: #526b55;
    font-weight: 700;
}

.back-home {
    display: inline-block;
    margin-top: 25px;
    color: #526b55;
    font-size: 13px;
    font-weight: 600;
}

@media(max-width: 500px) {
    .login-card {
        padding: 35px 23px;
    }

    .login-card h1 {
        font-size: 30px;
    }
}
</style>
</head>

<body>

<header class="navbar">
    <a href="../index.php" class="logo">Trip<span>Mate.</span></a>
    <a href="../index.php" class="nav-button">Home ↗</a>
</header>

<main class="login-page">

    <div class="login-card">

        <p class="tagline">✦ YOUR JOURNEY STARTS HERE</p>

        <h1>Welcome Back!</h1>

        <p class="login-subtitle">
            Log in to continue planning your next adventure.
        </p>

        <?php if ($error): ?>
            <div class="login-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="login-form">

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
                placeholder="Enter your password"
                required
            >

            <button type="submit">Login to TripMate →</button>

        </form>

        <p class="register-text">
            Don't have an account?
            <a href="register.php">Create Account</a>
        </p>

        <a href="../index.php" class="back-home">
            ← Back to Homepage
        </a>

    </div>

</main>

</body>
</html>
