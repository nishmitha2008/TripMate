
<?php
require_once __DIR__ . "/config/auth.php";
require_once __DIR__ . "/config/db.php";

if (!isLoggedIn()) {
    header("Location: pages/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: my_trips.php");
    exit;
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: my_trips.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare(
    "DELETE FROM trips WHERE id = ? AND user_id = ?"
);

$stmt->bind_param("ii", $id, $user_id);

if ($stmt->execute()) {
    $stmt->close();
    header("Location: my_trips.php?deleted=1");
    exit;
}

$stmt->close();

header("Location: my_trips.php?error=delete");
exit;
?>
