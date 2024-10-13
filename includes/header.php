<?php
// Check if session is set for logged-in user, otherwise redirect to login
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<link rel="stylesheet" href="css/header.css">

<header>
    <div class="navbar">
        <a href="javascript:history.back()" class="btn-back">Back</a>
        <a href="dashboard.php" class="btn-home">Home</a>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</header>
