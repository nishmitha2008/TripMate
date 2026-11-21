
<?php
require_once __DIR__ . "/config/auth.php";
require_once __DIR__ . "/config/db.php";

if (!isLoggedIn()) {
    header("Location: pages/login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $destination = trim($_POST["destination"] ?? "");
    $start_date = $_POST["start_date"] ?? "";
    $end_date = $_POST["end_date"] ?? "";
    $budget = $_POST["budget"] ?? "";

    if (
        $destination === "" ||
        $start_date === "" ||
        $end_date === "" ||
        !is_numeric($budget) ||
        (float)$budget < 0 ||
        $end_date < $start_date
    ) {
        $message = "Please enter valid trip details.";
    } else {

        $user_id = $_SESSION["user_id"];

        $stmt = $conn->prepare(
            "INSERT INTO trips
            (user_id, destination, start_date, end_date, budget)
            VALUES (?, ?, ?, ?, ?)"
        );

        $amount = (float)$budget;

        $stmt->bind_param(
            "isssd",
            $user_id,
            $destination,
            $start_date,
            $end_date,
            $amount
        );

        if ($stmt->execute()) {
            header("Location: my_trips.php");
            exit;
        } else {
            $message = "Unable to save trip. Please try again.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Plan Trip - TripMate</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        .trip-form {
            max-width: 450px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px #0002;
        }

        .trip-form h1 {
            color: #087e8b;
            text-align: center;
        }

        .trip-form input {
            width: 100%;
            padding: 12px;
            margin: 12px 0 20px;
            border: 1px solid #ccc;
            border-radius: 7px;
        }

        .trip-form button {
            width: 100%;
            padding: 13px;
            background: #087e8b;
            color: white;
            border: none;
            border-radius: 7px;
            cursor: pointer;
        }

        .trip-form label {
            font-weight: bold;
        }

        .trip-form a {
            color: #087e8b;
        }
    </style>
</head>

<body>

<div class="trip-form">

    <h1>Plan Your Trip ✈️</h1>

    <p>Enter your travel details below.</p>

    <form method="POST">

        <label>Destination</label>
        <input type="text"
               name="destination"
               placeholder="Example: Ooty"
               maxlength="150"
               required>

        <label>Start Date</label>
        <input type="date"
               name="start_date"
               required>

        <label>End Date</label>
        <input type="date"
               name="end_date"
               required>

        <label>Budget (₹)</label>
        <input type="number"
               name="budget"
               placeholder="Enter your budget"
               min="0"
               step="0.01"
               required>

        <button type="submit">Save My Trip</button>

    </form>

    <p style="color:red;">
        <?php echo htmlspecialchars($message); ?>
    </p>

    <p>
        <a href="index.php">Home</a> |
        <a href="my_trips.php">My Trips</a>
    </p>

</div>

</body>
</html>
