
<?php
require_once "config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $destination = trim($_POST["destination"]);
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $budget = $_POST["budget"];

    if (
        $destination == "" ||
        $start_date == "" ||
        $end_date == "" ||
        !is_numeric($budget) ||
        $budget < 0 ||
        $end_date < $start_date
    ) {
        $message = "Please enter valid trip details.";
    } else {

        $stmt = $conn->prepare(
            "INSERT INTO trips
            (user_id, destination, start_date, end_date, budget)
            VALUES (?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "isssd",
            $_SESSION["user_id"],
            $destination,
            $start_date,
            $end_date,
            $budget
        );

        if ($stmt->execute()) {
            header("Location: my_trips.php");
            exit;
        } else {
            $message = "Trip could not be saved.";
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
    <title>Plan Your Trip - TripMate</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="auth-box">

    <h1>Plan Your Trip ✈️</h1>

    <p>Enter your travel details below.</p>

    <form method="POST">

        <input type="text"
               name="destination"
               placeholder="Enter destination"
               required>

        <label>Start Date</label>
        <input type="date" name="start_date" required>

        <label>End Date</label>
        <input type="date" name="end_date" required>

        <label>Estimated Budget (₹)</label>
        <input type="number"
               name="budget"
               placeholder="Enter budget"
               min="0"
               step="0.01"
               required>

        <button type="submit">Save My Trip</button>

    </form>

    <p><?php echo htmlspecialchars($message); ?></p>

    <a href="my_trips.php">View My Trips</a>

</div>

</body>
</html>
