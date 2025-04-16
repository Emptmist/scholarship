<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

// Check if the session variable is set
if (isset($_SESSION['scholarship_no'])) {
    $scholarship_no = $_SESSION['scholarship_no'];
} else {
    echo "No student number found in session.";
}
// Check if the session variable is set
if (!isset($_SESSION['Student_No'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ../homepage/login_page.php");
    exit();
}else{
    $student_no = $_SESSION['Student_No'];
}

if (isset($_POST['view-attach'])) {
    $Name_Attachment = $_POST['attachment_name1'];
    $button_id = $_POST['button_id'];


    $sql_attach = "SELECT * FROM tbl_req_attachment WHERE Student_No = $student_no  AND no_req = $button_id";
    $res = mysqli_query($conn, $sql_attach);

    if (mysqli_num_rows($res) > 0) {
        while ($attach = mysqli_fetch_assoc($res)) {
            $attach_url = $attach['Name_Attachment'];
            $attach_ext = pathinfo($attach_url, PATHINFO_EXTENSION);
            if ($attach_ext === 'pdf') {
                header("content-type: application/pdf");
                readfile("UPLOAD_files/" . $attach_url);
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>

    <!--bootstrap-->
    <link href="bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap.bundle.min.js"></script>
    <script src="bootstrap.min.js"></script>

    <!--icons-->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!--icon website-->
    <link rel="icon" type="image/x-icon" href="logo.png">

    <!--css-->
    <link rel="stylesheet" href="std_dash.css">

    <!-- STYLESHEET -->
    <link rel="stylesheet" href="style.css">

    <!-- FONTAWESOME -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!--sweetalert2-->
    <script src="sweetalert2.all.min.js"></script>
    <link href="sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <!-- Side bar -->
    <div class="sidebar open">
        <div class="home-content">
            <i class='bx bx-menu'></i>
        </div>
        <div class="logo-details justify-content-center">
            <span class="logo_name">SCHOLARSHIP SYSTEM</span>
        </div>
        <ul class="nav-links">
            <li style="border-radius: 5px;
background: rgba(244, 244, 244, 0.20);
box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.25);">
                <a href="std_dash-view.php">
                    <i class='bx bxs-home'></i>
                    <span class="link_name">DASHBOARD</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">DASHBOARD</a></li>
                </ul>
            </li>
            <li>
                <a href="std_info.php">
                    <i class='bx bxs-user'></i>
                    <span class="link_name">PERSONAL INFO</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">PERSONAL INFO</a></li>
                </ul>
            </li>
            <li>
                <a href="std_attach.php">
                    <i class='bx bxs-copy-alt'></i>
                    <span class="link_name">ATTACHMENT</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">ATTACHMENT</a></li>
                </ul>
            </li>
            <li>
                <a href="" id="logout-link">
                    <i class='bx bxs-log-out'></i>
                    <span class="link_name ">LOG OUT</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">LOG OUT</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <section class="home-section ">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <span class=" ms-4 fw-bold">SCHOLARSHIP</span>
                <div class="d-flex ms-auto">
                    <a href="#" class="nav-link d-flex align-items-center">
                        <span class="me-2 fw-normal">STUDENT</span>
                        <i class='bx bxs-user-circle custom-icon'></i>
                    </a>
                </div>
            </div>
        </nav>

        <hr>
        <?php
        $conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

        // Fetch data from database
        $sql = "SELECT * FROM tbl_scholarship WHERE scholarship_no = $scholarship_no";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $scholarship_name = $row['scholarship_name'];
                $description = $row['description'];
                $qualifications = $row['qualifications'];
                $start_of_application = $row['start_of_applications'];
                $end_of_application = $row['end_of_applications'];
            }
        }
        



        function handleFileUpload($file, $student_no, $table, $conn, $allowed_exs, $req_name1, $req_name_int,$scholarship_no)
        {
            $img_name = $file['name'];
            $img_size = $file['size'];
            $tmp_name = $file['tmp_name'];
            $error = $file['error'];



            if ($error === 0) {
                if ($img_size > 4194304) { // 4MB limit
                    echo "<script>Swal.fire({
                            icon: 'error',
                            title: 'File too large',
                            showConfirmButton: false,
                            timer: 1500
                            });</script>";
                    return false;
                } else {
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);

                    if (in_array($img_ex_lc, $allowed_exs)) {
                        $new_img_name = uniqid($req_name1 . '-', true) . '.' . $img_ex_lc;
                        $img_upload_path = 'UPLOAD_files/' . $new_img_name;
                        if (move_uploaded_file($tmp_name, $img_upload_path)) {
                            $check_sql = "SELECT * FROM $table WHERE Student_No = $student_no AND no_req = $req_name_int AND scholarship_no = $scholarship_no";
                            $check_result = mysqli_query($conn, $check_sql);

                            if (mysqli_num_rows($check_result) > 0) {
                                echo "<script>Swal.fire({
                                        icon: 'error',
                                        title: 'Duplicate $req_name1',
                                        text: 'This requirement has already been uploaded.',
                                        showConfirmButton: false,
                                        timer: 1500
                                        });</script>";
                                return false;
                            } else {
                                // INSERT INTO DATABASE
                                $sql = "INSERT INTO $table (Student_No, Name_Attachment, no_req, scholarship_no) VALUES ($student_no, '$new_img_name', $req_name_int, $scholarship_no)";
                                if (mysqli_query($conn, $sql)) {
                                    echo "<script>Swal.fire({
                                            title: 'SAVED',
                                            text: 'Successfully uploaded!',
                                            icon: 'success',
                                            showConfirmButton: false,
                                            timer: 1500
                                            })
                                            </script>";
                                    return $new_img_name;
                                    // Return the new image name for display
                                }
                            }
                        } else {
                            echo "<script>Swal.fire({
                                    icon: 'error',
                                    title: 'Failed to move uploaded file',
                                    showConfirmButton: false,
                                    timer: 1500
                                    });</script>";
                            return false;
                        }
                    } else {
                        echo "<script>Swal.fire({
                                icon: 'error',
                                title: 'Invalid file type',
                                showConfirmButton: false,
                                timer: 1500
                                });</script>";
                        return false;
                    }
                }
            } else {
                echo "<script>Swal.fire({
                        icon: 'error',
                        title: 'An error occurred during file upload: error code $error',
                        showConfirmButton: false,
                        timer: 1500
                        });</script>";
                return false;
            }
        }

        if (isset($_POST['upload_files'])) {
            $file = isset($_FILES['attach_upload']) ? $_FILES['attach_upload'] : null;
            $allowed_exs = array('pdf'); // Specify allowed extensions for this upload
            $req_name = $_POST['req_name'];
            $req_name_int = intval($req_name); // Get the selected requirement name
            $student_no = $student_no; // Replace with actual student number
            $sql = "SELECT * FROM tbl_requirements WHERE no_req = $req_name_int AND scholarship_no = $scholarship_no";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $req_name1 = $row['req_name'];
                }
            }

            if ($file && $file['error'] !== UPLOAD_ERR_NO_FILE) {
                $new_img_name = handleFileUpload($file, $student_no, 'tbl_req_attachment', $conn, $allowed_exs, $req_name1, $req_name_int,$scholarship_no);
                if ($new_img_name) {
                    $_SESSION['uploaded_file_name'] = $new_img_name; // Store the uploaded file name in session for display
                }
            }
        }


        // Fetch data from database
        $sql_attach = "SELECT * FROM tbl_req_attachment WHERE Student_No = $student_no";
        $result_attach = $conn->query($sql_attach);

        if ($result_attach->num_rows > 0) {
            while ($row = $result_attach->fetch_assoc()) {
                $Student_No = $row['Student_No'];
                $Name_Attachment = $row['Name_Attachment'];
            }
        } else {
            $Name_Attachment = " ";
        }





        if (isset($_POST['scholarship_apply_button'])) {
            // Check if student has incomplete personal info or grades
            $sql_incomplete_data = "SELECT s.Student_No
                                FROM tbl_student_acc s
                                LEFT JOIN tbl_personal_info personal ON s.Student_No = personal.Student_No
                                LEFT JOIN tb_id_picture pic ON s.Student_No = pic.Student_No
                                LEFT JOIN tbl_psa psa ON s.Student_No = psa.Student_No
                                LEFT JOIN tbl_address addre ON s.Student_No = addre.Student_No
                                LEFT JOIN tbl_mother_info mother ON s.Student_No = mother.Student_No
                                LEFT JOIN tbl_father_info father ON s.Student_No = father.Student_No
                                LEFT JOIN tbl_elem_edu_bg elem ON s.Student_No = elem.Student_No
                                LEFT JOIN tbl_jh_edu_bg jh ON s.Student_No = jh.Student_No
                                LEFT JOIN tbl_sh_edu_bg sh ON s.Student_No = sh.Student_No
                                LEFT JOIN tbl_college_edu col ON s.Student_No = col.Student_No
                                LEFT JOIN tbl_req_attachment atach ON s.Student_No = atach.Student_No

                                LEFT JOIN (
                                    SELECT req_sub.Student_No, COUNT(req_sub.no_req) AS submitted_count
                                    FROM tbl_req_attachment req_sub
                                    WHERE req_sub.scholarship_no = $scholarship_no AND Student_No = $student_no
                                    GROUP BY req_sub.Student_No
                                ) AS submitted_req ON submitted_req.Student_No = s.Student_No

                                LEFT JOIN (
                                    SELECT req_total.scholarship_no, COUNT(req_total.no_req) AS Requirements_count
                                    FROM tbl_requirements req_total
                                    WHERE req_total.scholarship_no = $scholarship_no
                                    GROUP BY req_total.scholarship_no
                                ) AS total_req ON total_req.scholarship_no = $scholarship_no
                
                                WHERE s.Student_No = $student_no
                                AND (
                                    personal.First_name IS NULL OR
                                    -- Add other personal info columns as needed
                                    pic.img_url IS NULL OR
                                    -- Add other grade columns as needed
                                    psa.PSA_url IS NULL OR
                                    -- Add other grade columns as needed
                                    addre.Region IS NULL OR
                                    -- Add other grade columns as needed
                                    mother.M_First_Name IS NULL OR
                                    -- Add other grade columns as needed
                                    father.F_First_Name IS NULL OR
                                    -- Add other grade columns as needed
                                    elem.Elem_Name_of_school IS NULL OR
                                    -- Add other grade columns as needed
                                    jh.JH_Name_of_school IS NULL OR
                                    -- Add other grade columns as needed
                                    sh.SH_Name_of_school IS NULL OR
                                    -- Add other grade columns as needed
                                    col.C_GPA IS NULL OR
                                    NOT EXISTS (
                                        SELECT 1 
                                        FROM tbl_req_attachment atach 
                                        WHERE atach.Student_No = s.Student_No 
                                        AND atach.scholarship_no = $scholarship_no
                                    ) OR
                                    
                                    submitted_req.submitted_count < total_req.Requirements_count
                                )";

            $result_incomplete_data = $conn->query($sql_incomplete_data);
            if ($result_incomplete_data->num_rows > 0) {
                // Show pop-up for missing personal info
                echo '<script>
                                    Swal.fire({
                                        title: "INCOMPLETE DATA!",
                                        text: "Please complete all required personal information before submitting your application.",
                                        icon: "warning",
                                        iconColor: "#f44336",
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#f44336"
                                    });
                                </script>';
            } else {
                // checking if applied
                $sql_scholarship = "SELECT * FROM tbl_application_scholarship WHERE Student_No = $student_no AND scholarship_no = $scholarship_no ";
                $result_as = $conn->query($sql_scholarship);

                if ($result_as->num_rows > 0) {
                    while ($row = $result_as->fetch_assoc()) {
                        // Handle existing reference
                        echo '<script>
                                        Swal.fire({
                                            title: "ALREADY SUBMITTED!",
                                            text: "You have already submitted your application!",
                                            icon: "info",
                                            iconColor: "#346473",
                                            confirmButtonText: "OK",
                                            confirmButtonColor: "#346473"
                                        });
                                      </script>';
                    }
                } else {
                    $insert_application = "INSERT INTO tbl_application_scholarship(Student_No, scholarship_no, C_status,rejection_reason, application_date) VALUES ($student_no, $scholarship_no, 'pending','Application still in process. Thank you.', CURDATE())";
                    $result = mysqli_query($conn, $insert_application);

                    echo '<script>
                                    Swal.fire({
                                        title: "SUCCESS!",
                                        text: "Your application was submitted successfully!",
                                        icon: "success",
                                        iconColor: "#28a745",
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#28a745"
                                    });
                                  </script>';
                }
            }
        }



        ?>


        <div class="row">
            <div class="col-md-8">
                <div class="main-container">
                    <!--Title-->
                    <div class="row" style="text-align: center;">
                        <span class="main-style"><?php echo $scholarship_name; ?></span>
                        <p><?php echo $description; ?></p>
                    </div> <br>

                    <!--date-->
                    <div class="row">
                        <div class="col-sm-4"><span class="main-style">Application Start:</span></div>
                        <div class="col-sm-3">
                            <p class="pclass"> <?php echo $start_of_application; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"><span class="main-style">Application Deadline:</span></div>
                        <div class="col-sm-3">
                            <p class="pclass"> <?php echo $end_of_application; ?></p>
                        </div>
                    </div> <br>

                    <!--Reqs-->
                    <div class="row">
                        <div class="col-sm-3"><span class="main-style">Qualifications:</span></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-9">
                            <p>
                                <?php echo $qualifications; ?>
                            </p>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-3"><span class="main-style">List of Requirements:</span></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-9">
                            <p>
                                <?php
                                $sql = "SELECT * FROM tbl_requirements WHERE scholarship_no = $scholarship_no";
                                $result = $conn->query($sql);
                                $options = ""; // Initialize options string
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $no_req1 = $row['no_req'];
                                        $req_name = $row['req_name'];
                                        $options .= "<option value='$no_req1'>$req_name</option>"; // Set value to no_req
                                    
                                        echo $no_req1 . ". " . $req_name . "<br>";
                                    }
                                }
                                ?>

                            </p>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-3"><span class="main-style">Attachment:</span></div>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-5 ">
                                <p style="font-size: 12px;">Note: The requirements need to be complete and correct. pdf files only with a size less than 4mb (4096 kb)</p>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-ipt" name="req_name" required placeholder="Select Requirements Name">
                                    <option value="" disabled selected>Select Requirements Name</option>
                                    <?php echo $options; ?>
                                </select>
                            </div>
                            <?php
                            // Check if the application is already submitted
                            $check_application_sql = "SELECT * FROM tbl_application_scholarship WHERE Student_No = $student_no AND scholarship_no = $scholarship_no";
                            $check_application_result = mysqli_query($conn, $check_application_sql);

                            $is_applied = mysqli_num_rows($check_application_result) > 0;
                            if ($is_applied): ?>
                                <div class="col-sm-2">
                                    <input type="file" id="uploadattachment" name="attach_upload" value="" accept="application/pdf" disabled>
                                    <label for="uploadattachment" class="bbutton" style="background-color: #acacac; color: white;">Click to Upload</label>
                                </div>
                                <div class="col-sm-1">
                                    <button type='submit' name='upload_files' id='upload_files' style="background-color: #acacac; color: white;" disabled>Save</i></button>
                                </div>
                            <?php else: ?>
                                <div class="col-sm-2">
                                    <input type="file" id="uploadattachment" name="attach_upload" value="" accept="application/pdf">
                                    <label for="uploadattachment" class="bbutton">Click to Upload</label>
                                </div>
                                <div class="col-sm-1">
                                    <button type='submit' name='upload_files' id='upload_files'>Save</i></button>
                                </div>
                            <?php endif; ?>

                        </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-9">
                            <h6 style="color: #C1C1C1;">Add Attach</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php



                            $sql = "SELECT * FROM tbl_req_attachment WHERE Student_No = $student_no AND scholarship_no = $scholarship_no";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $attachmentName = htmlspecialchars($row["Name_Attachment"]);
                                    $studentId = htmlspecialchars($row["Student_No"]);
                                    $buttonId = 'delete_attach_' . $row["no_attach"]; // Assuming 'req_no' is unique for each attachment
                                    $buttonId1 = htmlspecialchars($row["no_req"]);
                                    // Check if the application is already submitted
                                    $check_application_sql = "SELECT * FROM tbl_application_scholarship WHERE Student_No = $student_no AND scholarship_no = $scholarship_no";
                                    $check_application_result = mysqli_query($conn, $check_application_sql);

                                    $is_applied = mysqli_num_rows($check_application_result) > 0;

                                    if ($is_applied) {
                                        echo "
                                <div class='row'> 
                                    <div class='col-sm-12 req-attach' style='display: flex; align-items: center;'>
                                        <i style='margin-right: 50px; font-size: 20px;' class='bx bxs-file-pdf'></i>
                                        <span style='font-size: 15px; flex-grow: 1;'>$attachmentName</span>
                                        <form method='post' enctype='multipart/form-data' style='margin-left: auto;'>
                                             <input type='hidden' name='attachment_name1' value='" . htmlspecialchars($attachmentName) . "'>
                                             <input type='hidden' name='button_id' value='" . htmlspecialchars($buttonId1) . "'>
                                             <button style='background-color: #ffffff; font-size: 15px; color: #346473;' name='view-attach' type='submit'>view</button>
                                         </form>
 
                                        <form id='delete-form-$buttonId' method='POST' action='std_delete_attachment.php'>
                                            <input type='hidden' name='attachment_name' value='$attachmentName'>
                                            <input type='hidden' name='student_id' value='$studentId'>
                                            <button type='button' id='$buttonId' class='delete-btn' style='background: none; border: none; cursor: pointer;' disabled>
                                                <i style='font-size: 20px; color: #8a6161;' class='bx bxs-trash-alt'></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>";
                                    } else {
                                        echo "
                                    <div class='row'> 
                                        <div class='col-sm-12 req-attach' style='display: flex; align-items: center;'>
                                            <i style='margin-right: 50px; font-size: 20px;' class='bx bxs-file-pdf'></i>
                                            <span style='font-size: 15px; flex-grow: 1;'>$attachmentName</span>
                                            <form method='post' enctype='multipart/form-data' style='margin-left: auto;'>
                                                <input type='hidden' name='attachment_name1' value='" . htmlspecialchars($attachmentName) . "'>
                                                <input type='hidden' name='button_id' value='" . htmlspecialchars($buttonId1) . "'>
                                                <button style='background-color: #ffffff; font-size: 15px; color: #346473;' name='view-attach' type='submit'>view</button>
                                            </form>
    
                                            <form id='delete-form-$buttonId' method='POST' action='std_delete_attachment.php'>
                                                <input type='hidden' name='attachment_name' value='$attachmentName'>
                                                <input type='hidden' name='student_id' value='$studentId'>
                                                <button type='button' id='$buttonId' class='delete-btn' style='background: none; border: none; cursor: pointer;'>
                                                    <i style='font-size: 20px; color: #af2e2e;' class='bx bxs-trash-alt'></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>";
                                    }
                                }
                            }


                            ?>
                        </div>
                    </div><br>
                    <div class="save">
                        <?php
                        // Check if the application is already submitted
                        $check_application_sql = "SELECT * FROM tbl_application_scholarship WHERE Student_No = $student_no AND scholarship_no = $scholarship_no";
                        $check_application_result = mysqli_query($conn, $check_application_sql);

                        $is_applied = mysqli_num_rows($check_application_result) > 0;
                        ?>

                        <!-- Application Form -->
                        <form action="" method="post">
                            <?php if ($is_applied): ?>
                                <button type="button" class="button" style="padding: 7px 30px 7px 30px; background-color: #acacac; color: white;">Applied</button>
                            <?php else: ?>
                                <button type="submit" class="button" name="scholarship_apply_button" style="padding: 7px 30px 7px 30px;">Apply</button>
                            <?php endif; ?>
                        </form>
                    </div>

                </div>
            </div>

            <div class="col-md-4"> <br>

                <div class="row" style="padding: 2px;">
                    <div class="col-md-1"><i class='bx bx-calendar' style="font-size: 40px; color: #346373;"></i></div>
                    <div class="col-md-5" style="padding: 10px;">
                        <span class="text3" id="currentDate" style="color: #346373;font-size: 20px;"></span>
                    </div>
                </div>
                <div class="sub-container">
                    <div class="container">
                        <div class="calendar">
                            <div class="header">
                                <div class="month"></div>
                                <div class="btns">
                                    <div class="btn today-btn">
                                        <i class="fas fa-calendar-day"></i>
                                    </div>
                                    <div class="btn prev-btn">
                                        <i class="fas fa-chevron-left"></i>
                                    </div>

                                    <div class="btn next-btn">
                                        <i class="fas fa-chevron-right"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="weekdays">
                                <div class="day">Sun</div>
                                <div class="day">Mon</div>
                                <div class="day">Tue</div>
                                <div class="day">Wed</div>
                                <div class="day">Thu</div>
                                <div class="day">Fri</div>
                                <div class="day">Sat</div>
                            </div>

                            <div class="days">
                                <!-- lets add days using js -->
                            </div>
                        </div>
                    </div>

                    <!--notification REMINDER-->
                    <div class="notif">
                        <div class="row">
                            <div class="col-md-3">
                                <button class="btn btn-outline-primary w-100 filter-btn active" data-filter="today"><b>Today</b></button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-outline-primary w-100 filter-btn" data-filter="week"><b>Week</b></button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-outline-primary w-100 filter-btn" data-filter="month"><b>Month</b></button>
                            </div>
                        </div>
                        <br>

                        <div class="content1">
                            <div class="content-item today-content">
                                <div class="row">
                                    <div class="col-md-1 font-weight-bold" id="today-date"></div>
                                    &nbsp; &nbsp;
                                    <div class="col-md-1 font-weight-bold" id="today-day"></div>
                                    <div class="col-md-9" id="today-time"></div>
                                </div>
                                <div class="row" style="margin-top: 2%;">
                                    <div class="col-md-10" id="today-scholarships"></div>
                                </div>
                            </div>

                            <div class="content-item week-content d-none">
                                <div class="row">
                                    <div class="col-md-11" id="week-scholarships"></div>
                                </div>
                            </div>

                            <div class="content-item month-content d-none">

                                <div class="row">
                                    <div class="col-md-11" id="month-scholarships"></div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                    <!-- SCRIPT -->
                    <script src="script.js"></script>
                </div>

                <div>
                    <div class="sub-container"> <br>
                        <div class="trigger view" data-popup="popup1">
                            <button class="btn">
                                <span class="text-title"> ANNOUNCEMENT</span>
                                <p style="text-align: center;">View Details</p>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <?php

        // Fetch data announcement from database
        $sql = "SELECT * FROM tbl_announcement";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $title = $row['title'];
                $body = $row['body'];
            }
        }

        ?>

        <div id="popup1" class="popup">
            <div class="popup-content2">
                <span class="close-button"></span>
                <p class="fs-3">Announcements</p>
                <div id="data-wrapper"></div>
            </div>
        </div>

    </section>



    <div class="one"></div>

    <script>
        const sidebar = document.querySelector(".sidebar");
        const sidebarBtn = document.querySelector(".bx-menu");

        function toggleSidebar() {
            const viewportWidth = window.innerWidth;
            if (viewportWidth > 768) { // Only allow toggling if viewport is wider than 768px
                sidebar.classList.toggle("close");
            }
        }

        function handleResize() {
            const viewportWidth = window.innerWidth;
            if (viewportWidth <= 768) { // Close sidebar and disable toggle for small screens
                sidebar.classList.add("close");
                sidebarBtn.removeEventListener("click", toggleSidebar);
            } else {
                sidebarBtn.addEventListener("click", toggleSidebar);
            }
        }

        sidebarBtn.addEventListener("click", toggleSidebar);
        window.addEventListener("resize", handleResize);

        // Initial check
        handleResize();

        //popups handler
        document.addEventListener("DOMContentLoaded", () => {
            const triggers = document.querySelectorAll(".trigger");
            const popups = document.querySelectorAll(".popup");
            const closeButtons = document.querySelectorAll(".close-button");

            triggers.forEach(trigger => {
                trigger.addEventListener("click", () => {
                    const popupId = trigger.getAttribute("data-popup");
                    const popup = document.getElementById(popupId);
                    popup.style.display = "block";
                });
            });

            closeButtons.forEach(button => {
                button.addEventListener("click", () => {
                    popups.forEach(popup => {
                        popup.style.display = "none";
                    });
                });
            });

            window.addEventListener("click", (event) => {
                popups.forEach(popup => {
                    if (event.target === popup) {
                        popup.style.display = "none";
                    }
                });
            });
        });

        //announcement
        document.addEventListener('DOMContentLoaded', () => {
            const dataWrapper = document.getElementById('data-wrapper');
            const data = <?php
                            // Database connection details
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "db_scholarship_system";

                            // Create connection
                            $conn = new mysqli($servername, $username, $password, $dbname);

                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $sql = "SELECT title, body, post_date, zwhere, zwhen, ann_pic
                                    FROM tbl_announcement
                                    WHERE posted_to = 'all'
                                    OR posted_to IN (
                                    SELECT c_status
                                    FROM tbl_application_scholarship
                                    WHERE student_no = '$student_no'
                                    )
                                    ORDER BY no_announcement DESC";
                            $result = $conn->query($sql);

                            $announcements = array();

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $announcements[] = $row;
                                }
                            }

                            echo json_encode($announcements);

                            $conn->close();
                            ?>;

            data.forEach(item => {
                const div = document.createElement('div');
                div.className = 'data-container';

                const title = document.createElement('div');
                title.className = 'data-title';
                title.textContent = item.title;

                const postDate = document.createElement('div');
                postDate.className = 'data-post-date';


                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                postDate.textContent = new Date(item.post_date).toLocaleDateString(undefined, options);
                const formattedPostDate = new Date(item.post_date).toLocaleDateString(undefined, options);

                if (item.ann_pic) {
                    const img = document.createElement('img');
                    img.src = '../adminside/admin-UPLOAD_FILEs/announcement_images/' + item.ann_pic;
                    img.alt = 'Announcement Image';
                    
                }

                const content = document.createElement('div');
                content.className = 'data-content';
                content.textContent = item.body;

                const seeMoreButton = document.createElement('button');
                seeMoreButton.className = 'see-more';
                seeMoreButton.textContent = 'See More';
                seeMoreButton.addEventListener('click', () => {
                    Swal.fire({
                        title: item.title,
                        html: `
                            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                                <p style="margin: 0 0 20px 0; display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; margin-top: 2%;">
                                    <span><strong>When:</strong> ${item.zwhen || 'N/A'}</span>
                                    <span><strong>Where:</strong> ${item.zwhere || 'N/A'}</span>
                                </p>
                               ${item.ann_pic ? '<img src="../adminside/admin-UPLOAD_FILEs/announcement_images/' + item.ann_pic + '" style="width: 650px; height: 225px; object-fit: cover; position:relative; border-style: solid; border-radius:4px;">' : ''}
                                <p style="margin: 20px 0; max-width: 50%; word-wrap: break-word; margin-bottom: 2%;">
                                    ${item.body}
                                </p>
                                <p style="margin: 20px 0; max-width: 50%; word-wrap: break-word; margin-bottom: 2%;">
                                    <strong>Posted on:</strong> ${formattedPostDate}
                                </p>
                            </div>
                        `,
                        width: '80%',
                        padding: '3em',
                        background: '#fff',
                        confirmButtonText: 'Close'
                    });
                });

                div.appendChild(title);
                div.appendChild(postDate);
                div.appendChild(seeMoreButton);
                dataWrapper.appendChild(div);

                // Debugging statements
                console.log('Scroll Height:', content.scrollHeight);
                console.log('Client Height:', content.clientHeight);

                // Force button visibility for debugging
                seeMoreButton.style.display = 'inline-block';

                // Check if content exceeds the allowed height
                if (content.scrollHeight > content.clientHeight) {
                    seeMoreButton.style.display = 'inline-block';
                }
            });
        });
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const form = this.closest('form');
                const attachmentName = form.querySelector('input[name="attachment_name"]').value;
                const studentId = form.querySelector('input[name="student_id"]').value;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete.",
                    icon: 'warning',
                    iconColor: '#f44336',
                    showCancelButton: true,
                    confirmButtonColor: '#346473',
                    cancelButtonColor: '#f44336',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('std_delete_attachment.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    attachment_name: attachmentName,
                                    student_id: studentId
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: 'Student attachment deleted successfully.',
                                        icon: 'success',
                                        iconColor: '#f44336',
                                        confirmButtonColor: '#f44336'
                                    }).then(() => {
                                        window.location.href = "std_dash.php";
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'There was an error deleting the student attachment.',
                                        icon: 'error',
                                        confirmButtonColor: '#346473'
                                    });
                                }
                            });
                    }
                });
            });
        });


        /// log out button
        document.getElementById('logout-link').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default link click behavior
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out.",
                icon: 'warning',
                iconColor: '#346473',
                showCancelButton: true,
                confirmButtonColor: '#346473',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('../homepage/logout.php', {
                    method: 'GET', 
                    credentials: 'same-origin' 
                })
                .then(response => {
                    if (response.ok) {
                       
                        window.location.href = "../homepage/login_page.php";
                    } else {
                       
                        Swal.fire('Error', 'There was a problem logging out.', 'error');
                    }
                })
                .catch(error => {
                    
                    Swal.fire('Error', 'There was a problem with the network.', 'error');
                });
            }
        });
    });
    </script>

</body>

</html>