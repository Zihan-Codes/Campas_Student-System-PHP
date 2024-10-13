<?php
include('db.php');  // Include database connection

// AJAX form processing
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajax_request'])) {
    $nic = $_POST['nic'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];

    // Check if NIC is already in use
    $stmt_check = $conn->prepare("SELECT * FROM students WHERE nic = ?");
    $stmt_check->bind_param("s", $nic);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    if ($result_check->num_rows > 0) {
        // NIC already exists, return error response
        echo json_encode(['status' => 'error', 'message' => 'NIC already exists!']);
        exit;
    }

    // Insert student data into the database
    $sql = "INSERT INTO students (nic, name, address, phone, course) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nic, $name, $address, $phone, $course);

    if ($stmt->execute()) {
        // Success: Return success response
        echo json_encode(['status' => 'success', 'message' => 'Student registered successfully!']);
    } else {
        // Failure: Return error response
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Student</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Your CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!-- jQuery for AJAX -->
</head>
<body>
<div class="container">
    <h2>Register Student</h2>
    <form id="registerForm">
        <div class="input-group">
            <label for="nic">NIC:</label>
            <input type="text" id="nic" name="nic" required>
            <span id="nic-error" class="error-message" style="color:red;"></span>
        </div>
        <div class="input-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <span id="name-error" class="error-message" style="color:red;"></span>
        </div>
        <div class="input-group">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
            <span id="address-error" class="error-message" style="color:red;"></span>
        </div>
        <div class="input-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>
            <span id="phone-error" class="error-message" style="color:red;"></span>
        </div>
        <div class="input-group">
            <label for="course">Course:</label>
            <input type="text" id="course" name="course" required>
            <span id="course-error" class="error-message" style="color:red;"></span>
        </div>
        <input type="submit" value="Register" class="btn" id="registerBtn" disabled>
    </form>
</div>

<!-- JavaScript -->
<script>
    // NIC validation function
    function validateNIC(nic) {
        const nic10Pattern = /^[0-9]{9}[vVxX]$/; // 10 digits with v/V or x/X
        const nic12Pattern = /^[0-9]{12}$/; // 12 digits only
        return nic10Pattern.test(nic) || nic12Pattern.test(nic);
    }

    // Validate Phone Number on input
    $('#phone').on('input', function() {
        let phone = $(this).val();
        if (!/^[0]\d{9}$/.test(phone)) {
            $('#phone-error').text('Phone number must be 10 digits and start with 0');
            $('#registerBtn').prop('disabled', true); // Disable if invalid phone
        } else {
            $('#phone-error').text('');
            checkFormValid(); // Enable button if the phone is valid
        }
    });

    // Validate Name on input
    $('#name').on('input', function() {
        let name = $(this).val();
        if (name.trim() === '') {
            $('#name-error').text('Name cannot be empty');
            $('#registerBtn').prop('disabled', true);
        } else {
            $('#name-error').text('');
            checkFormValid(); // Enable if valid
        }
    });

    // Validate Address on input
    $('#address').on('input', function() {
        let address = $(this).val();
        if (address.trim() === '') {
            $('#address-error').text('Address cannot be empty');
            $('#registerBtn').prop('disabled', true);
        } else {
            $('#address-error').text('');
            checkFormValid(); // Enable if valid
        }
    });

    // Validate Course on input
    $('#course').on('input', function() {
        let course = $(this).val();
        if (course.trim() === '') {
            $('#course-error').text('Course cannot be empty');
            $('#registerBtn').prop('disabled', true);
        } else {
            $('#course-error').text('');
            checkFormValid(); // Enable if valid
        }
    });

    // Check if the form is valid and enable/disable the button
    function checkFormValid() {
        let nicValid = $('#nic-error').text() === '';
        let phoneValid = $('#phone-error').text() === '';
        let nameValid = $('#name-error').text() === '';
        let addressValid = $('#address-error').text() === '';
        let courseValid = $('#course-error').text() === '';

        if (nicValid && phoneValid && nameValid && addressValid && courseValid) {
            $('#registerBtn').prop('disabled', false); // Enable button if all fields are valid
        } else {
            $('#registerBtn').prop('disabled', true); // Keep button disabled
        }
    }

    $(document).ready(function() {
        // NIC validation on blur
        $('#nic').on('blur', function() {
            let nic = $(this).val();
            if (nic !== '') {
                if (!validateNIC(nic)) {
                    $('#nic-error').text('Invalid NIC format! Must be 10 digits (9 numbers + letter) or 12 digits.');
                    $('#registerBtn').prop('disabled', true);
                    return;
                }
                $('#nic-error').text(''); // Clear error message if valid
            }
            checkFormValid(); // Check if form is valid
        });

        // Other field validations similar to above (phone, name, address, course)
        // ... (same as in previous code)

        // Form submission via AJAX
        $('#registerForm').on('submit', function(e) {
            e.preventDefault(); // Prevent form default submission

            $.ajax({
                url: 'register_student.php', // The same page
                type: 'POST',
                data: $(this).serialize() + '&ajax_request=true', // Add ajax_request to flag it
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Student Registered!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function() {
                            window.location.href = 'students.php'; // Redirect after success
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message,
                            timer: 3000,
                            showConfirmButton: true
                        });
                    }
                }
            });
        });
    });
</script>
</body>
</html>
