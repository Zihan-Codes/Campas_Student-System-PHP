<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $student_id = $_POST['id'];

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        echo "<h3>Student Details</h3>";
        echo "<p><strong>ID:</strong> " . $student['id'] . "</p>";
        echo "<p><strong>NIC:</strong> " . $student['nic'] . "</p>";
        echo "<p><strong>Name:</strong> " . $student['name'] . "</p>";
        echo "<p><strong>Address:</strong> " . $student['address'] . "</p>";
        echo "<p><strong>Phone:</strong> " . $student['phone'] . "</p>";
        echo "<p><strong>Course:</strong> " . $student['course'] . "</p>";
    } else {
        echo "Student not found.";
    }
}
?>
