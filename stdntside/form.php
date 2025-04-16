<?php

    session_start();

    $conn= mysqli_connect("localhost","root","","db_scholarship_system");

    // Check if the session variable is set
    if (isset($_SESSION['Student_No'])) {
        $student_no = $_SESSION['Student_No'];


    } else {

    }

    // Fetch data from database
    $sql = "SELECT * FROM tbl_student_acc WHERE Student_No = $student_no";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $student_No = $row['Student_No'];
            $Email_Address = $row['Email_Address'];
            $Password = $row['Password'];
        }
    }

    

    // if(isset($_POST['save-form']) && isset($_POST['check'])) {

        // //personal info
        // $lastName = $_POST['lastName'];
        // $firstName = $_POST['firstName'];
        // $middleName = $_POST['middleName'];
        // $civilStatus = $_POST['civilStatus'];
        // $birthDate = $_POST['birthDate'];
        // $birthPlace = $_POST['birthPlace'];
        // $nationality = $_POST['nationality'];
        // $religion = $_POST['religion'];
        // $phoneNo = $_POST['phoneNo'];
        // $age = $_POST['age'];
        // $email = $_POST['email'];

        // //address
        // $region = $_POST['region'];
        // $province = $_POST['province'];
        // $municipality = $_POST['municipality'];
        // $hnsb = $_POST['hnsb'];

        // //mother info
        // $mLastName = $_POST['mLastName'];
        // $mFirstName = $_POST['mFirstName'];
        // $mMiddleI = $_POST['mMiddleI'];
        // $mOccupation = $_POST['mOccupation'];
        // $mConNo = $_POST['mConNo'];
        // $mCitizen = $_POST['mCitizen'];
        // $mReligion = $_POST['mReligion'];

        // //father info
        // $fLastName = $_POST['fLastName'];
        // $fFirstName = $_POST['fFirstName'];
        // $fMiddleI = $_POST['fMiddleI'];
        // $fOccupation = $_POST['fOccupation'];
        // $fConNo = $_POST['fConNo'];
        // $fCitizen = $_POST['fCitizen'];
        // $fReligion = $_POST['fReligion'];

        // //educational background
        // $elementary = $_POST['elementary'];
        // $jrHigh = $_POST['jrHigh'];
        // $srHigh = $_POST['srHigh'];
        // $college = $_POST['college'];
        // $elemYrGrad = $_POST['elemYrGrad'];
        // $jrYrGrad = $_POST['jrYrGrad'];
        // $srYrGrad = $_POST['srYrGrad'];
        // $clgYrGrad = $_POST['clgYrGrad'];
        // $degreeCourse = $_POST['degreeCourse'];
        // $unit = $_POST['unit'];
        // $gpa = $_POST['gpa'];

    //     //reference info
    //     $fullName = $_POST['fullName'];
    //     $fullAddress = $_POST['fullAddress'];
    //     $rConNo = $_POST['rConNo'];


    //     /*$tbl1 = "INSERT INTO tbl_personal_info (Last_Name, First_Name, Middle_Name, Date_of_Birth, Place_Of_Birth,
    //      Gender, Nationality, Religion, Age, Civil_Status, Phone_No, Email) VALUES ('$lastName','$firstName','$middleName',
    //      '$civilStatus','$birthDate','$birthPlace','$nationality','$religion','$phoneNo','$age','$email')";

    //     $tbl1_insert = mysqli_query($conn, $tbl1);

    //     if ($tbl1_insert) {
    //         echo "nice";
    //     }
        
    //     INSERT INTO tbl_personal_info (Student_No, Last_Name, First_Name, Middle_Name, Civil_Status, Date_of_Birth, Place_Of_Birth, Nationality, Religion, Phone_No, Age, Email)
    //         VALUES ($student_no,'$lastName', '$firstName', '$middleName', '$civilStatus', '$birthDate', '$birthPlace', '$nationality', '$religion', '$phoneNo', '$age', '$email');

    //         INSERT INTO tbl_address (Student_No, Region, Province, Municipality, House_No_Street_Barangay)
    //         VALUES ($student_no,'$region', '$province', '$municipality', '$hnsb');

    //         INSERT INTO tbl_mother_info (Student_No, M_Last_Name, M_First_Name, M_MI, M_Occupation, M_Contact_No, M_Citizenship, M_Religion)
    //         VALUES ($student_no,'$mLastName', '$mFirstName', '$mMiddleI', '$mOccupation', '$mConNo', '$mCitizen', '$mReligion');

    //         INSERT INTO tbl_father_info (Student_No, F_Last_Name, F_First_Name, F_MI, F_Occupation, F_Contact_No, F_Citizenship, F_Religion)
    //         VALUES ($student_no,'$fLastName', '$fFirstName', '$fMiddleI', '$fOccupation', '$fConNo', '$fCitizen', '$fReligion');

    //         INSERT INTO tbl_elem_edu_bg (Student_No, Elem_Name_of_school, Elem_Year_graduated)
    //         VALUES ($student_no,'$elementary', '$elemYrGrad');

    //         INSERT INTO tbl_jh_edu_bg (Student_No, JH_Name_of_school, JH_Year_graduated)
    //         VALUES ($student_no,'$jrHigh', '$jrYrGrad');

    //         INSERT INTO tbl_sh_edu_bg (Student_No, SH_Name_of_school, SH_Year_graduated)
    //         VALUES ($student_no,'$srHigh', '$srYrGrad');

    //         INSERT INTO tbl_college_edu (Student_No, C_Name_of_school, C_Year_graduated, C_Degree_Course, C_Degree_Unit, C_GPA)
    //         VALUES ($student_no,'$college', '$clgYrGrad', '$degreeCourse', '$unit', '$gpa');
        
        
    //     */

    //     // $query = "
            

    //     //         INSERT INTO tbl_reference (Student_No, R_Full_Name, R_Full_Address, R_Contact_No)
    //     //         VALUES ($student_no,'$fullName', '$fullAddress', '$rConNo');
    //     //     ";

    //     $sql_form = "INSERT INTO tbl_reference (Student_No, R_Full_Name, R_Full_Address, R_Contact_No) VALUES ($student_No, '$fullName', '$fullAddress', '$rConNo')";
    //     mysqli_query($conn, $sql_form);

    //     echo "<script>Swal.fire({
    //         title: 'SAVED',
    //         text: 'Successfully Completed!',
    //         icon: 'success',
    //         showConfirmButton: false,
    //         timer: 1500
    //         });</script>";
        

    // }


    if (isset($_POST['save-form']) && isset($_POST['check'])) {

        //reference info
        $fullName = $_POST['fullName'];
        $fullAddress = $_POST['fullAddress'];
        $rConNo = $_POST['rConNo'];

        $sql_form = "INSERT INTO tbl_reference (Student_No, R_Full_Name, R_Full_Address, R_Contact_No) VALUES ($student_No, '$fullName', '$fullAddress', '$rConNo')";
        $result = mysqli_query($conn, $sql_form);

        echo "<script>Swal.fire({
            title: 'SAVED',
            text: 'Successfully Completed!',
            icon: 'success',
            showConfirmButton: false,
            timer: 1500
            });</script>";
    }
    else{
        $sql = "SELECT * FROM tbl_reference WHERE Student_No = $student_No";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $fullName = $row['R_Full_Name'];
                $fullAddress = $row['R_Full_Address'];
                $rConNo = $row['R_Contact_No'];
            }
        }
        else {
            // If no data is found, keep the variables as empty strings (inputs will be blank)
            $fullName = "";
            $fullAddress = "";
            $rConNo = "";
        }
    }

?>
<!--sweetalert2-->
<script src="sweetalert2.all.min.js"></script>
<link href="sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>