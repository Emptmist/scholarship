<?php
date_default_timezone_set('Asia/Manila');
session_start();
ob_start();

include 'reverify.php';
include 'Time_Expiration.php';
non_activated_deletion($conn);


// Check if the session variable is set
// Check if the session variable is set
if (isset($_SESSION['Student_No'])) {
    // Redirect to the dashboard if the user is already logged in
    header("Location: ../stdntside/std_dash-view.php");
    exit();
}


if (isset($_SESSION['Admin_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ../adminside/admin_dash.php");
    exit();
}


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scholarships System</title>
    <!-- Bootstrap -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <!-- Icon website -->
    <link rel="icon" type="image/x-icon" href="logo.png">
    <!-- external -->
    <link href="loginpage.css" rel="stylesheet">
    <!--sweetalert2-->
    <script src="sweetalert2.all.min.js"></script>
    <link href="sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Navigation Bar -->
    <div class="row">
        <div class="col-sm-12 nav-fixed">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a href="homepage.php"><img src="logo.png" class="rounded float-start" alt="Logo" style="margin-left: 20px;"></a>
                    <a class="navbar-brand" href="homepage.php">SCHOLARSHIPS SYSTEM</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-left: 100px;">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="homepage.php#REQUIREMENTS">REQUIREMENTS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="homepage.php#BENEFITS">BENEFITS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="homepage.php#ABOUTS">ABOUT US</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="homepage.php#FAQ">FAQ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="homepage.php#CONTACTUS">CONTACT US</a>
                            </li>
                        </ul>
                        <div class="d-grid gap-2 d-md-block">
                            <a href="student_number.php">
                                <button class="btn btn-success" type="button">Sign Up</button>
                            </a>
                            <a href="login_page.php">
                                <button class="btn btn-success" type="button">Sign In</button>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Background Image -->
    <div class="bg-image"></div>

    <?php
    $conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $incorrect = " ";

    if (isset($_POST['signin'])) {
        $std = $_POST["std_number"];
        $password = $_POST["password"];

        // Check in tbl_student_acc
        $sql_student = "SELECT * FROM tbl_student_acc WHERE Student_No = ?";
        $stmt_student = $conn->prepare($sql_student);
        $stmt_student->bind_param("s", $std);
        $stmt_student->execute();
        $result_student = $stmt_student->get_result();

        // Check in tbl_admin_account
        $sql_admin = "SELECT * FROM tbl_admin_account WHERE Admin_id = ?";
        $stmt_admin = $conn->prepare($sql_admin);
        $stmt_admin->bind_param("s", $std);
        $stmt_admin->execute();
        $result_admin = $stmt_admin->get_result();

        $sql_super_admin = "SELECT * FROM tbl_super_admin_account WHERE Super_admin_Id = ?";
        $stmt_super_admin = $conn->prepare($sql_super_admin);
        $stmt_super_admin->bind_param("s", $std);
        $stmt_super_admin->execute();
        $result_super_admin = $stmt_super_admin->get_result();




        if ($result_student->num_rows > 0) {
            // Student login logic
            $row = $result_student->fetch_assoc();

            // check If email is Verified
            if ($row['Verification_Status'] == 1) {

                // Verify the password
                if (password_verify($password, $row['Password'])) {
                    $_SESSION['Student_No'] = $row['Student_No'];
                    $Student_No = $_SESSION['Student_No'];

                    // Get student's email
                    $email_sql = "SELECT Email_address FROM tbl_student_acc WHERE Student_No = ?";
                    $email_stmt = $conn->prepare($email_sql);
                    $email_stmt->bind_param("s", $std);
                    $email_stmt->execute();
                    $email_result = $email_stmt->get_result();
                    $email_row = $email_result->fetch_assoc();
                    $student_email = $email_row['Email_address'];

                    // Insert login record into tbl_student_history
                    $login_time = date('Y-m-d H:i:s');
                    $insert_history = "INSERT INTO tbl_student_history (email, login_time) VALUES (?, ?)";
                    $stmt_history = $conn->prepare($insert_history);
                    $stmt_history->bind_param("ss", $student_email, $login_time);
                    $stmt_history->execute();

                    // PERSONAL INFO
                    $sql_personal = "SELECT * FROM tbl_personal_info WHERE Student_No = ?";
                    $stmt_personal = $conn->prepare($sql_personal);
                    $stmt_personal->bind_param("i", $Student_No);
                    $stmt_personal->execute();
                    $result_per = $stmt_personal->get_result();

                    if ($result_per->num_rows > 0) {
                        while ($row = $result_per->fetch_assoc()) {
                            // Handle existing personal info
                        }
                    } else {
                        $insert_personal = "INSERT INTO tbl_personal_info (Student_No) VALUES (?)";
                        $stmt_insert_personal = $conn->prepare($insert_personal);
                        $stmt_insert_personal->bind_param("i", $Student_No);
                        $stmt_insert_personal->execute();
                    }

                    // ADDRESSS
                    $sql_address = "SELECT * FROM tbl_address WHERE Student_No = ?";
                    $stmt_address = $conn->prepare($sql_address);
                    $stmt_address->bind_param("i", $Student_No);
                    $stmt_address->execute();
                    $result_address = $stmt_address->get_result();

                    if ($result_address->num_rows > 0) {
                        while ($row = $result_address->fetch_assoc()) {
                        }
                    } else {
                        $insert_address = "INSERT INTO tbl_address (Student_No) VALUES (?)";
                        $stmt_insert_address = $conn->prepare($insert_address);
                        $stmt_insert_address->bind_param("i", $Student_No);
                        $stmt_insert_address->execute();
                    }

                    // MOTHER INFO
                    $sql_m_info = "SELECT * FROM tbl_mother_info WHERE Student_No = ?";
                    $stmt_m_info = $conn->prepare($sql_m_info);
                    $stmt_m_info->bind_param("i", $Student_No);
                    $stmt_m_info->execute();
                    $result_m_info = $stmt_m_info->get_result();

                    if ($result_m_info->num_rows > 0) {
                        while ($row = $result_m_info->fetch_assoc()) {
                        }
                    } else {
                        $insert_motherInfo = "INSERT INTO tbl_mother_info (Student_No) VALUES (?)";
                        $stmt_insert_motherInfo = $conn->prepare($insert_motherInfo);
                        $stmt_insert_motherInfo->bind_param("i", $Student_No);
                        $stmt_insert_motherInfo->execute();
                    }

                    // FATHER INFO
                    $sql_f_info = "SELECT * FROM tbl_father_info WHERE Student_No = ?";
                    $stmt_f_info = $conn->prepare($sql_f_info);
                    $stmt_f_info->bind_param("i", $Student_No);
                    $stmt_f_info->execute();
                    $result_f_info = $stmt_f_info->get_result();

                    if ($result_f_info->num_rows > 0) {
                        while ($row = $result_f_info->fetch_assoc()) {
                        }
                    } else {
                        $insert_fatherInfo = "INSERT INTO tbl_father_info (Student_No) VALUES (?)";
                        $stmt_insert_fatherInfo = $conn->prepare($insert_fatherInfo);
                        $stmt_insert_fatherInfo->bind_param("i", $Student_No);
                        $stmt_insert_fatherInfo->execute();
                    }

                    // ELEMENTARY BACKGROUND
                    $sql_elementary = "SELECT * FROM tbl_elem_edu_bg WHERE Student_No = ?";
                    $stmt_elementary = $conn->prepare($sql_elementary);
                    $stmt_elementary->bind_param("i", $Student_No);
                    $stmt_elementary->execute();
                    $result_elem = $stmt_elementary->get_result();

                    if ($result_elem->num_rows > 0) {
                        while ($row = $result_elem->fetch_assoc()) {
                        }
                    } else {
                        $insert_elem = "INSERT INTO tbl_elem_edu_bg (Student_No) VALUES (?)";
                        $stmt_insert_elem = $conn->prepare($insert_elem);
                        $stmt_insert_elem->bind_param("i", $Student_No);
                        $stmt_insert_elem->execute();
                    }

                    // JUNIOR HIGH SCHOOL BACKGROUND
                    $sql_jh = "SELECT * FROM tbl_jh_edu_bg WHERE Student_No = ?";
                    $stmt_jh = $conn->prepare($sql_jh);
                    $stmt_jh->bind_param("i", $Student_No);
                    $stmt_jh->execute();
                    $result_jh = $stmt_jh->get_result();

                    if ($result_jh->num_rows > 0) {
                        while ($row = $result_jh->fetch_assoc()) {
                        }
                    } else {
                        $insert_jhs = "INSERT INTO tbl_jh_edu_bg (Student_No) VALUES (?)";
                        $stmt_insert_jhs = $conn->prepare($insert_jhs);
                        $stmt_insert_jhs->bind_param("i", $Student_No);
                        $stmt_insert_jhs->execute();
                    }

                    // SENIOR HIGH SCHOOL BACKGROUND
                    $sql_sh = "SELECT * FROM tbl_sh_edu_bg WHERE Student_No = ?";
                    $stmt_sh = $conn->prepare($sql_sh);
                    $stmt_sh->bind_param("i", $Student_No);
                    $stmt_sh->execute();
                    $result_sh = $stmt_sh->get_result();

                    if ($result_sh->num_rows > 0) {
                        while ($row = $result_sh->fetch_assoc()) {
                        }
                    } else {
                        $insert_shs = "INSERT INTO tbl_sh_edu_bg (Student_No) VALUES (?)";
                        $stmt_insert_shs = $conn->prepare($insert_shs);
                        $stmt_insert_shs->bind_param("i", $Student_No);
                        $stmt_insert_shs->execute();
                    }

                    // COLLEGE BACKGROUND
                    $sql_college = "SELECT * FROM tbl_college_edu WHERE Student_No = ?";
                    $stmt_college = $conn->prepare($sql_college);
                    $stmt_college->bind_param("i", $Student_No);
                    $stmt_college->execute();
                    $result_college = $stmt_college->get_result();

                    if ($result_college->num_rows > 0) {
                        while ($row = $result_college->fetch_assoc()) {
                        }
                    } else {
                        $insert_college = "INSERT INTO tbl_college_edu (Student_No) VALUES (?)";
                        $stmt_insert_college = $conn->prepare($insert_college);
                        $stmt_insert_college->bind_param("i", $Student_No);
                        $stmt_insert_college->execute();
                    }

                    // PICTURE
                    $sql_picture = "SELECT * FROM tb_id_picture WHERE Student_No = ?";
                    $stmt_picture = $conn->prepare($sql_picture);
                    $stmt_picture->bind_param("i", $Student_No);
                    $stmt_picture->execute();
                    $result_pic = $stmt_picture->get_result();

                    if ($result_pic->num_rows > 0) {
                        while ($row = $result_pic->fetch_assoc()) {
                        }
                    } else {
                        $insert_picture = "INSERT INTO tb_id_picture (Student_No) VALUES (?)";
                        $stmt_insert_picture = $conn->prepare($insert_picture);
                        $stmt_insert_picture->bind_param("i", $Student_No);
                        $stmt_insert_picture->execute();
                    }

                    // PSA
                    $sql_tbl_psa = "SELECT * FROM tbl_psa WHERE Student_No = ?";
                    $stmt_tbl_psa = $conn->prepare($sql_tbl_psa);
                    $stmt_tbl_psa->bind_param("i", $Student_No);
                    $stmt_tbl_psa->execute();
                    $result_psa = $stmt_tbl_psa->get_result();

                    if ($result_psa->num_rows > 0) {
                        while ($row = $result_psa->fetch_assoc()) {
                        }
                    } else {
                        $insert_psa = "INSERT INTO tbl_psa (Student_No) VALUES (?)";
                        $stmt_insert_psa = $conn->prepare($insert_psa);
                        $stmt_insert_psa->bind_param("i", $Student_No);
                        $stmt_insert_psa->execute();
                    }

                    echo "<script>window.location.href='../stdntside/std_dash-view.php';</script>";
                    exit;
                } else {
                    $incorrect = "Incorrect ID number or password.";
                }
            } else {
                $incorrect = "Your Email is not yet Verified";
            }
        } else if ($result_admin->num_rows > 0) {
            // Admin login logic
            $row = $result_admin->fetch_assoc();

            // Verify the password
            if (password_verify($password, $row['Password'])) {
                $_SESSION['Admin_id'] = $row['Admin_id'];
                $Admin_id = $_SESSION['Admin_id'];

                // Get admin's email
            $email_sql = "SELECT Email FROM tbl_admin_account WHERE Admin_id = ?";
            $email_stmt = $conn->prepare($email_sql);
            $email_stmt->bind_param("s", $std);
            $email_stmt->execute();
            $email_result = $email_stmt->get_result();
            $email_row = $email_result->fetch_assoc();
            $admin_email = $email_row['Email'];

            // Insert login record into tbl_admin_history
            $login_time = date('Y-m-d H:i:s');
            $insert_history = "INSERT INTO tbl_admin_history (email, login_time) VALUES (?, ?)";
            $stmt_history = $conn->prepare($insert_history);
            $stmt_history->bind_param("ss", $admin_email, $login_time);
            $stmt_history->execute();

                // PERSONAL INFO
                $sql_personal = "SELECT * FROM tbl_admin_personal_info WHERE Admin_id = ?";
                $stmt_personal = $conn->prepare($sql_personal);
                $stmt_personal->bind_param("i", $Admin_id);
                $stmt_personal->execute();
                $result_per = $stmt_personal->get_result();

                if ($result_per->num_rows > 0) {
                    while ($row = $result_per->fetch_assoc()) {
                        // Handle existing personal info
                    }
                } else {
                    $insert_personal = "INSERT INTO tbl_admin_personal_info (Admin_id) VALUES (?)";
                    $stmt_insert_personal = $conn->prepare($insert_personal);
                    $stmt_insert_personal->bind_param("i", $Admin_id);
                    $stmt_insert_personal->execute();
                }

                // ADMIN PROFILE PIX
                $sql_admin_pic = "SELECT * FROM tbl_admin_profile_picture WHERE Admin_id = ?";
                $stmt_admin_pic = $conn->prepare($sql_admin_pic);
                $stmt_admin_pic->bind_param("i", $Admin_id);
                $stmt_admin_pic->execute();
                $result_adpic = $stmt_admin_pic->get_result();

                if ($result_adpic->num_rows > 0) {
                    while ($row = $result_adpic->fetch_assoc()) {
                        // Handle existing personal info
                    }
                } else {
                    $insert_PROFILE_PIC = "INSERT INTO tbl_admin_profile_picture (Admin_id) VALUES (?)";
                    $stmt_insert_PROFILE_PIC = $conn->prepare($insert_PROFILE_PIC);
                    $stmt_insert_PROFILE_PIC->bind_param("i", $Admin_id);
                    $stmt_insert_PROFILE_PIC->execute();
                }

                // Repeat similar logic for other tables as needed
                // ...

                echo "<script>window.location.href='../adminside/admin_dash.php';</script>";
                exit;
            } else {
                $incorrect = "Incorrect ID number or password.";
            }
        } else if ($result_super_admin->num_rows > 0) {

            $row = $result_super_admin->fetch_assoc();

            if ($password == $row['Password']) {

                $_SESSION['Super_admin_Id'] = $row['Super_admin_Id'];
                

                echo "<script>window.location.href='../superadmin/superadmin_dashboard.php';</script>";
                exit;
            } else {
                $incorrect = "Incorrect ID number or password.";
            }
        } else {
            $incorrect = "ID not existing.";
        }
    }
    ob_end_flush();
    ?>



    <!-- Login Form -->

    <?php

    if (isset($_SESSION['status'])) {
        echo $_SESSION['status'];
        unset($_SESSION['status']);
    }

    ?>


    <div class="form-container">
        <div class="imagecontainer">
            <img src="login.png" alt="Login Image" style="width: 500px; height: 500px;">
        </div>
        <div class="form-content">
            <form action="" method="post">
                <h4 style="padding-left:2px; font-family:Inter; color:#25A55F;">Log in to your account</h4><br><br>
                <label for="email">ID Number:</label>
                <div class="input-container">
                    <input type="text" id="email" placeholder="Enter your ID Number" name="std_number" required oninput="validateNumberInput(event)" maxlength="9">
                    <!-- <img src="emaill.png" alt="Email Icon"> -->
                </div>
                <label for="psw">Password:</label>
                <div class="input-container">
                    <input type="password" id="pass" placeholder="Enter your password" name="password" required>
                    <!-- <img src="eye.png" alt="Eye Icon"> -->
                    <span style="color: red; font-size:15px;"><?php echo "$incorrect" ?></span><br>
                </div>
                <input type="checkbox" onclick="myFunction()"><span style="color: #25A55F;"> Show Password</span> <br><br>
                <a href="forgot_pass.php">
                    <p style="color: #25A55F;">Forgot Password</p>
                </a>
                <button type="submit" name="signin">SIGN IN</button>
                <h5 style="padding-left:20px; padding-top:15px; font-family:Inter; color:#25A55F; font-size:15px;">Don't you have an account? <a href="student_number.php">Sign up</a></h5>
            </form>
        </div>
    </div>
</body>

<!-- javascript  -->
<script src="bootstrap.bundle.min.js"></script>
<script src="bootstrap.min.js"></script>
<script>
    //show pass
    function myFunction() {
        var x = document.getElementById("pass");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function validateNumberInput(event) {
        // Get the value of the input field
        const inputField = event.target;
        const value = inputField.value;

        // Regular expression to allow only numbers
        const regex = /^[0-9]*$/;

        // Validate the input value against the regex
        if (!regex.test(value)) {
            // Remove the last character if it's not a number
            inputField.value = value.slice(0, -1);
        }
        const inputFieldlen = event.target;
        const maxLength = inputFieldlen.getAttribute('maxlength');
        const currentLength = inputFieldlen.value.length;

        // Check if the current length exceeds the maximum length
        if (currentLength >= maxLength) {
            // Prevent additional input
            inputFieldlen.value = inputFieldlen.value.slice(0, maxLength);
        }
    }
</script>

</html> 