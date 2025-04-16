<?php
session_start();

if (!isset($_SESSION['Admin_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ../homepage/login_page.php");
    exit();
}else{
    $Admin_id = $_SESSION['Admin_id'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="custom.css">
    <!-- SweetAlert2 -->
    <script src="sweetalert2.all.min.js"></script>
    <link href="sweetalert2.min.css" rel="stylesheet">
    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <title>Admin Profile</title>
    <style>
        .subtitle {
            padding-top: 40px;
            font-size: 18px;
            font-family: Inter;
            height: 50px;
        }

        .definition {
            text-align: center;
            padding-top: 30px;
            font-size: 18px;
            font-family: Inter;
            height: 40px;
        }

        .app {
            text-align: left;
            padding-top: 90px;
            font-size: 18px;
            font-family: Inter;
            height: 40px;
        }

        .bold {
            color: #346473;
        }

        .left {
            text-align: left;
            padding-top: 70px;
            font-size: 18px;
            font-family: Inter;
        }

        .col3 {
            text-align: left;
            padding-top: 20px;
            font-size: 18px;
            font-family: Inter;
        }

        .span_bold {
            color: #346473;
            font-weight: bold;
        }

    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar open">
        <div class="home-content">
            <i class='bx bx-menu'></i>
        </div>
        <div class="logo-details justify-content-center">
            <span class="logo_name">SCHOLARSHIP SYSTEM</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="#">
                    <i class='bx bxs-user'></i>
                    <span class="link_name">ADMIN PROFILE</span>
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
                <a href="#">
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

    <!-- Main content section -->
    <section class="home-section">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <span class="ms-4 fw-bold">PROFILE</span>
                <div class="d-flex ms-auto">
                    <a href="#" class="nav-link d-flex align-items-center" style="color: #25A55F;">
                        <span class="me-2 fw-normal">ADMIN</span>
                        <i class='bx bxs-user-circle custom-icon'></i>
                    </a>
                </div>
            </div>
        </nav>

        <hr>

        
            <div class="row">
                <div class="title-page">
                    <span id="title-name" style="color:#346473;">SCHOLARSHIP PROGRAM</span>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="main-container" style="max-height: none;">
                        <div class="row">
                            <div class="col-lg-12 col-md-8 col-sm-12" style="text-align:center;">
                                <b class="subtitle">Provincial Scholarship for Cavite State University</b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-6 col-sm-12">
                                <p class="definition">The Provincial Scholarship for Cavite State University (CvSU) is a prestigious program established by the Provincial Government of Cavite to support local students in pursuing higher education. This scholarship aims to assist academically talented and financially disadvantaged students from Cavite in achieving their educational goals at Cavite State University.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-8 col-sm-12">
                                <p class="app"><b class="bold">Application Start:</b> Application Start: May 1, 2024<br>
                                    <b class="bold">Application Deadline:</b> May 30, 2024</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12" style="padding-left:30px;">
                                <p class="left">
                                    <span class="span_bold">Requirements:</span><br>
                                    • ID picture * <span style="color:#346473;font-weight: bold;">to be processed by Admin</span><br>
                                    • Academic Grades / Transcripts * <span class="span_bold">to be processed by Admin</span><br>
                                    • PSA (Philippine Statistics Authority) documents<br>
                                    • Application Form<br>
                                    • Statement of Purpose / Personal letter
                                </p>
                            </div>
                        </div>
                        <div class="row" style="padding-left:20px;">
                            <div class="col-lg-3 col-sm-12">
                                <p class="col3">
                                    <span class="span_bold">Academic Achievement:</span><br>
                                    Minimum GPA of 85% or higher required.<br>
                                    • Below 85%: Ineligible<br>
                                    • 85% - 89%: Acceptable<br>
                                    • 90% or higher: Excellent<br>
                                </p>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <p class="col3">
                                    <span class="span_bold">Profile Completion:</span><br>
                                    Accurate filling of financial background details in the profile.<br>
                                    • Missing information: Ineligible<br>
                                    • Incomplete information: Partial marks<br>
                                    • All required information provided: Full marks <br>
                                </p>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <p class="col3">
                                    <span class="span_bold">Document Submission:</span><br>
                                    Upload all required documents within specified deadlines.<br>
                                    • Missing or late submission of critical documents: Ineligible<br>
                                    • Some documents submitted on time: Partial marks<br>
                                    • All documents submitted on time: Full marks<br>
                                </p>
                            </div>
                            <div class="save">
                                <button class="button" style="padding: 7px 30px 7px 30px;">Back</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- JavaScript libraries (Bootstrap JS, SweetAlert2, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Custom JavaScript -->
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

        /// log out button
        document.getElementById('logout-link').addEventListener('click', function (event) {
            event.preventDefault(); // Prevent the default link click behavior
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#346473',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the user clicks "Yes", navigate to the logout page
                    window.location.href = event.target.href = "../homepage/login page.php";
                }
            });
        });
    </script>
</body>

</html>