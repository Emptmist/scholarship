<?php

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

    // Check connection
    if ($conn->connect_error) {
        $response = ['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error];
        echo json_encode($response);
        exit;
    }

    ///////////////////////////////////
    // Handle delete_scholarship action
    if (isset($_POST['action']) && $_POST['action'] === 'delete_scholarship' && isset($_POST['scholarship_no'])) {
        $scholarship_no = intval($_POST['scholarship_no']);
        // Archive the scholarship
        $sql = "INSERT INTO tbl_scholarship_archive (scholarship_no, scholarship_name, description, qualifications, start_of_applications, end_of_applications, Admin_id, scholarship_processed) SELECT scholarship_no, scholarship_name, description, qualifications, start_of_applications, end_of_applications, Admin_id, scholarship_processed FROM tbl_scholarship WHERE scholarship_no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $scholarship_no);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            // Delete the scholarship
            $sql = "DELETE FROM tbl_scholarship WHERE scholarship_no = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $scholarship_no);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                $response = ['status' => 'success'];
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to delete the scholarship.'];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to archive the scholarship.'];
        }
        $stmt->close();
        $conn->close();
        echo json_encode($response);
        exit;
    }
    ///
    if (isset($_POST['action']) && $_POST['action'] === 'delete_requirements' && isset($_POST['scholarship_no'])) {
        $scholarship_no = intval($_POST['scholarship_no']);
        
        // Archive the requirements
        $sql = "INSERT INTO tbl_requirements_archive (no_req, req_name, scholarship_no)
                SELECT no_req, req_name, scholarship_no
                FROM tbl_requirements
                WHERE scholarship_no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $scholarship_no);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            // Delete the requirements
            $sql = "DELETE FROM tbl_requirements WHERE scholarship_no = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $scholarship_no);
            $stmt->execute();
        
            if ($stmt->affected_rows > 0) {
                $response = ['status' => 'success'];
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to delete the requirements.'];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to archive the requirements.'];
        }
    
        $stmt->close();
        $conn->close();
        echo json_encode($response);
        exit;
    }

    // Handle get_scholarship_details action
    if (isset($_POST['action']) && $_POST['action'] === 'get_scholarship_details' && isset($_POST['scholarship_no'])) {
        $scholarship_no = intval($_POST['scholarship_no']);
        // Fetch scholarship details from the archive
        $sql = "SELECT * FROM tbl_scholarship_archive WHERE scholarship_no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $scholarship_no);
        $stmt->execute();
        $result = $stmt->get_result();
        $scholarship = $result->fetch_assoc();
        if ($scholarship) {
            $response = ['status' => 'success', 'data' => [
                'scholarship_name' => $scholarship["scholarship_name"],
                'description' => $scholarship["description"],
                'qualifications' => $scholarship["qualifications"],
                'start_of_applications' => $scholarship["start_of_applications"],
                'end_of_applications' => $scholarship["end_of_applications"],
                'requirements' => []
            ]];
            // Fetch requirements
            $sql = "SELECT req_name FROM tbl_requirements_archive WHERE scholarship_no = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $scholarship_no);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($req = $result->fetch_assoc()) {
                $response['data']['requirements'][] = $req["req_name"];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Scholarship not found.'];
        }
        $stmt->close();
        $conn->close();
        // Return JSON response
        echo json_encode($response);
        exit;
    }
}
?>