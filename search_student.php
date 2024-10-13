<?php
session_start();
include('db.php');
//include('header.php');

$search_result = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nic = $_POST['nic'];

    $stmt = $conn->prepare("SELECT * FROM students WHERE nic = ?");
    $stmt->bind_param("s", $nic);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        $search_result = "<div class='search-result'>
                        <p><strong>Name:</strong> " . $student['name'] . "</p>
                        <p><strong>Address:</strong> " . $student['address'] . "</p>
                        <p><strong>Phone:</strong> " . $student['phone'] . "</p>
                        <p><strong>Course:</strong> " . $student['course'] . "</p>
                      </div>";
    } else {
        $search_result = "<div class='error-message'>No student found with this NIC.</div>";
    }


    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Student</title>
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* style.css */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            width: 100%;
            max-width: 500px;
            padding: 40px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333333;
            font-size: 24px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 2px solid #cccccc;
            border-radius: 5px;
            margin-bottom: 20px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus {
            border-color: #0066cc;
            outline: none;
        }

        input[type="submit"] {
            background-color: #0066cc;
            color: #ffffff;
            font-size: 16px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #004999;
        }

        div {
            margin-top: 20px;
            font-size: 16px;
        }

        div p {
            margin: 5px 0;
            font-weight: bold;
        }

        .success-message {
            color: #28a745;
        }

        .error-message {
            color: #dc3545;
            font-weight: bold;
        }

        /* style.css */
        .search-result {
            margin-top: 20px;
            background-color: #f0f9ff;
            padding: 20px;
            border: 1px solid #bce0fd;
            border-radius: 8px;
            color: #333333;
        }

        .search-result p {
            font-size: 16px;
            margin: 10px 0;
        }

        .search-result strong {
            color: #0066cc;
        }

        .error-message {
            color: #dc3545;
            font-weight: bold;
            margin-top: 20px;
            padding: 15px;
            background-color: #ffe5e5;
            border: 1px solid #f5c2c2;
            border-radius: 8px;
        }


    </style>
</head>
<body>
<div class="container">
    <h2>Search Student</h2>
    <form action="" method="post">
        <input type="text" name="nic" placeholder="NIC" required>
        <input type="submit" value="Search">
    </form>
    <div><?php echo $search_result; ?></div>
</div>
</body>
</html>
