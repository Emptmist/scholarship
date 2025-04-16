<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST['excel-data'])) {
    $filename = $_FILES['import-file']['name'];

    $allowed_ext = ['xls', 'csv', 'xlsx'];
    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);

    if (in_array($file_ext, $allowed_ext)) {
        $inputFileName = $_FILES['import-file']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
        $data = $spreadsheet->getActiveSheet()->toArray();

        // Skip the header row
        $headerSkippedData = array_slice($data, 1);

        $success = false; // Initialize success flag

        foreach ($headerSkippedData as $row) {
            if (!empty(array_filter($row))) {
                $Student_No = $row[0];
                $Last_Name = $row[1];
                $First_Name = $row[2];
                $CVSU_Email = $row[3];

                $studentQuery = "INSERT INTO tbl_cvsu_students (Student_No, Last_name, First_name, CVSU_Email) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($studentQuery);
                $stmt->bind_param('ssss', $Student_No, $Last_Name, $First_Name, $CVSU_Email);

                if ($stmt->execute()) {
                    $success = true;
                } else {
                    $success = false;
                    error_log("Query failed: " . $stmt->error);
                }
                $stmt->close();
            }
        }

        if ($success) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'SUCCESSFULLY IMPORTED'];
        } else {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'NOT IMPORTED'];
        }
    } else {
        $_SESSION['message'] = ['type' => 'error', 'text' => 'INVALID FILE'];
    }

    // Redirect with a query parameter to show div2
    header('Location: superadmin_Student.php?showDiv2=true');
    exit(0);
}
?>
