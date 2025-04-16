<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

// Check if the session variable is set
if (!isset($_SESSION['Super_admin_Id'])) {
    echo "Session not set";
    exit();
} else {
    $Super_admin_Id = $_SESSION['Super_admin_Id'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $field = $_POST['field'];
    $value = $_POST['value'];

    // Sanitize input to prevent SQL Injection
    $field = $conn->real_escape_string($field);

    if ($field == 'password') {
        // Encrypt the password
        $value = password_hash($value, PASSWORD_BCRYPT);
    } else {
        // Sanitize other fields
        $value = $conn->real_escape_string($value);
    }

    if ($field == 'email' || $field == 'password') {
        $sql = "UPDATE tbl_super_admin_account SET $field = '$value' WHERE Super_admin_Id = $Super_admin_Id";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Invalid field";
    }
}

$conn->close();
?>
