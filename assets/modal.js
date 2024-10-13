function openModal(studentId) {
    const modal = document.getElementById("studentModal");
    modal.style.display = "block";

    // Fetch the student details via AJAX
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "student_details.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("modal-details").innerHTML = xhr.responseText;
        }
    };

    xhr.send("id=" + studentId);
}

function closeModal() {
    document.getElementById("studentModal").style.display = "none";
}
