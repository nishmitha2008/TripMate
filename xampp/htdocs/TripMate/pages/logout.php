
<?php

require_once __DIR__ . "/../config/auth.php";

// Clear all session variables
$_SESSION = [];

// Destroy the login session
session_destroy();

// Redirect to homepage
header("Location: ../index.php?logout=success");
exit;

?>
