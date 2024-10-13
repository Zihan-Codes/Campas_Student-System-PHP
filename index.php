<?php
session_start();

if (isset($_SESSION['username'])) {
    // Check if the session is expired
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $_SESSION['expire_time'])) {
        // If the session is older than 10 minutes, unset the session and redirect to login
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    } else {
        // If session is valid, update the last activity time
        $_SESSION['last_activity'] = time();
        header("Location: dashboard.php");
        exit();
    }
} else {
    // If not logged in, redirect to login page
    header("Location: login.php");
    exit();
}
?>
