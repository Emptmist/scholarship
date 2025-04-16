<?php
$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Student_No = $_POST['Student_No'];
    $newpass = $_POST['newpass'];

    // Hash the new password
    $hashedPassword = password_hash($newpass, PASSWORD_BCRYPT);

    // Update the password in the database
    $sql = "UPDATE tbl_student_acc SET Password = ? WHERE Student_No = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $hashedPassword, $Student_No);

    if ($stmt->execute()) {
        echo "Password updated successfully";
    } else {
        echo "Error updating password: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
