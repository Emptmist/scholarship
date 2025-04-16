<?php
$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Admin_id = $_POST['Admin_id'];
    $newPassword = $_POST['newPassword'];

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Update the password in the database
    $sql = "UPDATE tbl_admin_account SET Password = ? WHERE Admin_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $hashedPassword, $Admin_id);

    if ($stmt->execute()) {
        echo "Password updated successfully";
    } else {
        echo "Error updating password: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
