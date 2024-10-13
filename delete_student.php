<?php
include('db.php');

// Check if student ID is passed via POST request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];

    // Prepare the DELETE statement
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);

    // Execute the query and send a response
    if ($stmt->execute()) {
        echo "Student deleted successfully.";
    } else {
        echo "Error deleting student.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
