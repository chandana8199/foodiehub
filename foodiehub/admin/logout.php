<?php
// Start session
session_start();

// Destroy the session to log the user out
session_destroy();

// Redirect to the index.html page (outside the admin folder)
header("Location: ../index.html");
exit();
?>
