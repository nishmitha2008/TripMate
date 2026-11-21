
<?php
require_once __DIR__ . "/config/auth.php";
require_once __DIR__ . "/config/db.php";

if (!isLoggedIn()) {
    header("Location: pages/login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare(
    "SELECT id, destination, start_date, end_date, budget, created_at
     FROM trips
     WHERE user_id = ?
     ORDER BY created_at DESC"
);

$stmt->bind_param("i", $user_id);
$stmt->execute();

$trips = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Trips | TripMate</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f0f8fa;
        }

        .trips-container {
            max-width: 1100px;
            margin: 50px auto;
            padding: 20px;
        }

        .trips-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .trips-header h1 {
            color: #087e8b;
            font-size: 34px;
        }

        .trip-actions {
            text-align: center;
            margin-bottom: 30px;
        }

        .trip-btn {
            display: inline-block;
            padding: 12px 22px;
            margin: 8px;
            background: #087e8b;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        .trip-btn:hover {
            background: #06636d;
        }

        .trip-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 22px;
        }

        .trip-card {
            background: white;
            padding: 25px;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .trip-card h2 {
            color: #087e8b;
            margin-top: 0;
        }

        .trip-card p {
            color: #555;
            line-height: 1.7;
        }

        .edit-btn {
            display: inline-block;
            background: #087e8b;
            color: white;
            padding: 9px 16px;
            border-radius: 6px;
            text-decoration: none;
        }

        .delete-btn {
            background: #dc3545;
            color: white;
            padding: 9px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .empty-box {
            background: white;
            text-align: center;
            padding: 45px 20px;
            border-radius: 15px;
            grid-column: 1 / -1;
        }

        .empty-box h2 {
            color: #087e8b;
        }
    </style>
</head>

<body>

<div class="trips-container">

    <div class="trips-header">

        <h1>My Trips ✈️</h1>

        <p>All your planned adventures in one place!</p>

    </div>

    <div class="trip-actions">

        <a href="add_trip.php" class="trip-btn">
            + Plan New Trip
        </a>

        <a href="index.php" class="trip-btn">
            Home
        </a>

    </div>

    <div class="trip-list">

        <?php if ($trips->num_rows > 0): ?>

            <?php while ($trip = $trips->fetch_assoc()): ?>

                <div class="trip-card">

                    <h2>
                        🌍 <?php echo htmlspecialchars($trip["destination"]); ?>
                    </h2>

                    <p>
                        <strong>Start Date:</strong>
                        <?php echo htmlspecialchars($trip["start_date"] ?? "Not set"); ?>
                    </p>

                    <p>
                        <strong>End Date:</strong>
                        <?php echo htmlspecialchars($trip["end_date"] ?? "Not set"); ?>
                    </p>

                    <p>
                        <strong>Budget:</strong>
                        ₹<?php echo number_format((float)$trip["budget"], 2); ?>
                    </p>

                    <a class="edit-btn"
                       href="edit_trip.php?id=<?php echo (int)$trip["id"]; ?>">
                        Edit
                    </a>

                    <form action="delete_trip.php"
                          method="POST"
                          style="display:inline;"
                          onsubmit="return confirm('Are you sure you want to delete this trip?');">

                        <input type="hidden"
                               name="id"
                               value="<?php echo (int)$trip["id"]; ?>">

                        <button type="submit" class="delete-btn">
                            Delete
                        </button>

                    </form>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="empty-box">

                <h2>No Trips Yet! 🌍</h2>

                <p>Your next adventure is waiting.</p>

                <a href="add_trip.php" class="trip-btn">
                    Plan Your First Trip
                </a>

            </div>

        <?php endif; ?>

    </div>

</div>

</body>
</html>

<?php
$stmt->close();
?>
