<?php
session_start();
include('db.php'); // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prevent SQL injection (use prepared statements for better security)
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, set session variables
        $_SESSION['username'] = $username;
        $_SESSION['last_activity'] = time(); // Store the current time as last activity
        $_SESSION['expire_time'] = 600; // Session expires after 10 minutes (600 seconds)

        // Success: Set success message and redirect to login.php for SweetAlert display
        $_SESSION['login_success'] = 'You have successfully logged in!';
        header("Location: login.php");
        exit();
    } else {
        // Failure: Set error message and old username to repopulate the form
        $_SESSION['login_error'] = 'Invalid username or password. Please try again.';
        $_SESSION['old_username'] = $username; // Retain username
        header("Location: login.php"); // Redirect back to login page
        exit();
    }

    $stmt->close();
}
?>
