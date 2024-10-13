

<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $student_id = $_POST['id'];
    $nic = $_POST['nic'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];

    // Prepare and execute update query
    $stmt = $conn->prepare("UPDATE students SET nic = ?, name = ?, address = ?, phone = ?, course = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $nic, $name, $address, $phone, $course, $student_id);

    if ($stmt->execute()) {
        // Redirect back to the students list page with success message
        header("Location: students.php?update_success=1");
    } else {
        // Redirect back to the students list page with error message
        header("Location: students.php?update_error=1");
    }
}
?>
