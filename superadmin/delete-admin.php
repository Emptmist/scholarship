<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_scholarship_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo 'Database connection failed: ' . $conn->connect_error;
    exit;
}

// Retrieve and validate admin ID from POST request
$admin_id = $_POST['admin_id'] ?? '';

if (empty($admin_id)) {
    http_response_code(400);
    echo 'Invalid admin ID.';
    exit;
}

// Start a transaction
$conn->begin_transaction();

try {
    // Fetch admin details
    $stmt = $conn->prepare("SELECT Email FROM tbl_admin_account WHERE Admin_id = ?");
    $stmt->bind_param('i', $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if (!$admin) {
        throw new Exception('Admin not found.');
    }

    // Archive the admin
    $archive_stmt = $conn->prepare("INSERT INTO tbl_admin_archive (Admin_id, Email) VALUES (?, ?)");
    $archive_stmt->bind_param('is', $admin_id, $admin['Email']);
    if (!$archive_stmt->execute()) {
        throw new Exception('Failed to archive admin.');
    }

    // Delete the admin from tbl_admin_account
    $delete_stmt = $conn->prepare("DELETE FROM tbl_admin_account WHERE Admin_id = ?");
    $delete_stmt->bind_param('i', $admin_id);
    if (!$delete_stmt->execute()) {
        throw new Exception('Failed to delete admin from tbl_admin_account.');
    }

    // Commit transaction
    $conn->commit();
    echo 'Admin deleted and archived successfully.';
} catch (Exception $e) {
    // Rollback transaction if any error occurs
    $conn->rollback();
    http_response_code(500);
    echo 'Error: ' . $e->getMessage();
}

// Close the connection
$conn->close();
?>
