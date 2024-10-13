<?php
include('db.php');

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        // Return student details as JSON
        echo json_encode($student);
    } else {
        echo json_encode(['error' => 'Student not found.']);
    }
}
?>
