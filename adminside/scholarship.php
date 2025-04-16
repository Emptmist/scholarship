<?php

session_start();

if (!isset($_SESSION['Admin_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ../homepage/login_page.php");
    exit();
}else{
    $Admin_id = $_SESSION['Admin_id'];
}
// Initialize response array
$response = ['status' => 'error', 'message' => 'An error occurred.'];

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

    // Check connection
    if ($conn->connect_error) {
        $response['message'] = 'Connection failed: ' . $conn->connect_error;
        echo json_encode($response);
        exit;
    }

    // Check the action parameter
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        // Insert scholarship data
        if ($action === 'insert_scholarship') {
            // Retrieve form data
            $title = $_POST['title'];
            $desc = $_POST['desc'];
            $qual = $_POST['qual'];
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
            $requirements = isset($_POST['req']) ? $_POST['req'] : [];

            // Start transaction
            $conn->begin_transaction();

            try {
                // Insert into tbl_scholarship
                $stmt = $conn->prepare("INSERT INTO tbl_scholarship (scholarship_name, description, qualifications, start_of_applications, end_of_applications, Admin_id, scholarship_processed) VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");
                $stmt->bind_param("sssssi", $title, $desc, $qual, $startDate, $endDate, $Admin_id);

                if (!$stmt->execute()) {
                    throw new Exception("Failed to insert into tbl_scholarship.");
                }

                $scholarship_no = $stmt->insert_id; // Get the last inserted ID

                // Insert into tbl_requirements
                $no_req = 1; // Initialize requirement number
                $stmt = $conn->prepare("INSERT INTO tbl_requirements (scholarship_no, no_req, req_name) VALUES (?, ?, ?)");

                foreach ($requirements as $req) {
                    $stmt->bind_param("iis", $scholarship_no, $no_req, $req);
                    if (!$stmt->execute()) {
                        throw new Exception("Failed to insert requirement: $req");
                    }
                    $no_req++; // Increment the requirement number
                }

                // Commit transaction
                $conn->commit();
                $response['status'] = 'success';
                $response['message'] = 'Scholarship saved successfully!';
            } catch (Exception $e) {
                // Rollback transaction if an error occurs
                $conn->rollback();
                $response['message'] = $e->getMessage();
            }

            // Close connection
            $stmt->close();
            $conn->close();

            // Return JSON response
            echo json_encode($response);
            exit;
        }

        // Update scholarship data
        if ($action === 'update_scholarship') {
            $scholarship_no = intval($_POST['scholarship_no']);
            $title = $_POST['title'];
            $desc = $_POST['desc'];
            $qual = $_POST['qual'];
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
            $requirements = isset($_POST['req']) ? json_decode($_POST['req'], true) : []; // Decode JSON

            $conn->begin_transaction();

            try {
                $stmt = $conn->prepare("UPDATE tbl_scholarship SET scholarship_name = ?, description = ?, qualifications = ?, start_of_applications = ?, end_of_applications = ? WHERE scholarship_no = ?");
                $stmt->bind_param("sssssi", $title, $desc, $qual, $startDate, $endDate, $scholarship_no);
                if (!$stmt->execute()) {
                    throw new Exception("Failed to update tbl_scholarship.");
                }

                $stmt = $conn->prepare("DELETE FROM tbl_requirements WHERE scholarship_no = ?");
                $stmt->bind_param('i', $scholarship_no);
                if (!$stmt->execute()) {
                    throw new Exception("Failed to delete existing requirements.");
                }

                $no_req = 1;
                $stmt = $conn->prepare("INSERT INTO tbl_requirements (scholarship_no, no_req, req_name) VALUES (?, ?, ?)");
                foreach ($requirements as $req) {
                    if (!empty($req)) {
                        $stmt->bind_param("iis", $scholarship_no, $no_req, $req);
                        if (!$stmt->execute()) {
                            throw new Exception("Failed to insert requirement: $req");
                        }
                        $no_req++;
                    }
                }

                $conn->commit();
                $response['status'] = 'success';
                $response['message'] = 'Scholarship updated successfully!';
            } catch (Exception $e) {
                $conn->rollback();
                $response['message'] = $e->getMessage();
            }

            $stmt->close();
            $conn->close();

            echo json_encode($response);
            exit;
        }

        // Get scholarship details
        if ($action === 'get_scholarship_details' && isset($_POST['scholarship_no'])) {
            $scholarship_no = intval($_POST['scholarship_no']);

            // Get scholarship details
            $sql = "SELECT * FROM tbl_scholarship WHERE scholarship_no = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $scholarship_no);
            $stmt->execute();
            $result = $stmt->get_result();
            $scholarship = $result->fetch_assoc();

            if ($scholarship) {
                $response['status'] = 'success';
                $response['data'] = [
                    'scholarship_name' => $scholarship["scholarship_name"],
                    'description' => $scholarship["description"],
                    'qualifications' => $scholarship["qualifications"],
                    'start_of_applications' => $scholarship["start_of_applications"],
                    'end_of_applications' => $scholarship["end_of_applications"]
                ];

                // Get requirements
                $sql = "SELECT req_name FROM tbl_requirements WHERE scholarship_no = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $scholarship_no);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $response['data']['requirements'] = [];
                    while ($req = $result->fetch_assoc()) {
                        $response['data']['requirements'][] = $req["req_name"];
                    }
                } else {
                    $response['data']['requirements'] = [];
                }
            } else {
                $response['message'] = 'Scholarship not found.';
            }

            // Close connection
            $stmt->close();
            $conn->close();

            // Return JSON response
            echo json_encode($response);
            exit;
        }

        // Delete scholarship and requirements
        if ($action === 'delete_scholarship' && isset($_POST['scholarship_no'])) {
            $scholarship_no = intval($_POST['scholarship_no']);

            // Start transaction
            $conn->begin_transaction();

            try {
                // Delete requirements
                $stmt = $conn->prepare("DELETE FROM tbl_requirements WHERE scholarship_no = ?");
                $stmt->bind_param('i', $scholarship_no);
                if (!$stmt->execute()) {
                    throw new Exception("Failed to delete requirements.");
                }

                // Delete scholarship
                $stmt = $conn->prepare("DELETE FROM tbl_scholarship WHERE scholarship_no = ?");
                $stmt->bind_param('i', $scholarship_no);
                if (!$stmt->execute()) {
                    throw new Exception("Failed to delete scholarship.");
                }

                // Commit transaction
                $conn->commit();
                $response['status'] = 'success';
                $response['message'] = 'Scholarship deleted successfully!';
            } catch (Exception $e) {
                // Rollback transaction if an error occurs
                $conn->rollback();
                $response['message'] = $e->getMessage();
            }

            // Close connection
            $stmt->close();
            $conn->close();

            // Return JSON response
            echo json_encode($response);
            exit;
        }
    }

    
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- STYLESHEET -->
    <link rel="stylesheet" href="style.css" />

    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <!-- will change these link/script once actual file used in this link is found-->
    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <!--icons-->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons/css/boxicons.min.css' rel='stylesheet'>


    <!--icon website-->
    <link rel="icon" type="image/x-icon" href="logo.png">

    <!--SweetAlert2-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- own css -->
    <link rel="stylesheet" href="scholarship.css">

    <title>Scholarship Program</title>
    <style>
        .content {
            display: none;
        }

        .active {
            display: block;
        }

        #customDiv {
            display: flex;
            justify-content: start;
            background-color: #F5F5F5;
            color: #346473;
            cursor: pointer;
        }
    </style>
    </style>
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
                    <i class='bx bxs-home'></i>
                    <span class="link_name">DASHBOARD</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">DASHBOARD</a></li>
                </ul>
            </li>
            <li>
                <a href="admin_application.php">
                    <i class='bx bxs-copy-alt'></i>
                    <span class="link_name">APPLICATIONS</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">APPLICATIONS</a></li>
                </ul>
            </li>
            <li style="border-radius: 5px;
            background: rgba(244, 244, 244, 0.20);
            box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.25);">
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
                <span class="ms-4 fw-bold">SCHOLARSHIP PROGRAM</span>
                <div class="d-flex ms-auto">
                    <a href="#" class="nav-link d-flex align-items-center">
                        <span class="me-2 fw-normal" style="color: #25A55F;">SCHOLARSHIP COORDINATOR</span>
                        <i class='bx bxs-user-circle custom-icon'></i>
                    </a>
                </div>
            </div>
        </nav>

        <hr>

        <section>
            <div class="container-fluid m-4 content active p-5" id="div1">
                <div class="row">
                <div id="message-area" style="display: none; padding: 10px; border: 1px solid #ccc; margin-top: 10px;"></div>
                <div id="scholarship-content"></div>
                    <div class="col-lg-11 d-flex align-items-stretch">
                        <button class="btn fs-3 col-lg-12 d-flex justify-content-start mb-3" style="color: rgba(52, 100, 115, 0.5);" onclick="showDiv('div2')">
                            <i class='bx bx-plus-medical me-3 mt-auto mb-auto'></i>
                            <span>Add scholarship program</span>
                        </button>
                    </div>
                    <div class="col-lg-1 d-flex align-items-stretch">
                        <button class="btn fs-3 col-lg-12 d-flex justify-content-center align-items-center mb-3" style="color: #717171; background-color: #efefef; box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;" onclick="showDiv('div5')">
                            <span style="font-weight: 700; font-size: 20px;">ARCHIVE</span>
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        $conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

                        // Update the SQL query to include the status
                        $sql = "SELECT scholarship_no, scholarship_name, 
                                CASE 
                                    WHEN NOW() > end_of_applications THEN 'Ended'
                                    ELSE 'On Going'
                                END AS status 
                                FROM tbl_scholarship";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // Define the color based on the status
                                $statusColor = $row["status"] === "On Going" ? "#83C78E"  : "#FF6F61";

                                $icon = $row["status"] === "On Going" 
                                ? "<i class='bx bx-rotate-left' style='font-size: 30px;'></i>"
                                : "<i class='bx bxs-checkbox-minus' style='font-size: 30px;'></i>";

                                echo '<div class="d-flex justify-content-between mb-3">';
                                echo '<button class="btn fs-3 col-lg-11 d-flex justify-content-start bg-light" style="color: rgba(52, 100, 115, 0.8);" onclick="showDiv(\'div3\', ' . $row["scholarship_no"] . ')">';
                                echo '<span>' . $row["scholarship_name"] . ' - <span style="color: ' . $statusColor . '; font-weight: light;">' . $row["status"] . ' ' . $icon . '</span></span></button>';
                                echo '<button class="btn btn-warning me-2" onclick="editScholarship(' . $row["scholarship_no"] . ')"><i class=\'bx bx-edit\'></i></button>';
                                echo '<button class="btn btn-danger" onclick="deleteScholarship(' . $row["scholarship_no"] . ')"><i class=\'bx bx-trash\'></i></button>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>




            <div class="container-fluid mt-3 px-5 mb-5 content" id="div2">
                <div class="m-3 ms-0" onclick="showDiv('div1')">
                    <i style="font-size: 26px;; border: #e0e0e0 solid 1px; background-color: #fff; border-radius: 5px; padding: 0px 5px 0px 5px;" class='bx bx-arrow-back'></i>
                </div>
                <div class="row gx-5">
                    <div class="col-lg-12">
                        <form id="scholarshipForm" method="post">
                            <div class="border rounded-3 bg-light shadow-sm p-5 fw-bold" style="color: #346473;">
                                <div class="mb-5 col-lg-10">
                                    <label for="title" class="form-label fs-5 mb-3">Scholarship Name:</label>
                                    <textarea class="form-control rounded-3" id="title" name="title" rows="3" required></textarea>
                                </div>
                                <div class="mb-5 col-lg-10">
                                    <label for="desc" class="form-label fs-5 mb-3">Description</label>
                                    <textarea class="form-control rounded-3" id="desc" name="desc" rows="5" required></textarea>
                                </div>
                                <div class="mb-5 col-lg-10">
                                    <label for="qual" class="form-label fs-5 mb-3">Qualifications</label>
                                    <textarea class="form-control rounded-3" id="qual" name="qual" rows="5" required></textarea>
                                </div>
                                <div class="mb-5 col-lg-10">
                                    <label for="req" class="form-label fs-5">Requirements Attachment</label>
                                    <div class="mb-2">
                                        <button type="button" class="btn" id="addRequirementBtn">
                                            <i class='bx bx-plus-medical m-auto me-2' style="color: #346473;"></i>
                                            <span class="m-auto" style="color: #346473;">Add Attachment</span>
                                        </button>
                                    </div>
                                    <div class="requirement-container mb-3 d-flex">
                                        <textarea class="form-control rounded-3 me-3" id="req" name="req[]" rows="1"></textarea>
                                        <button type="button" class="btn btn-danger remove-btn ms-2" onclick="removeRequirement(this)">
                                            <i class='bx bx-minus-circle'></i>
                                        </button>
                                    </div>
                                    <div id="additionalRequirements"></div> <!-- Container for additional requirement fields -->
                                </div>
                                <div class="mb-5 col-lg-12 row gx-5">
                                    <div class="col-lg-5">
                                        <label for="startDate" class="form-label fs-5 mb-3">Start of Application:</label>
                                        <input type="date" class="form-control rounded-3 fs-5" id="startDate" name="startDate" required>
                                    </div>
                                    <div class="col-lg-5 pe-0">
                                        <label for="endDate" class="form-label fs-5 mb-3">End of Application:</label>
                                        <input type="date" class="form-control rounded-3 fs-5" id="endDate" name="endDate" required>
                                    </div>
                                    <div class="col-lg-2 pt-5">
                                        <button type="submit" class="btn btn-lg post-btn shadow" style="background-color: #346473; color: white;">SAVE</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    </form>
                </div>
            </div>

            <div class="container-fluid content m-3 pe-5 me-5" id="div3">
                <div class="m-3 ms-0" onclick="showDiv('div1')">
                    <i style="font-size: 26px;; border: #e0e0e0 solid 1px; background-color: #fff; border-radius: 5px; padding: 0px 5px 0px 5px;" class='bx bx-arrow-back'></i>
                </div>
                <div class="container-fluid rounded-3 shadow-sm p-5 fs-5" style="background-color: #f4f4f4; color: #346473;">

                </div>
            </div>

            <div class="container-fluid mt-3 px-5 mb-5 content" id="div4">
                <div class="m-3 ms-0" onclick="showDiv('div1')">
                    <i style="font-size: 26px;; border: #e0e0e0 solid 1px; background-color: #fff; border-radius: 5px; padding: 0px 5px 0px 5px;" class='bx bx-arrow-back'></i>
                </div>
                <div class="row gx-5">
                    <div class="col-lg-12">
                        <form id="UpdateForm" method="post">
                            <input type="hidden" id="scholarship_no" name="scholarship_no">
                            <div class="border rounded-3 bg-light shadow-sm p-5 fw-bold" style="color: #346473;">
                                <div class="mb-5 col-lg-10">
                                    <label for="title" class="form-label fs-5 mb-3">Scholarship Name:</label>
                                    <textarea class="form-control rounded-3" id="title" name="title" rows="3" required></textarea>
                                </div>
                                <div class="mb-5 col-lg-10">
                                    <label for="desc" class="form-label fs-5 mb-3">Description</label>
                                    <textarea class="form-control rounded-3" id="desc" name="desc" rows="5" required></textarea>
                                </div>
                                <div class="mb-5 col-lg-10">
                                    <label for="qual" class="form-label fs-5 mb-3">Qualifications</label>
                                    <textarea class="form-control rounded-3" id="qual" name="qual" rows="5" required></textarea>
                                </div>
                                <div class="mb-5 col-lg-10">
                                    <label for="req" class="form-label fs-5">Requirements Attachment</label>
                                    <div class="mb-2">
                                        <button type="button" class="btn" id="addRequirementBtn">
                                            <i class='bx bx-plus-medical m-auto me-2' style="color: #346473;"></i>
                                            <span class="m-auto" style="color: #346473;">Add Attachment</span>
                                        </button>
                                    </div>
                                    <div id="additionalRequirements"></div> <!-- Container for additional requirement fields -->
                                </div>
                                <div class="mb-5 col-lg-12 row gx-5">
                                    <div class="col-lg-5">
                                        <label for="startDate" class="form-label fs-5 mb-3">Start of Application:</label>
                                        <input type="date" class="form-control rounded-3 fs-5" id="startDate" name="startDate" required>
                                    </div>
                                    <div class="col-lg-5 pe-0">
                                        <label for="endDate" class="form-label fs-5 mb-3">End of Application:</label>
                                        <input type="date" class="form-control rounded-3 fs-5" id="endDate" name="endDate" required>
                                    </div>
                                    <div class="col-lg-2 pt-5">
                                        <button type="submit" class="btn btn-lg post-btn shadow" style="background-color: #346473; color: white;">SAVE</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    </form>
                </div>
            </div>

            <div class="container-fluid m-4 content p-5" id="div5">
                <div class="m-0" onclick="showDiv('div1')">
                    <i style="font-size: 26px;; border: #e0e0e0 solid 1px; background-color: #fff; border-radius: 5px; padding: 0px 5px 0px 5px;"class='bx bx-arrow-back'></i>
                </div>
                <div class="row">
                    <div class="col-lg-11 d-flex align-items-stretch">
                        <span class="fs-3 col-lg-12 d-flex justify-content-start mb-3" style="color: rgba(52, 100, 115, 0.9);">Archive Scholarship Program</span>
                    </div>
                    <div class="col-lg-1 d-flex align-items-stretch">
                        <span style="font-weight: 700; font-size: 20px; opacity: 0.7;">ARCHIVE</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        $conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

                        $sql = "SELECT * FROM tbl_scholarship_archive";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="d-flex justify-content-between mb-3">';
                                echo '<button class="btn fs-3 col-lg-12 d-flex align-items-center bg-light" style="color: rgba(52, 100, 115, 0.8);" onclick="showDiv(\'div6\', ' . $row["scholarship_no"] . ')">';
                                echo '<div class="col-lg-1 d-flex justify-content-center align-items-center"><i class="bx bx-file me-3"></i></div>';
                                echo '<div class="col-lg-7 d-flex align-items-center"><span style="font-size: smaller;">' . $row["scholarship_name"] . '</span></div>';
                                echo '<div class="col-lg-2 d-flex justify-content-end align-items-center"><span style="font-size: large;">Ended</span></div>';
                                echo '<div class="col-lg-2 d-flex justify-content-end align-items-right"><span style="font-size: large;">' . $row["end_of_applications"] . '</span></div>';
                                echo '</button>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>No archived scholarships found.</p>';
                        }
                    
                        $conn->close();
                        ?>
                    </div>
                </div>
            </div>
            
            <!--div6 eto-->
            <div class="container-fluid content m-3 pe-5 me-5" id="div6">
                <div class="m-3 ms-0" onclick="showDiv('div5')">
                    <i style="font-size: 26px;; border: #e0e0e0 solid 1px; background-color: #fff; border-radius: 5px; padding: 0px 5px 0px 5px;" class='bx bx-arrow-back'></i>
                </div>
                <div class="container-fluid rounded-3 shadow-sm p-5 fs-5" style="background-color: #f4f4f4; color: #346473;">
                    <!-- Scholarship details will be inserted here by JavaScript -->
                </div>
            </div>
        </section>

    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.4/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="sidebar.js"></script>
    <script>

        //pati to minodify ko lang onti para sa div6
        function showDiv(divId, scholarshipNo = null) {
            // Hide all content divs
            const divs = document.querySelectorAll('.content');
            divs.forEach(div => {
                div.classList.remove('active');
            });
        
            // Show the selected div
            document.getElementById(divId).classList.add('active');
        
            // Handle specific div content updates
            if (divId === 'div3' && scholarshipNo) {
                document.getElementById('div3').dataset.scholarshipNo = scholarshipNo;
                updateDiv3Content(scholarshipNo);
            } else if (divId === 'div6' && scholarshipNo) {
                document.getElementById('div6').dataset.scholarshipNo = scholarshipNo;
                updateDiv6Content(scholarshipNo);
            }
        }

        function updateDiv3Content(scholarshipNo) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '', true); // Sends request to the same page
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status === 200) {
                    const response = JSON.parse(this.responseText);
                    if (response.status === 'success') {
                        const content = `
                    <h3>${response.data.scholarship_name}</h3>
                    <p><strong>Description:</strong> ${response.data.description}</p>
                    <p><strong>Qualifications:</strong> ${response.data.qualifications}</p>
                    <h4>Requirements:</h4><ul>${response.data.requirements.map(req => `<li>${req}</li>`).join('')}</ul>
                `;
                        document.querySelector('#div3 .container-fluid').innerHTML = content;
                    } else {
                        document.querySelector('#div3 .container-fluid').innerHTML = `<p>${response.message}</p>`;
                    }
                }
            };
            xhr.send('action=get_scholarship_details&scholarship_no=' + scholarshipNo);
        }

        //same lang neto ung div3 pero para sa div6 to
        function updateDiv6Content(scholarshipNo) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'scholarship_archive.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (this.status === 200) {
                    try {
                        const response = JSON.parse(this.responseText);
                        console.log('Response:', response); // Log the response for debugging
                        if (response.status === 'success') {
                            const content = `
                                <h3>${response.data.scholarship_name}</h3>
                                <p><strong>Description:</strong> ${response.data.description}</p>
                                <p><strong>Qualifications:</strong> ${response.data.qualifications}</p>
                                <p><strong>Start of Applications:</strong> ${response.data.start_of_applications}</p>
                                <p><strong>End of Applications:</strong> ${response.data.end_of_applications}</p>
                                <h4>Requirements:</h4>
                                <ul>${response.data.requirements.map(req => `<li>${req}</li>`).join('')}</ul>
                            `;
                            document.querySelector('#div6 .container-fluid').innerHTML = content;
                        } else {
                            document.querySelector('#div6 .container-fluid').innerHTML = `<p>${response.message}</p>`;
                        }
                    } catch (e) {
                        document.querySelector('#div6 .container-fluid').innerHTML = '<p>Error processing the response.</p>';
                        console.error('Error parsing JSON response:', e);
                    }
                } else {
                    document.querySelector('#div6 .container-fluid').innerHTML = '<p>Error with the request.</p>';
                    console.error('Request failed with status:', this.status);
                }
            };

            xhr.onerror = function() {
                document.querySelector('#div6 .container-fluid').innerHTML = '<p>Network error occurred.</p>';
                console.error('Network error occurred');
            };

            xhr.send('action=get_scholarship_details&scholarship_no=' + scholarshipNo);
        }





        function setupAddRequirementButton(containerId) {
            const addRequirementBtn = document.querySelector(`#${containerId} #addRequirementBtn`);
            if (addRequirementBtn) {
                addRequirementBtn.addEventListener('click', function() {
                    // Create a container for the new requirement
                    const requirementContainer = document.createElement('div');
                    requirementContainer.className = 'requirement-container mb-3 d-flex';

                    // Create a new textarea element
                    const newRequirement = document.createElement('textarea');
                    newRequirement.className = 'form-control rounded-3 me-3';
                    newRequirement.name = 'req[]';
                    newRequirement.rows = 1;

                    // Create a remove button
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn btn-danger remove-btn ms-2';
                    removeBtn.innerHTML = '<i class="bx bx-minus-circle"></i>';
                    removeBtn.onclick = function() {
                        removeRequirement(this);
                    };

                    // Append the textarea and remove button to the container
                    requirementContainer.appendChild(newRequirement);
                    requirementContainer.appendChild(removeBtn);

                    // Append the container to the additional requirements section
                    const additionalRequirements = document.querySelector(`#${containerId} #additionalRequirements`);
                    if (additionalRequirements) {
                        additionalRequirements.appendChild(requirementContainer);
                    }
                });
            }
        }

        // Setup the button for both div2 and div4
        document.addEventListener('DOMContentLoaded', function() {
            setupAddRequirementButton('div2');
            setupAddRequirementButton('div4');
        });


        function removeRequirement(button) {
            // Remove the requirement container
            button.parentElement.remove();
        }

        $(document).ready(function() {
            $('#scholarshipForm').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Collect form data
                var formData = new FormData(this);
                formData.append('action', 'insert_scholarship'); // Add action parameter

                $.ajax({
                    url: '', // Current file
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: result.message,
                            }).then(() => {
                                // Reload the page after clicking OK
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: result.message,
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while saving the scholarship.',
                        });
                    }
                });
            });
        });

        function deleteScholarship(scholarshipNo) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will archiving the scholarship and its requirements.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // First, delete the scholarship
                    fetch('scholarship_archive.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            action: 'delete_scholarship',
                            scholarship_no: scholarshipNo
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Trigger requirement deletion
                            deleteRequirements(scholarshipNo);
                        } else {
                            Swal.fire(
                                'Error!',
                                data.message,
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire(
                            'Error!',
                            'An error occurred while processing your request.',
                            'error'
                        );
                    });
                }
            });
        }

        function deleteRequirements(scholarshipNo) {
            fetch('scholarship_archive.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'delete_requirements',
                    scholarship_no: scholarshipNo
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire(
                        'Deleted!',
                        'The scholarship and its requirements have been archived.',
                        'success'
                    ).then(() => {
                        // Optionally, refresh the page or remove the deleted elements from the DOM
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        data.message,
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error!',
                    'An error occurred while processing your request.',
                    'error'
                );
            });
        }


        function editScholarship(scholarshipNo) {
            showDiv('div4');

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status === 200) {
                    const response = JSON.parse(this.responseText);
                    if (response.status === 'success') {
                        document.querySelector('#div4 #title').value = response.data.scholarship_name;
                        document.querySelector('#div4 #desc').value = response.data.description;
                        document.querySelector('#div4 #qual').value = response.data.qualifications;
                        document.querySelector('#div4 #startDate').value = response.data.start_of_applications;
                        document.querySelector('#div4 #endDate').value = response.data.end_of_applications;

                        const requirementsContainer = document.querySelector('#div4 #additionalRequirements');
                        requirementsContainer.innerHTML = '';

                        response.data.requirements.forEach((req, index) => {
                            const reqField = `
                        <div class="requirement-container mb-3 d-flex">
                            <textarea class="form-control rounded-3 me-3" name="req[]" rows="1">${req}</textarea>
                            <button type="button" class="btn btn-danger remove-btn ms-2" onclick="removeRequirement(this)">
                                <i class='bx bx-minus-circle'></i>
                            </button>
                        </div>
                    `;
                            requirementsContainer.insertAdjacentHTML('beforeend', reqField);
                        });

                        document.querySelector('#div4 #scholarship_no').value = scholarshipNo;
                    } else {
                        alert(response.message);
                    }
                }
            };
            xhr.send('action=get_scholarship_details&scholarship_no=' + scholarshipNo);
        }



        // Add event listener for form submission in div4
        document.getElementById('UpdateForm').addEventListener('submit', function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to save these changes?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData(this);

                    // Filter out empty requirements
                    const requirements = Array.from(document.querySelectorAll('#additionalRequirements textarea')).map(textarea => textarea.value.trim()).filter(value => value !== '');
                    formData.set('req', JSON.stringify(requirements)); // Send as JSON string

                    formData.append('action', 'update_scholarship');

                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '', true);
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            try {
                                const response = JSON.parse(xhr.responseText);
                                if (response.status === 'success') {
                                    Swal.fire(
                                        'Saved!',
                                        'Your changes have been saved.',
                                        'success'
                                    ).then(() => {
                                        // Reload the page
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            } catch (error) {
                                Swal.fire('Error!', 'Invalid JSON response from server.', 'error');
                            }
                        } else {
                            Swal.fire('Error!', 'Failed to save changes.', 'error');
                        }
                    };
                    xhr.send(formData);
                }
            });
        });

        


        /// log out button
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
    </script>
</body>

</html>