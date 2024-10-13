<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <form method="post" action="login_process.php">
        <div class="input-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo isset($_SESSION['old_username']) ? $_SESSION['old_username'] : ''; ?>" required>
        </div>
        <div class="input-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <input type="submit" value="Login" class="btn">
    </form>
</div>

<?php
session_start();

if (isset($_SESSION['login_error'])) {
    echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Login Failed',
        text: '".$_SESSION['login_error']."',
        confirmButtonText: 'Try Again'
    });
    </script>";
    unset($_SESSION['login_error']);
}

if (isset($_SESSION['login_success'])) {
    echo "<script>
    Swal.fire({
        icon: 'success',
        title: 'Login Successful',
        text: 'Redirecting to dashboard...',
        timer: 2000,
        showConfirmButton: false
    });
    setTimeout(function() {
        window.location.href = 'dashboard.php';
    }, 2000);
    </script>";
    unset($_SESSION['login_success']);
}
?>
</body>
</html>
