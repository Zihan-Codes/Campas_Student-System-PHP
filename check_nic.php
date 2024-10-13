<?php
// check_nic.php

include('db.php'); // Include your database connection file

if (isset($_POST['nic'])) {
    $nic = $_POST['nic'];

    // Prepare a statement to check if the NIC exists
    $stmt = $conn->prepare("SELECT * FROM students WHERE nic = ?");
    $stmt->bind_param("s", $nic);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // NIC already exists
        echo json_encode(['exists' => true]);
    } else {
        // NIC does not exist
        echo json_encode(['exists' => false]);
    }

    $stmt->close();
}
?>
