<?php
//session_start();
include('header.php');

if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to login
    header("Location: login.php");
    exit();
}

// Check for session timeout
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $_SESSION['expire_time'])) {
    // If the session is older than 10 minutes, unset the session and redirect to login
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
} else {
    // Update the last activity time if the session is still valid
    $_SESSION['last_activity'] = time();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <nav>
        <a href="register_student.php" class="btn">Register Student</a>
        <a href="search_student.php" class="btn">Search Student</a>
        <a href="logout.php" class="btn">Logout</a>
        <a href="students.php" class="btn">Students</a>
    </nav>
</div>
</body>
</html>
