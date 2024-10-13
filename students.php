<?php
include('db.php');
include('header.php');

// Fetch student records
$sql = "SELECT id, name, course FROM students";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <link rel="stylesheet" href="css/student_view.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .message {
            margin: 20px 0;
            padding: 10px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
        }

        .delete-btn {
            padding: 8px 16px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .edit-btn {
            padding: 8px 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Modal Background */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.7);
        }

        /* Modal Content */
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            border-radius: 8px;
            width: 80%;
            max-width: 500px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        /* Modal Header */
        h3 {
            margin-top: 0;
            color: #333;
        }

        /* Input Groups */
        .input-group {
            margin-bottom: 15px;
        }

        /* Labels */
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        /* Inputs */
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Update Button */
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #45a049;
        }


    </style>
</head>
<body>
<div class="container">
    <h2>Student List</h2>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Course</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['course']; ?></td>
                    <td>
                        <button class="view-btn" onclick="openModal(<?php echo $row['id']; ?>)">View</button>
                        <button class="edit-btn" onclick="openEditModal2(<?php echo $row['id']; ?>)">Edit</button>
                        <button class="delete-btn" onclick="deleteStudent(<?php echo $row['id']; ?>)">Delete</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4">No students found</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="studentModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <div id="modal-details">
            <!-- Student details will be populated here -->
        </div>
    </div>
</div>

<!-- Modal (Edit) -->
<div id="editStudentModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal2()">&times;</span>
        <h3>Edit Student Details</h3>
        <form id="editStudentForm" method="post" action="update_student.php">
            <input type="hidden" id="edit-id" name="id">
            <div class="input-group">
                <label for="edit-nic">NIC:</label>
                <input type="text" id="edit-nic" name="nic" required>
            </div>
            <div class="input-group">
                <label for="edit-name">Name:</label>
                <input type="text" id="edit-name" name="name" required>
            </div>
            <div class="input-group">
                <label for="edit-address">Address:</label>
                <input type="text" id="edit-address" name="address" required>
            </div>
            <div class="input-group">
                <label for="edit-phone">Phone:</label>
                <input type="text" id="edit-phone" name="phone" required>
            </div>
            <div class="input-group">
                <label for="edit-course">Course:</label>
                <input type="text" id="edit-course" name="course" required>
            </div>
            <input type="submit" value="Update" class="btn">
        </form>
    </div>
</div>

<script src="assets/modal.js"></script>

<script>
    function openEditModal2(id) {
        // Fetch student details and populate the form for editing
        fetch('get_student_details.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                document.getElementById('edit-id').value = data.id;
                document.getElementById('edit-nic').value = data.nic;
                document.getElementById('edit-name').value = data.name;
                document.getElementById('edit-address').value = data.address;
                document.getElementById('edit-phone').value = data.phone;
                document.getElementById('edit-course').value = data.course;
                document.getElementById('editStudentModal').style.display = 'block';
            });
    }

    function closeEditModal2() {
        document.getElementById('editStudentModal').style.display = 'none';
    }
</script>

<script>
    // Function to delete student using AJAX
    function deleteStudent(studentId) {
        if (confirm('Are you sure you want to delete this student?')) {
            $.ajax({
                url: 'delete_student.php',
                type: 'POST',
                data: { student_id: studentId },
                success: function(response) {
                    alert(response); // Alert success or error message
                    $('#student-row-' + studentId).remove(); // Remove the row from the table
                    location.reload(); // Reload the page
                },
                error: function() {
                    alert('Error deleting student. Please try again.');
                }
            });
        }
    }
</script>

</body>
</html>
