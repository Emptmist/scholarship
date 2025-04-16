<?php
$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// function non_activated_deletion($conn){
//     $show_query = $conn -> query("SELECT Student_No FROM tbl_student_acc WHERE Date_Created <= NOW() - INTERVAL 1 HOUR;");
//     while($row = $show_query->fetch_assoc()){
//         $ID = $row['Student_No'];

//         $result = $conn->execute_query("DELETE FROM tbl_student_acc WHERE Student_No = '$ID' AND Verification_Status = '0'; ");

//         if($result){
//             echo "Deleted";
//         }else{
//             echo "Not deleted";
//         }
//     }

// }

function non_activated_deletion($conn) {
    $show_query = $conn->query("SELECT Student_No FROM tbl_student_acc WHERE Date_Created <= NOW() - INTERVAL 1 HOUR;");
    

    while ($row = $show_query->fetch_assoc()) {
        $ID = $row['Student_No'];

        // Prepare the DELETE statement
        $stmt = $conn->prepare("DELETE FROM tbl_student_acc WHERE Student_No = ? AND Verification_Status = '0';");

        // Bind the parameter
        
        $stmt->bind_param("s", $ID); // Assuming Student_No is a string
        $stmt->execute();

        // For Debug

        // if ($stmt) {
        //     echo "Deleted Student_No: $ID successfully.\n";
        // } else {
        //     echo "Error deleting Student_No: $ID. Error: " . $conn->error . "\n";
        // }
        // Close the statement
        $stmt->close();
    }
}

function scholarship_expiration($conn){
    $show_query = $conn->query("SELECT * FROM tbl_scholarship WHERE start_of_applications >= end_of_applications");

    while ($row = $show_query->fetch_assoc()){
        $scholarship_no = $row['scholarship_no'];

        echo $scholarship_no;

        $insert_query = $conn->prepare("INSERT INTO tbl_scholarship_archive(scholarship_no, scholarship_name, description, qualifications, start_of_applications, end_of_applications) VALUE(?, ?, ?, ?, ?, ?)");
        $insert_query->bind_param("ssssss", $row['scholarship_no'], $row['scholarship_name'], $row['description'], $row['qualifications'], $row['start_of_applications'], $row['end_of_applications']);
        $insert_query->execute();

        $show_query = $conn->query("SELECT * FROM tbl_requirements WHERE scholarship_no = $scholarship_no");

        while ($row1 = $show_query->fetch_assoc()){
            $insert_query = $conn->prepare("INSERT INTO tbl_requirements_archive(no_req, req_name, scholarship_no) VALUE(?, ?, ?)");
            $insert_query->bind_param("sss", $row1['no_req'], $row1['req_name'], $row1['scholarship_no']);
            $insert_query->execute();

            $stmt = $conn->prepare("DELETE FROM tbl_scholarship WHERE scholarship_no = ?");
            $stmt->bind_param("s", $scholarship_no);
            $stmt->execute();

            $stmt = $conn->prepare("DELETE FROM tbl_requirements WHERE scholarship_no = ?");
            $stmt->bind_param("s", $scholarship_no);
            $stmt->execute();

        }




        



    }

}


?>