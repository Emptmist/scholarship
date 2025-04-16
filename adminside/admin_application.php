<?php 
        session_start();

        ob_start();
        $conn = new mysqli('localhost','root','','db_scholarship_system');

        if (!isset($_SESSION['Admin_id'])) {
            // Redirect to the login page if the user is not logged in
            header("Location: ../homepage/login_page.php");
            exit();
        }else{
            $Admin_id = $_SESSION['Admin_id'];
        }

        // Fetch scholarship data from the database
        $sql = "SELECT * FROM tbl_scholarship";
        $result = $conn->query($sql);

        $options = ""; // Initialize options string
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $scholarship_no = $row['scholarship_no'];
                $scholarship_name = $row['scholarship_name'];
                $options .= "<option value='$scholarship_no'>$scholarship_name</option>"; // Set value to scholarship_no
            }
        } else {
            $options = "<option value='' disabled>No scholarships available</option>"; // In case no data is found
        }
?>  
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- will change these link/script once actual file used in this link is found-->
    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!--icon website-->
    <link rel="icon" type="image/x-icon" href="logo.png">

    <!--icons-->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!-- own css -->
    <link rel="stylesheet" href="custom.css">

    <!--sweetalert2-->
    <script src="sweetalert2.all.min.js"></script>
    <link href="sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Scholarship Application</title>
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
            <li>
                <a href="admin_profile.php">
                    <i class='bx bxs-user'></i>
                    <span class="link_name">PROFILE</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">PROFILE</a></li>
                </ul>
            </li>
            <li>
                <a href="admin_dash.php">
                    <i class='bx bxs-home' ></i>
                    <span class="link_name">DASHBOARD</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">DASHBOARD</a></li>
                </ul>
            </li>
            <li style="border-radius: 5px;
