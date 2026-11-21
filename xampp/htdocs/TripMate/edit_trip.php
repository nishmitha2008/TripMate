
<?php
require_once __DIR__ . "/config/auth.php";
require_once __DIR__ . "/config/db.php";

if (!isLoggedIn()) {
    header("Location: pages/login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: my_trips.php");
    exit;
}

$stmt = $conn->prepare(
    "SELECT * FROM trips WHERE id = ? AND user_id = ?"
);
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();

$trip = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$trip) {
    die("Trip not found.");
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

        $amount = (float)$budget;

        $update = $conn->prepare(
            "UPDATE trips
             SET destination = ?, start_date = ?,
                 end_date = ?, budget = ?
             WHERE id = ? AND user_id = ?"
        );

        $update->bind_param(
            "sssdii",
            $destination,
            $start_date,
            $end_date,
            $amount,
            $id,
            $user_id
        );

        if ($update->execute()) {
            header("Location: my_trips.php");
            exit;
        } else {
            $message = "Unable to update trip.";
        }

        $update->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Trip - TripMate</title>
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        body {
            background: #f0f8fa;
            font-family: Arial, sans-serif;
        }

        .edit-container {
            max-width: 450px;
            margin: 60px auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px #0002;
        }

        h1 {
            color: #087e8b;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 18px;
            font-weight: bold;
        }

        input {
            width: 100%;
            box-sizing: border-box;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 7px;
        }

        button {
            width: 100%;
            padding: 13px;
            margin-top: 25px;
            background: #087e8b;
            color: white;
            border: none;
            border-radius: 7px;
            cursor: pointer;
        }

        .message {
            color: red;
            text-align: center;
        }

        a {
            color: #087e8b;
        }
    </style>
</head>

<body>

<div class="edit-container">

    <h1>Edit Your Trip ✈️</h1>

    <form method="POST">

        <label>Destination</label>
        <input type="text"
               name="destination"
               maxlength="150"
               value="<?php echo htmlspecialchars($trip["destination"]); ?>"
               required>

        <label>Start Date</label>
        <input type="date"
               name="start_date"
               value="<?php echo htmlspecialchars($trip["start_date"] ?? ""); ?>"
               required>

        <label>End Date</label>
        <input type="date"
               name="end_date"
               value="<?php echo htmlspecialchars($trip["end_date"] ?? ""); ?>"
               required>

        <label>Budget (₹)</label>
        <input type="number"
               name="budget"
               min="0"
               step="0.01"
               value="<?php echo htmlspecialchars($trip["budget"] ?? "0"); ?>"
               required>

        <button type="submit">Update Trip</button>

    </form>

    <p class="message">
        <?php echo htmlspecialchars($message); ?>
    </p>

    <p>
        <a href="my_trips.php">← Back to My Trips</a>
    </p>

</div>

</body>
</html>