background: rgba(244, 244, 244, 0.20);
box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.25);">
                <a href="admin_application.php">
                    <i class='bx bxs-copy-alt'></i>
                    <span class="link_name">APPLICATIONS</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">APPLICATIONS</a></li>
                </ul>
            </li>
            <li>
                <a href="scholarship.php">
                    <i class='bx bxs-graduation'></i>
                    <span class="link_name ">SCHOLARSHIP</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">SCHOLARSHIP</a></li>
                </ul>
            </li>
            <li>
                <a href="admin_setting.php">
                    <i class='bx bx-cog'></i>
                    <span class="link_name">SETTING</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">SETTING</a></li>
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
                <span class=" ms-4 fw-bold">SCHOLARSHIP APPLICATIONS</span>
                <div class="d-flex ms-auto">
                    <a href="#" class="nav-link d-flex align-items-center" style="color: #25A55F;">
                        <span class="me-2 fw-normal">SCHOLARSHIP COORDINATOR</span>
                        <i class='bx bxs-user-circle custom-icon'></i>
                    </a>
                </div>
            </div>
        </nav> 

        <hr>

        <!--- DEFAULT PENDING PAGE--->
        <div style="display: block;" id="div1">
        <div class="title-page">
            <span id="title-name">Pending Management Student Application</span>
        </div>
        <div class="main-container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="content-application">
                        <form action="" method="POST">
                            <select style="border: none; width:350px" class="application-btn" name="Scholarship_name">
                                <option value="" disabled selected>Select Scholarship Name</option>
                                <?php echo $options; ?>
                            </select>
                            <select style="border: none;" name="status_application" id="status_application" class="application-btn" onchange="handleStatusChange(this)">
                                <option value="pending"> Pending</option>
                                <option value="approved"> Approved</option>
                                <option value="rejected"> Rejected</option>
                            </select>
                            <input class="search-input" type="text" name="search-pending" value="<?php echo isset($_POST['search-pending']) ? htmlspecialchars($_POST['search-pending']) : ''; ?>" placeholder="   Search">
                            <button name="submit" value="submit-pending"><div class='bx bx-search'></div></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?php 
                            // Fetch all scholarship records from the tbl_scholarship table
                            $sql_select_scholarships = "SELECT * FROM tbl_scholarship";
                            $result_select_scholarships = $conn->query($sql_select_scholarships);

                            if ($result_select_scholarships->num_rows > 0) {
                                while ($row_scholarship = $result_select_scholarships->fetch_assoc()) {
                                    $end_of_applications = $row_scholarship['end_of_applications'];
                                    $scholarship_no = $row_scholarship['scholarship_no'];

                                    // Fetch applications where the application_date is greater than the end_of_applications date
                                    $sql_select_applications = "SELECT * FROM tbl_application_scholarship 
                                                                WHERE application_date > ? 
                                                                AND scholarship_no = ?";
                                    $stmt_select_applications = $conn->prepare($sql_select_applications);
                                    $stmt_select_applications->bind_param("si", $end_of_applications, $scholarship_no);
                                    $stmt_select_applications->execute();
                                    $result_select_applications = $stmt_select_applications->get_result();

                                    if ($result_select_applications->num_rows > 0) {
                                        while ($row_application = $result_select_applications->fetch_assoc()) {
                                            $Student_No = $row_application['Student_No'];
                                            $C_status = $row_application['C_status'];
                                            $rejection_reason = $row_application['rejection_reason'];
                                            $application_date = $row_application['application_date'];
                                            $Admin_id = $row_application['Admin_id'];

                                            // Insert the application into the archive table
                                            $sql_insert_archive = "INSERT INTO tbl_application_archive 
                                                                (Student_No, scholarship_no, C_status_archive, reason_archive, application_date_archive, Admin_id) 
                                                                VALUES (?, ?, ?, ?, ?, ?)";
                                            $stmt_insert_archive = $conn->prepare($sql_insert_archive);
                                            $stmt_insert_archive->bind_param("iisssi", $Student_No, $scholarship_no, $C_status, $rejection_reason, $application_date, $Admin_id);
                                            $stmt_insert_archive->execute();
                                        }

                                        // Delete the original records from the tbl_application_scholarship table
                                        $sql_delete_applications = "DELETE FROM tbl_application_scholarship 
                                                                    WHERE application_date > ? 
                                                                    AND scholarship_no = ?";
                                        $stmt_delete_applications = $conn->prepare($sql_delete_applications);
                                        $stmt_delete_applications->bind_param("si", $end_of_applications, $scholarship_no);
                                        $stmt_delete_applications->execute();

                                        if ($stmt_delete_applications->affected_rows > 0) {
                                            //echo "Records archived and deleted successfully.";
                                        } else {
                                            //echo "No records found for deletion.";
                                        }
                                    } else {
                                        //echo "No records found for archiving for scholarship number: $scholarship_no.";
                                    }
                                }
                            } else {
                                //echo "No scholarships found.";
                            }

                            if($_SERVER["REQUEST_METHOD"] == "POST") {
                                if (isset($_POST['approve'])) {
                                    $student_no = $_POST['student_no']; 
                                    $scholarship_no = $_POST['approve'];
                                    echo '
                                    <script>
                                        Swal.fire({
                                            title: "Are you sure?",
                                            icon: "warning",
                                            iconColor: "#28a745",
                                            showCancelButton: true,
                                            confirmButtonColor: "#28a745",
                                            cancelButtonColor: "#d33",
                                            confirmButtonText: "Yes"
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                // AJAX request to update the status
                                                var xhr = new XMLHttpRequest();
                                                xhr.open("POST", "update_status.php", true);
                                                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                                xhr.send("student_no=' . $student_no . '&scholarship_no=' . $scholarship_no . '&status=approved");
                                                xhr.onload = function() {
                                                    if (xhr.status === 200) {
                                                        Swal.fire({
                                                            title: "Approved!",
                                                            text: "The scholarship application has been approved.",
                                                            icon: "success",
                                                            confirmButtonColor: "#28a745"
                                                        }).then(() => {
                                                            window.location.href = "admin_application.php?action=approved&student_no=' . $student_no . '&scholarship_no=' . $scholarship_no . '";
                                                        });
                                                    } else {
                                                        Swal.fire({
                                                            title: "Error",
                                                            text: "An error occurred while updating the status.",
                                                            icon: "error",
                                                            confirmButtonColor: "#d33"
                                                        });
                                                    }
                                                };
                                            }
                                        });
                                    </script>';
                                } elseif (isset($_POST['reject'])) {
                                    $student_no = $_POST['student_no']; 
                                    $scholarship_no = $_POST['reject'];
                                    echo '
                                    <script>
                                        Swal.fire({
                                            title: "Are you sure?",
                                            text: "Please provide a reason for rejection:",
                                            icon: "warning",
                                            iconColor: "#f44336",
                                            input: "textarea",
                                            inputPlaceholder: "Enter rejection reason...",
                                            showCancelButton: true,
                                            confirmButtonColor: "#f44336",
                                            cancelButtonColor: "#777683",
                                            confirmButtonText: "Yes"
                                        }).then((result) => {
                                            if (result.isConfirmed && result.value) {
                                                var reason = result.value;
                                                // AJAX request to update the status
                                                var xhr = new XMLHttpRequest();
                                                xhr.open("POST", "update_status.php", true);
                                                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                                xhr.send("student_no=' . $student_no . '&scholarship_no=' . $scholarship_no . '&status=rejected&reason=" + encodeURIComponent(reason));
                                                xhr.onload = function() {
                                                    if (xhr.status === 200) {
                                                        Swal.fire({
                                                            title: "Rejected!",
                                                            text: "The scholarship application has been Rejected!.",
                                                            icon: "success",
                                                            iconColor: "#f44336",
                                                            confirmButtonColor: "#f44336"
                                                        }).then(() => {
                                                            window.location.href = "admin_application.php?action=rejected&student_no=' . $student_no . '&scholarship_no=' . $scholarship_no . '";
                                                        });
                                                    } else {
                                                        Swal.fire({
                                                            title: "Error",
                                                            text: "An error occurred while updating the status.",
                                                            icon: "error",
                                                            confirmButtonColor: "#d33"
                                                        });
                                                    }
                                                };
                                            }
                                        });
                                    </script>';
                                } 
                                elseif (isset($_POST['pend'])) {
                                    $student_no = $_POST['student_no']; 
                                    $scholarship_no = $_POST['pend'];
                                    echo '
                                    <script>
                                        Swal.fire({
                                            title: "Are you sure?",
                                            icon: "warning",
                                            iconColor: "#777683",
                                            showCancelButton: true,
                                            confirmButtonColor: "#777683",
                                            cancelButtonColor: "#d33",
                                            confirmButtonText: "Yes"
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                // AJAX request to update the status
                                                var xhr = new XMLHttpRequest();
                                                xhr.open("POST", "update_status.php", true);
                                                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                                xhr.send("student_no=' . $student_no . '&scholarship_no=' . $scholarship_no . '&status=pending");
                                                xhr.onload = function() {
                                                    if (xhr.status === 200) {
                                                        Swal.fire({
                                                            title: "Pending!",
                                                            text: "The scholarship application has been Pending!.",
                                                            icon: "success",
                                                            iconColor: "#777683",
                                                            confirmButtonColor: "#777683"
                                                        }).then(() => {
                                                            window.location.href = "admin_application.php?action=pending&student_no=' . $student_no . '&scholarship_no=' . $scholarship_no . '";
                                                        });
                                                    } else {
                                                        Swal.fire({
                                                            title: "Error",
                                                            text: "An error occurred while updating the status.",
                                                            icon: "error",
                                                            confirmButtonColor: "#d33"
                                                        });
                                                    }
                                                };
                                            }
                                        });
                                    </script>';
                                
                                } elseif (isset($_POST['view'])) {
                                    $_SESSION['Application_scholarship_no'] = $_POST['view'];
                                    $_SESSION['Application_Student_No'] = $_POST['student_no'];
                                    header('Location: admin_view_attachement.php'); // Redirect to the target page
                                    exit();
                                }
                            }
                           
                            if(isset($_POST['submit']) && isset($_POST['Scholarship_name'])){
                                $searchScholarship_name = $_POST["Scholarship_name"];
                                        $search_condition = !empty($searchScholarship_name) 
                                            ? "AND (tbl_application_scholarship.scholarship_no = '$searchScholarship_name')": "";

                                        $sql = "SELECT 
                                                    tbl_student_acc.Student_No, 
                                                    tbl_student_acc.First_name, 
                                                    tbl_student_acc.Last_name, 
                                                    tbl_student_acc.Email_Address, 
                                                    tbl_application_scholarship.scholarship_no, 
                                                    tbl_scholarship.scholarship_name 
                                                FROM tbl_student_acc 
                                                LEFT JOIN tbl_application_scholarship 
                                                    ON tbl_student_acc.Student_No = tbl_application_scholarship.Student_No 
                                                LEFT JOIN tbl_scholarship 
                                                    ON tbl_scholarship.scholarship_no = tbl_application_scholarship.scholarship_no 
                                                WHERE tbl_application_scholarship.C_status = 'pending' $search_condition";

                                    $result = mysqli_query($conn, $sql);
                                if ($result->num_rows > 0) {
                                    echo "<table>
                                    <tr>
                                    <th>STUDENT ID</th>
                                    <th>FIRST NAME</th>
                                    <th>LAST NAME</th>
                                    <th>EMAIL ADDRESS</th>
                                    <th colspan='2'>ID SCHOLARSHIP NAME</th>
                                    <th colspan='3' style='text-align: center;'>ACTION</th>
                                    </tr>";
                                    $row_count = 0; // Counter for row colors

                            while ($row = $result->fetch_assoc()) {

                                    // Alternate row color
                                $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
                                $row_count++;
                                echo "<tr class='$row_class'>
                                        <td>".$row["Student_No"]."</td>
                                        <td>".$row["First_name"]."</td>
                                        <td>".$row["Last_name"]."</td>
                                        <td>".$row["Email_Address"]."</td>
                                        <td colspan='2'>".$row["scholarship_no"]." 
                                       ".$row["scholarship_name"]."</td>
                                        <td style='text-align: center;'>
                                            <form method='POST'>
                                            <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                                <button type='submit' name='approve' id='approve' value='".$row["scholarship_no"]."'>Approve</button>
                                            </form>
                                        </td>
                                        <td style='text-align: center;'>
                                            <form method='POST'>
                                            <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                                <button type='submit' name='reject' id='reject' value='".$row["scholarship_no"]."'>Reject</button>
                                            </form>
                                        </td>
                                        <td style='text-align: center;'>
                                            <form method='POST' action=''>
                                            <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                                <button type='submit' name='view' id='view' value='".$row["scholarship_no"]."'>View Details</button>
                                            </form>
                                        </td>
                                    </tr>";
                            }
                            echo "</table><br><br>";
                                } else {
                                    echo "<table>
                                            <tr>
                                            <th>STUDENT ID</th>
                                            <th>FIRST NAME</th>
                                            <th>LAST NAME</th>
                                            <th>EMAIL ADDRESS</th>
                                            <th colspan='2'>APPLICATION DATE</th>
                                            <th colspan='3' style='text-align: center;'>ACTION</th>
                                            </tr>
                                            <tr>
                                                <td colspan = '9' style='text-align: center;'> NOT AVAILABLE APPLICATION!</td>
                                            </tr>
                                            </table>";
                                }
                            }elseif (isset($_POST['submit']) && isset($_POST['search-pending'])) {
                                $search = $_POST["search-pending"];
                                        $search_condition = !empty($search) 
                                            ? "AND (tbl_student_acc.Student_No LIKE '%$search%' 
                                                OR tbl_student_acc.First_name LIKE '%$search%' 
                                                OR tbl_student_acc.Last_name LIKE '%$search%'
                                                OR tbl_student_acc.Email_Address LIKE '%$search%' 
                                                OR tbl_application_scholarship.scholarship_no LIKE '%$search%' 
                                                OR tbl_scholarship.scholarship_name LIKE '%$search%')" 
                                            : "";

                                        $sql = "SELECT 
                                                    tbl_student_acc.Student_No, 
                                                    tbl_student_acc.First_name, 
                                                    tbl_student_acc.Last_name, 
                                                    tbl_student_acc.Email_Address, 
                                                    tbl_application_scholarship.scholarship_no, 
                                                    tbl_scholarship.scholarship_name 
                                                FROM tbl_student_acc 
                                                LEFT JOIN tbl_application_scholarship 
                                                    ON tbl_student_acc.Student_No = tbl_application_scholarship.Student_No 
                                                LEFT JOIN tbl_scholarship 
                                                    ON tbl_scholarship.scholarship_no = tbl_application_scholarship.scholarship_no 
                                                WHERE tbl_application_scholarship.C_status = 'pending' $search_condition";

                                        $result = mysqli_query($conn, $sql);

                                if ($result->num_rows > 0) {
                                    echo "<table>
                                                <tr>
                                                <th>STUDENT ID</th>
                                                <th>FIRST NAME</th>
                                                <th>LAST NAME</th>
                                                <th>EMAIL ADDRESS</th>
                                                <th colspan='2'>ID SCHOLARSHIP NAME</th>
                                                <th colspan='3' style='text-align: center;'>ACTION</th>
                                                </tr>";
                                                $row_count = 0; // Counter for row colors

                                        while ($row = $result->fetch_assoc()) {
            
                                                // Alternate row color
                                            $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
                                            $row_count++;
                                            echo "<tr class='$row_class'>
                                                    <td>".$row["Student_No"]."</td>
                                                    <td>".$row["First_name"]."</td>
                                                    <td>".$row["Last_name"]."</td>
                                                    <td>".$row["Email_Address"]."</td>
                                                    <td colspan='2'>".$row["scholarship_no"]." 
                                                ".$row["scholarship_name"]."</td>
                                                    <td style='text-align: center;'>
                                                        <form method='POST'>
                                                        <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                                            <button type='submit' name='approve' id='approve' value='".$row["scholarship_no"]."'>Approve</button>
                                                        </form>
                                                    </td>
                                                    <td style='text-align: center;'>
                                                        <form method='POST'>
                                                        <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                                            <button type='submit' name='reject' id='reject' value='".$row["scholarship_no"]."'>Reject</button>
                                                        </form>
                                                    </td>
                                                    <td style='text-align: center;'>
                                                        <form method='POST' action=''>
                                                        <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                                            <button type='submit' name='view' id='view' value='".$row["scholarship_no"]."'>View Details</button>
                                                        </form>
                                                    </td>
                                                </tr>";
                                        }
                                        echo "</table><br><br>";
                                } else {
                                    echo "<table>
                                    <tr>
                                    <th>STUDENT ID</th>
                                    <th>FIRST NAME</th>
                                    <th>LAST NAME</th>
                                    <th>EMAIL ADDRESS</th>
                                    <th colspan='2'>APPLICATION DATE</th>
                                    <th colspan='3' style='text-align: center;'>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td colspan = '9' style='text-align: center;'> NOT AVAILABLE APPLICATION!</td>
                                    </tr>
                                    </table>";
                                }
                            } else {
                                $sql = "SELECT 
                                            tbl_student_acc.Student_No, 
                                            tbl_student_acc.First_name, 
                                            tbl_student_acc.Last_name, 
                                            tbl_student_acc.Email_Address, 
                                            tbl_application_scholarship.scholarship_no, 
                                            tbl_scholarship.scholarship_name 
                                        FROM tbl_student_acc 
                                        LEFT JOIN tbl_application_scholarship 
                                            ON tbl_student_acc.Student_No = tbl_application_scholarship.Student_No 
                                        LEFT JOIN tbl_scholarship 
                                            ON tbl_scholarship.scholarship_no = tbl_application_scholarship.scholarship_no 
                                        WHERE tbl_application_scholarship.C_status = 'pending'";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    echo "<table>
                                            <tr>
                                            <th>STUDENT ID</th>
                                            <th>FIRST NAME</th>
                                            <th>LAST NAME</th>
                                            <th>EMAIL ADDRESS</th>
                                            <th colspan='2'>ID SCHOLARSHIP NAME</th>
                                            <th colspan='3' style='text-align: center;'>ACTION</th>
                                            </tr>";
                                            $row_count = 0; // Counter for row colors

                                    while ($row = $result->fetch_assoc()) {
        
                                            // Alternate row color
                                        $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
                                        $row_count++;
                                        echo "<tr class='$row_class'>
                                                <td>".$row["Student_No"]."</td>
                                                <td>".$row["First_name"]."</td>
                                                <td>".$row["Last_name"]."</td>
                                                <td>".$row["Email_Address"]."</td>
                                                <td colspan='2'>".$row["scholarship_no"]." 
                                               ".$row["scholarship_name"]."</td>
                                                <td style='text-align: center;'>
                                                    <form method='POST'>
                                                    <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                                        <button type='submit' name='approve' id='approve' value='".$row["scholarship_no"]."'>Approve</button>
                                                    </form>
                                                </td>
                                                <td  style='text-align: center;'>
                                                    <form method='POST'>
                                                    <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                                        <button type='submit' name='reject' id='reject' value='".$row["scholarship_no"]."'>Reject</button>
                                                    </form>
                                                </td>
                                                <td style='text-align: center;'>
                                                    <form method='POST' action=''>
                                                    <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                                        <button type='submit' name='view' id='view' value='".$row["scholarship_no"]."'>View Details</button>
                                                    </form>
                                                </td>
                                            </tr>";
                                    }
                                    echo "</table><br><br>";
                                }
                                else {
                                    echo "<table>
                                    <tr>
                                    <th>STUDENT ID</th>
                                    <th>FIRST NAME</th>
                                    <th>LAST NAME</th>
                                    <th>EMAIL ADDRESS</th>
                                    <th colspan='2'>APPLICATION DATE</th>
                                    <th colspan='3' style='text-align: center;'>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td colspan = '9' style='text-align: center;'> NOT AVAILABLE APPLICATION!</td>
                                    </tr>
                                    </table>";
                                }
                            }

                            ob_end_flush();
                        ?>
                        

                        
                    </div>
            </div>
        </div>

        </div>
        <!--- REPLACEDIV FOR APPROVED --->
        <div style="display: none;" id="div2">
        <div class="title-page">
            <span id="title-name">Approved Management Student Application</span>
        </div>
        <div class="main-container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="content-application">
                        <form action="" method="POST">
                            <select style="border: none; width:350px" class="application-btn" name="Scholarship_name">
                                <option value="" disabled selected>Select Scholarship Name</option>
                                <?php echo $options; ?>
                            </select>
                            <select style="border: none;" name="status_application" id="status_application" class="application-btn" onchange="handleStatusChange(this)">
                                <option value="approved">Approved</option>
                                <option value="pending">Pending</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <input class="search-input" type="text" name="search-approve" value="<?php echo isset($_POST['search-approve']) ? htmlspecialchars($_POST['search-approve']) : ''; ?>" placeholder="   Search">
                            <button name="submit" value="submit-pending"><div class='bx bx-search'></div></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div>
                    <?php 
                            $conn = new mysqli('localhost','root','','db_scholarship_system');

                            if(isset($_POST['submit']) && isset($_POST['Scholarship_name'])){
                                $searchScholarship_name = $_POST["Scholarship_name"];
                                        $search_condition = !empty($searchScholarship_name) 
                                            ? "AND (tbl_application_scholarship.scholarship_no = '$searchScholarship_name')": "";

                                        $sql = "SELECT 
                                                    tbl_student_acc.Student_No, 
                                                    tbl_student_acc.First_name, 
                                                    tbl_student_acc.Last_name, 
                                                    tbl_student_acc.Email_Address, 
                                                    tbl_application_scholarship.scholarship_no, 
                                                    tbl_scholarship.scholarship_name 
                                                FROM tbl_student_acc 
                                                LEFT JOIN tbl_application_scholarship 
                                                    ON tbl_student_acc.Student_No = tbl_application_scholarship.Student_No 
                                                LEFT JOIN tbl_scholarship 
                                                    ON tbl_scholarship.scholarship_no = tbl_application_scholarship.scholarship_no 
                                                WHERE tbl_application_scholarship.C_status = 'approved' $search_condition";

                                        $result = mysqli_query($conn, $sql);

                                if ($result->num_rows > 0) {
                                    echo "<table>
                                                <tr>
                                                <th>STUDENT ID</th>
                                                <th>FIRST NAME</th>
                                                <th>LAST NAME</th>
                                                <th>EMAIL ADDRESS</th>
                                                <th colspan='2'>ID SCHOLARSHIP NAME</th>
                                                <th colspan='3' style='text-align: center;'>ACTION</th>
                                                </tr>";
                                                $row_count = 0; // Counter for row colors

                                        while ($row = $result->fetch_assoc()) {
            
                                                // Alternate row color
                                            $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
                                            $row_count++;
                                            echo "<tr class='$row_class'>
                                                    <td>".$row["Student_No"]."</td>
                                                    <td>".$row["First_name"]."</td>
                                                    <td>".$row["Last_name"]."</td>
                                                    <td>".$row["Email_Address"]."</td>
                                                    <td colspan='2'>".$row["scholarship_no"]." 
                                                ".$row["scholarship_name"]."</td>
                                                    <td style='text-align: center;'>
                                                        <form method='POST'>
                                                        <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                                            <button type='submit' name='pend'id='pend' value='".$row["scholarship_no"]."'>Pending</button>
                                                        </form>
                                                    </td>
                                                    <td style='text-align: center;'>
                                                        <form method='POST'>
                                                        <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                                            <button type='submit' name='reject' id='reject' value='".$row["scholarship_no"]."'>Reject</button>
                                                        </form>
                                                    </td>
                                                    <td style='text-align: center;'>
                                                        <form method='POST' action=''>
                                                        <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                                            <button type='submit' name='view' id='view' value='".$row["scholarship_no"]."'>View Details</button>
                                                        </form>
                                                    </td>
                                                </tr>";
                                        }
                                        echo "</table><br><br>";
                                } else {
                                    echo "<table>
                                        <tr>
                                        <th>STUDENT ID</th>
                                        <th>FIRST NAME</th>
                                        <th>LAST NAME</th>
                                        <th>EMAIL ADDRESS</th>
                                        <th colspan='2'>APPLICATION DATE</th>
                                        <th colspan='3' style='text-align: center;'>ACTION</th>
                                        </tr>
                                        <tr>
                                            <td colspan = '9' style='text-align: center;'> NOT AVAILABLE APPLICATION!</td>
                                        </tr>
                                    </table>";
                                }
                            }elseif (isset($_POST['submit']) && isset($_POST['search-approve'])) {
                                $search = $_POST["search-approve"];
                                        $search_condition = !empty($search) 
                                            ? "AND (tbl_student_acc.Student_No LIKE '%$search%' 
                                                OR tbl_student_acc.First_name LIKE '%$search%' 
                                                OR tbl_student_acc.Last_name LIKE '%$search%' 
                                                OR tbl_student_acc.Email_Address LIKE '%$search%' 
                                                OR tbl_application_scholarship.scholarship_no LIKE '%$search%' 
                                                OR tbl_scholarship.scholarship_name LIKE '%$search%')" 
                                            : "";

                                        $sql = "SELECT 
                                                    tbl_student_acc.Student_No, 
                                                    tbl_student_acc.First_name, 
                                                    tbl_student_acc.Last_name, 
                                                    tbl_student_acc.Email_Address, 
                                                    tbl_application_scholarship.scholarship_no, 
                                                    tbl_scholarship.scholarship_name 
                                                FROM tbl_student_acc 
                                                LEFT JOIN tbl_application_scholarship 
                                                    ON tbl_student_acc.Student_No = tbl_application_scholarship.Student_No 
                                                LEFT JOIN tbl_scholarship 
                                                    ON tbl_scholarship.scholarship_no = tbl_application_scholarship.scholarship_no 
                                                WHERE tbl_application_scholarship.C_status = 'approved' $search_condition";

                                        $result = mysqli_query($conn, $sql);

                                if ($result->num_rows > 0) {
                                    echo "<table>
                                                <tr>
                                                <th>STUDENT ID</th>
                                                <th>FIRST NAME</th>
                                                <th>LAST NAME</th>
                                                <th>EMAIL ADDRESS</th>
                                                <th colspan='2'>ID SCHOLARSHIP NAME</th>
                                                <th colspan='3' style='text-align: center;'>ACTION</th>
                                                </tr>";
                                                $row_count = 0; // Counter for row colors

                                        while ($row = $result->fetch_assoc()) {
            
                                                // Alternate row color
                                            $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
                                            $row_count++;
                                            echo "<tr class='$row_class'>
                                                    <td>".$row["Student_No"]."</td>
                                                    <td>".$row["First_name"]."</td>
                                                    <td>".$row["Last_name"]."</td>
                                                    <td>".$row["Email_Address"]."</td>
                                                    <td colspan='2'>".$row["scholarship_no"]." 
                                                ".$row["scholarship_name"]."</td>
                                                    <td style='text-align: center;'>
                                                        <form method='POST'>
                                                        <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                                            <button type='submit' name='pend'id='pend' value='".$row["scholarship_no"]."'>Pending</button>
                                                        </form>
                                                    </td>
                                                    <td style='text-align: center;'>
                                                        <form method='POST'>
                                                        <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                                            <button type='submit' name='reject' id='reject' value='".$row["scholarship_no"]."'>Reject</button>
                                                        </form>
                                                    </td>
                                                    <td style='text-align: center;'>
                                                        <form method='POST' action=''>
                                                        <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                                            <button type='submit' name='view' id='view' value='".$row["scholarship_no"]."'>View Details</button>
                                                        </form>
                                                    </td>
                                                </tr>";
                                        }
                                        echo "</table><br><br>";
                                } else {
                                    echo "<table>
                                    <tr>
                                    <th>STUDENT ID</th>
                                    <th>FIRST NAME</th>
                                    <th>LAST NAME</th>
                                    <th>EMAIL ADDRESS</th>
                                    <th colspan='2'>APPLICATION DATE</th>
                                    <th colspan='3' style='text-align: center;'>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td colspan = '9' style='text-align: center;'> NOT AVAILABLE APPLICATION!</td>
                                    </tr>
                                    </table>";
                                }
                            }
                          else {
                                $sql = "SELECT 
                                            tbl_student_acc.Student_No, 
                                            tbl_student_acc.First_name, 
                                            tbl_student_acc.Last_name, 
                                            tbl_student_acc.Email_Address, 
                                            tbl_application_scholarship.scholarship_no, 
                                            tbl_scholarship.scholarship_name 
                                        FROM tbl_student_acc 
                                        LEFT JOIN tbl_application_scholarship 
                                            ON tbl_student_acc.Student_No = tbl_application_scholarship.Student_No 
                                        LEFT JOIN tbl_scholarship 
                                            ON tbl_scholarship.scholarship_no = tbl_application_scholarship.scholarship_no 
                                        WHERE tbl_application_scholarship.C_status = 'approved'";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    echo "<table>
                                            <tr>
                                            <th>STUDENT ID</th>
                                            <th>FIRST NAME</th>
                                            <th>LAST NAME</th>
                                            <th>EMAIL ADDRESS</th>
                                            <th colspan='2'>ID SCHOLARSHIP NAME</th>
                                            <th colspan='3' style='text-align: center;'>ACTION</th>
                                            </tr>";
                                            $row_count = 0; // Counter for row colors

                                    while ($row = $result->fetch_assoc()) {
        
                                            // Alternate row color
                                        $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
                                        $row_count++;
                                        echo "<tr class='$row_class'>
                                                <td>".$row["Student_No"]."</td>
                                                <td>".$row["First_name"]."</td>
                                                <td>".$row["Last_name"]."</td>
                                                <td>".$row["Email_Address"]."</td>
                                                <td colspan='2'>".$row["scholarship_no"]." 
                                               ".$row["scholarship_name"]."</td>
                                                <td style='text-align: center;'>
                                                    <form method='POST'>
                                                    <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                                         <button type='submit' name='pend'id='pend' value='".$row["scholarship_no"]."'>Pending</button>
                                                    </form>
                                                </td>
                                                <td style='text-align: center;'>
                                                    <form method='POST'>
                                                    <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                                        <button type='submit' name='reject' id='reject' value='".$row["scholarship_no"]."'>Reject</button>
                                                    </form>
                                                </td>
                                                <td style='text-align: center;'>
                                                    <form method='POST' action=''>
                                                    <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                                        <button type='submit' name='view' id='view' value='".$row["scholarship_no"]."'>View Details</button>
                                                    </form>
                                                </td>
                                            </tr>";
                                    }
                                    echo "</table><br><br>";
                                }
                                else {
                                    echo "<table>
                                    <tr>
                                    <th>STUDENT ID</th>
                                    <th>FIRST NAME</th>
                                    <th>LAST NAME</th>
                                    <th>EMAIL ADDRESS</th>
                                    <th colspan='2'>APPLICATION DATE</th>
                                    <th colspan='3' style='text-align: center;'>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td colspan = '9' style='text-align: center;'> NOT AVAILABLE APPLICATION!</td>
                                    </tr>
                                    </table>";
                                }
                            }
                  
                        
                        ?>

                        
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!--- REPLACEDIV FOR REJECTED--->
        <div style="display: none;" id="div3">
        <div class="title-page">
            <span id="title-name">Rejected Management Student Application</span>
        </div>
        <div class="main-container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="content-application">
                        <form action="" method="POST">
                            <select style="border: none; width:350px" class="application-btn" name="Scholarship_name">
                                <option value="" disabled selected>Select Scholarship Name</option>
                                <?php echo $options; ?>
                            </select>
                            <select style="border: none;" name="status_application" id="status_application" class="application-btn" onchange="handleStatusChange(this)">
                                <option value="rejected">Rejected</option>
                                <option value="approved">Approved</option>
                                <option value="pending">Pending</option>
                            </select>
                            <input class="search-input" type="text" name="search-reject" value="<?php echo isset($_POST['search-reject']) ? htmlspecialchars($_POST['search-reject']) : ''; ?>" placeholder="   Search">
                            <button name="submit" value="submit-pending"><div class='bx bx-search'></div></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div>
                        <!--
                            colspan='3'
                        <td>
                                <form method='POST'>
                                <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                    <button type='submit' name='pend'id='pend' value='".$row["scholarship_no"]."'>Pending</button>
                                </form>
                            </td>
                            <td>
                                <form method='POST' action=''>
                                    <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                    <button type='submit' name='delete_files' id='delete_files' value='".$row["scholarship_no"]."'><i class='bx bxs-trash-alt'></i></button>
                                </form>
                            </td>
                        -->
                    <?php 
                    
                        $conn = new mysqli('localhost','root','','db_scholarship_system');

                        if(isset($_POST['submit']) && isset($_POST['Scholarship_name'])){
                            $searchScholarship_name = $_POST["Scholarship_name"];
                                    $search_condition = !empty($searchScholarship_name) 
                                        ? "AND (tbl_application_scholarship.scholarship_no = '$searchScholarship_name')": "";

                                    $sql = "SELECT 
                                                tbl_student_acc.Student_No, 
                                                tbl_student_acc.First_name, 
                                                tbl_student_acc.Last_name, 
                                                tbl_student_acc.Email_Address, 
                                                tbl_application_scholarship.scholarship_no, 
                                                tbl_scholarship.scholarship_name 
                                            FROM tbl_student_acc 
                                            LEFT JOIN tbl_application_scholarship 
                                                ON tbl_student_acc.Student_No = tbl_application_scholarship.Student_No 
                                            LEFT JOIN tbl_scholarship 
                                                ON tbl_scholarship.scholarship_no = tbl_application_scholarship.scholarship_no 
                                            WHERE tbl_application_scholarship.C_status = 'rejected' $search_condition";

                                    $result = mysqli_query($conn, $sql);
                            if ($result->num_rows > 0) {
                                echo "<table>
                                <tr>
                                <th>STUDENT ID</th>
                                <th>FIRST NAME</th>
                                <th>LAST NAME</th>
                                <th>EMAIL ADDRESS</th>
                                <th colspan='2'>ID SCHOLARSHIP NAME</th>
                                <th  colspan='2' style='text-align: center;'>ACTION</th>
                                </tr>";
                                $row_count = 0; // Counter for row colors

                        while ($row = $result->fetch_assoc()) {

                                // Alternate row color
                            $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
                            $row_count++;
                            echo "<tr class='$row_class'>
                                    <td>".$row["Student_No"]."</td>
                                    <td>".$row["First_name"]."</td>
                                    <td>".$row["Last_name"]."</td>
                                    <td>".$row["Email_Address"]."</td>
                                    <td colspan='2'>".$row["scholarship_no"]." 
                                   ".$row["scholarship_name"]."</td>
                                    
                                    <td style='text-align: center;'>
                                        <form method='POST' action=''>
                                        <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                                <button type='submit' name='view' id='view' value='".$row["scholarship_no"]."'>View Details</button>
                                            </form>
                                    </td>
                                    <td style='text-align: center;'>
                                        <form method='POST' action=''>
                                            <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                            <button type='submit' class='delete_files' id='delete_files' data-student-id='".$row["Student_No"]."' data-scholarship-no='".$row["scholarship_no"]."'><i class='bx bxs-trash-alt'></i></button>
                                        </form>
                                    </td>
                                </tr>";
                        }
                        echo "</table><br><br>";
                            } else {
                                echo "<table>
                                <tr>
                                <th>STUDENT ID</th>
                                <th>FIRST NAME</th>
                                <th>LAST NAME</th>
                                <th>EMAIL ADDRESS</th>
                                <th colspan='2'>APPLICATION DATE</th>
                                <th  colspan='2' style='text-align: center;'>ACTION</th>
                                </tr>
                                <tr>
                                    <td colspan = '8' style='text-align: center;'> NOT AVAILABLE APPLICATION!</td>
                                </tr>
                                </table>";
                    }
                }elseif (isset($_POST['submit']) && isset($_POST['search-reject'])) {
                    $search = $_POST["search-reject"];
                            $search_condition = !empty($search) 
                                ? "AND (tbl_student_acc.Student_No LIKE '%$search%' 
                                    OR tbl_student_acc.First_name LIKE '%$search%' 
                                    OR tbl_student_acc.Last_name LIKE '%$search%' 
                                    OR tbl_student_acc.Email_Address LIKE '%$search%' 
                                    OR tbl_application_scholarship.scholarship_no LIKE '%$search%'
                                    OR tbl_scholarship.scholarship_name LIKE '%$search%')" 
                                : "";

                            $sql = "SELECT 
                                        tbl_student_acc.Student_No, 
                                        tbl_student_acc.First_name, 
                                        tbl_student_acc.Last_name, 
                                        tbl_student_acc.Email_Address, 
                                        tbl_application_scholarship.scholarship_no, 
                                        tbl_scholarship.scholarship_name 
                                    FROM tbl_student_acc 
                                    LEFT JOIN tbl_application_scholarship 
                                        ON tbl_student_acc.Student_No = tbl_application_scholarship.Student_No 
                                    LEFT JOIN tbl_scholarship 
                                        ON tbl_scholarship.scholarship_no = tbl_application_scholarship.scholarship_no 
                                    WHERE tbl_application_scholarship.C_status = 'rejected' $search_condition";

                            $result = mysqli_query($conn, $sql);

                    if ($result->num_rows > 0) {
                        echo "<table>
                                    <tr>
                                    <th>STUDENT ID</th>
                                    <th>FIRST NAME</th>
                                    <th>LAST NAME</th>
                                    <th>EMAIL ADDRESS</th>
                                    <th colspan='2'>ID SCHOLARSHIP NAME</th>
                                    <th  colspan='2' style='text-align: center;'>ACTION</th>
                                    </tr>";
                                    $row_count = 0; // Counter for row colors

                            while ($row = $result->fetch_assoc()) {

                                    // Alternate row color
                                $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
                                $row_count++;
                                echo "<tr class='$row_class'>
                                        <td>".$row["Student_No"]."</td>
                                        <td>".$row["First_name"]."</td>
                                        <td>".$row["Last_name"]."</td>
                                        <td>".$row["Email_Address"]."</td>
                                        <td colspan='2'>".$row["scholarship_no"]." 
                                    ".$row["scholarship_name"]."</td>
                                        <td style='text-align: center;'>
                                            <form method='POST' action=''>
                                            <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                                <button type='submit' name='view' id='view' value='".$row["scholarship_no"]."'>View Details</button>
                                            </form>
                                        </td>
                                        <td style='text-align: center;'>
                                            <form method='POST' action=''>
                                                <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                                <button type='submit' class='delete_files' id='delete_files' data-student-id='".$row["Student_No"]."' data-scholarship-no='".$row["scholarship_no"]."'><i class='bx bxs-trash-alt'></i></button>
                                            </form>
                                        </td>
                                    </tr>";
                            }
                            echo "</table><br><br>";
                    } else {
                        echo "<table>
                        <tr>
                        <th>STUDENT ID</th>
                        <th>FIRST NAME</th>
                        <th>LAST NAME</th>
                        <th>EMAIL ADDRESS</th>
                        <th colspan='2'>APPLICATION DATE</th>
                        <th  colspan='2' style='text-align: center;'>ACTION</th>
                        </tr>
                        <tr>
                            <td colspan = '8' style='text-align: center;'> NOT AVAILABLE APPLICATION!</td>
                        </tr>
                        </table>";
                    }
                }  else {
                    $sql = "SELECT 
                                tbl_student_acc.Student_No, 
                                tbl_student_acc.First_name, 
                                tbl_student_acc.Last_name, 
                                tbl_student_acc.Email_Address, 
                                tbl_application_scholarship.scholarship_no, 
                                tbl_scholarship.scholarship_name 
                            FROM tbl_student_acc 
                            LEFT JOIN tbl_application_scholarship 
                                ON tbl_student_acc.Student_No = tbl_application_scholarship.Student_No 
                            LEFT JOIN tbl_scholarship 
                                ON tbl_scholarship.scholarship_no = tbl_application_scholarship.scholarship_no 
                            WHERE tbl_application_scholarship.C_status = 'rejected'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        echo "<table>
                                <tr>
                                <th>STUDENT ID</th>
                                <th>FIRST NAME</th>
                                <th>LAST NAME</th>
                                <th>EMAIL ADDRESS</th>
                                <th colspan='2'>ID SCHOLARSHIP NAME</th>
                                <th  colspan='2' style='text-align: center;'>ACTION</th>
                                </tr>";
                                $row_count = 0; // Counter for row colors

                        while ($row = $result->fetch_assoc()) {

                                // Alternate row color
                            $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
                            $row_count++;
                            echo "<tr class='$row_class'>
                                    <td>".$row["Student_No"]."</td>
                                    <td>".$row["First_name"]."</td>
                                    <td>".$row["Last_name"]."</td>
                                    <td>".$row["Email_Address"]."</td>
                                    <td colspan='2'>".$row["scholarship_no"]." 
                                   ".$row["scholarship_name"]."</td>
                                    
                                    <td style='text-align: center;'>
                                        <form method='POST' action=''>
                                        <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                                <button type='submit' name='view' id='view' value='".$row["scholarship_no"]."'>View Details</button>
                                            </form>
                                    </td>
                                    <td style='text-align: center;'>
                                        <form method='POST' action=''>
                                            <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                                            <button type='submit' class='delete_files' id='delete_files' data-student-id='".$row["Student_No"]."' data-scholarship-no='".$row["scholarship_no"]."'><i class='bx bxs-trash-alt'></i></button>
                                        </form>
                                    </td>

                                    
                                </tr>";
                        }
                        echo "</table><br><br>";
                    }
                    else {
                        echo "<table>
                        <tr>
                        <th>STUDENT ID</th>
                        <th>FIRST NAME</th>
                        <th>LAST NAME</th>
                        <th>EMAIL ADDRESS</th>
                        <th colspan='2'>APPLICATION DATE</th>
                        <th  colspan='2' style='text-align: center;'>ACTION</th>
                        </tr>
                        <tr>
                            <td colspan = '8' style='text-align: center;'> NOT AVAILABLE APPLICATION!</td>
                        </tr>
                        </table>";
                    }
                }

                        
                        ?>
                        
                        
                    </div>
                </div>
            </div>
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


       // Function to switch between divs
        function replaceDiv(divId) {
            // Array of div IDs to be managed
            const divs = ['div1', 'div2', 'div3'];

            // Hide all divs
            divs.forEach(id => {
                const div = document.getElementById(id);
                if (div) {
                    div.style.display = 'none';
                }
            });

            // Show the selected div
            const selectedDiv = document.getElementById(divId);
            if (selectedDiv) {
                selectedDiv.style.display = 'block';
            }

            // Save the current div ID to localStorage
            localStorage.setItem('currentDiv', divId);
        }

        // Function to handle status change from the select element
        function handleStatusChange(selectElement) {
            const selectedValue = selectElement.value;
            if (selectedValue === 'approved') {
                replaceDiv('div2');
            } else if (selectedValue === 'rejected') {
                replaceDiv('div3');
            } else if (selectedValue === 'pending') {
                replaceDiv('div1');
            }
        }

        // Initialize the page by showing the last active div
        window.onload = function() {
            const currentDiv = localStorage.getItem('currentDiv');
            if (currentDiv) {
                replaceDiv(currentDiv);
            } else {
                // Optionally, you can set a default div to show if no div was previously saved
                replaceDiv('div1');
            }
        }
        

        // /// log out button
        document.getElementById('logout-link').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default link click behavior
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out.",
                icon: 'warning',
                iconColor:'#346473',
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


        document.querySelectorAll('.delete_files').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        const studentId = this.getAttribute('data-student-id');
        const scholarshipNo = this.getAttribute('data-scholarship-no');

        // Fetch the rejection reason from the database
        fetch('get_rejection_reason.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ studentId: studentId, scholarshipNo: scholarshipNo })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const rejectionReason = data.rejectionReason;

                // Display the SweetAlert with the fetched rejection reason
                Swal.fire({
                    title: 'Are you sure?',
                    titleText:`You want to unsubmit the student's attachment?`,
                    text: `\n\nReason for unsubmission:\n\n${rejectionReason}`,
                    icon: 'warning',
                    iconColor: '#f44336',
                    showCancelButton: true,
                    confirmButtonColor: '#346473',
                    cancelButtonColor: '#f44336',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with deletion if confirmed
                        fetch('admin_application_delete.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ studentId: studentId, scholarshipNo: scholarshipNo })
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
                                    location.reload();
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
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'Could not fetch the rejection reason.',
                    icon: 'error',
                    confirmButtonColor: '#346473'
                });
            }
        });
    });
});




        // document.getElementById('delete_files').addEventListener('click', function(event) {
        //     event.preventDefault(); // Prevent the default link click behavior
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: "You want to delete Student attachment.",
        //         icon: 'warning',
        //         iconColor:'#f44336',
        //         showCancelButton: true,
        //         confirmButtonColor: '#346473',
        //         cancelButtonColor: '#f44336',
        //         confirmButtonText: 'Yes'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
                    
        //         }
        //     });
        // });
        // /// log out button
        // document.getElementById('ViewDetails_link').addEventListener('click', function(event) {
        //     event.preventDefault(); // Prevent the default link click behavior
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: "You want to view Attachment?",
        //         icon: 'info',
        //         iconColor: '#3B3956',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3B3956',
        //         cancelButtonColor: '#68677e',
        //         confirmButtonText: 'Yes'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             // If the user clicks "Yes", navigate to the logout page
        //             window.location.href = event.target.href="admin_view_attachement.php";
        //         }
        //     });
        // });
        

    </script>
</body>
</html>
