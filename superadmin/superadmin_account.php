<?php
session_start();

ob_start();

$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');


$sql = "SELECT * FROM tbl_scholarship";
$result = $conn->query($sql);

$options = ""; // Initialize options string
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $scholarship_no = $row['scholarship_no'];
        $scholarship_name = $row['scholarship_name'];
        $options .= "<option value='$scholarship_no'>$scholarship_name</option>"; // Set value to no_req
    }
}

// Check if the session variable is set
if (!isset($_SESSION['Super_admin_Id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ../homepage/login_page.php");
    exit();
} else {
    $Super_admin_Id = $_SESSION['Super_admin_Id'];
}

// SUPER ADMIN
$sql_s_admin = "SELECT * FROM tbl_super_admin_account WHERE Super_admin_Id = $Super_admin_Id";
$result_sadmin = $conn->query($sql_s_admin);
if ($result_sadmin->num_rows > 0) {
    $row = $result_sadmin->fetch_assoc();
    $Username = $row['Username'];
    $Email = $row['Email']; // Assuming there's an Email column
    $Password = $row['Password']; // Assuming there's a Password column
} else {
    $Username = "N/A";
    $Email = "N/A";
    $Password = "N/A";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin</title>

    <!--bootstrap-->
    <link href="bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap.bundle.min.js"></script>
    <script src="bootstrap.min.js"></script>

    <!--icons-->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!--icon website-->
    <link rel="icon" type="image/x-icon" href="../homepage/logo.png">

    <!--css-->
    <link rel="stylesheet" href="superadmin.css">

    <!--sweetalert2-->
    <script src="sweetalert2.all.min.js"></script>
    <link href="sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            overflow: hidden;
        }
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
                <a href="superadmin_dashboard.php">
                    <i class='bx bxs-home'></i>
                    <span class="link_name">DASHBOARD</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">DASHBOARD</a></li>
                </ul>
            </li>
            <li>
                <a href="superadmin_Student.php">
                    <i class='bx bxs-user'></i>
                    <span class="link_name">STUDENT</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">STUDENT</a></li>
                </ul>
            </li>
            <li>
                <a href="superadmin_coor.php">
                    <i class='bx bxs-user-detail'></i>
                    <span class="link_name">COORDINATOR</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">COORDINATOR</a></li>
                </ul>
            </li>
            <li>
                <a href="superadmin_history.php">
                    <i class='bx bx-history'></i>
                    <span class="link_name">LOGIN HISTORY</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">LOGIN HISTORY</a></li>
                </ul>
            </li>
            <li style="border-radius: 5px;
background: rgba(244, 244, 244, 0.20);
box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.25);">
                <a href="#">
                    <i class='bx bxs-cog'></i>
                    <span class="link_name">SETTING</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">SETTING</a></li>
                </ul>
            </li>
            <li>
                <a href="superadmin_announcement.php">
                    <i class='bx bxs-megaphone'></i>
                    <span class="link_name">ANNOUNCEMENT</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">ANNOUNCEMENT</a></li>
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
                <span class=" ms-4 fw-bold">SETTING</span>
                <div class="d-flex ms-auto">
                    <a href="#" class="nav-link d-flex align-items-center">
                        <span class="me-2 fw-normal">SUPER ADMIN</span>
                        <i class='bx bxs-user-circle custom-icon'></i>
                    </a>
                </div>
            </div>
        </nav>

        <hr>

        <!--main content-->
        <div class="right-sidebar">
            <div class="sidebar-buttons">
                <div class="sidebar-button">
                    <a href="superadmin_account.php" style="text-decoration:none;">
                        <h3>Your Account</h3>
                        <p>Details of your Account</p>
                    </a>
                </div>
                <div class="sidebar-button">
                    <a href="superadmin_setting.php" style="text-decoration:none;">
                        <h3>FAQ</h3>
                        <p>Setting up FAQ</p>
                    </a>
                </div>
                <div class="sidebar-button">
                    <a href="superadmin_feedback.php" style="text-decoration:none;">
                        <h3>Feedback</h3>
                        <p>View user’s feedback</p>
                    </a>
                </div>
            </div>
        </div>
        <form id="adminForm">
            <div class="row">
                <div class="col-lg-10">
                    <div class="main-container" style="max-height: none;">
                        <div id="admin-account" class="content-section active">
                            <h4><b>ADMIN ACCOUNT</b></h4>
                            <hr>
                            <div class="account-form">
                                <div class="col-lg-5">
                                    <div class="image-holder">
                                        <p class="nlabel"><b><?php echo $Username; ?></b></p>
                                    </div>
                                </div>
                                <label style="font-size: 20px; margin-bottom:10px; margin-top:25px;">Email Address:</label>
                                <input type="email" id="email" value="<?php echo $Email; ?>">
                                <button type="button" id="email-btn" class="update-btn" disabled>Update</button>

                                <label style="font-size: 20px; margin-bottom:10px;">Password:</label>
                                <input type="password" id="password" value="****************************">
                                <button type="button" id="pw-btn" class="update-btn" disabled>Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <div class="one"></div>
    <!-- Include SweetAlert2 and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            const emailBtn = document.getElementById('email-btn');
            const passwordInput = document.getElementById('password');
            const pwBtn = document.getElementById('pw-btn');

            emailInput.addEventListener('input', function() {
                if (emailInput.value !== "") {
                    emailBtn.disabled = false;
                } else {
                    emailBtn.disabled = true;
                }
            });

            passwordInput.addEventListener('input', function() {
                if (passwordInput.value !== "") {
                    pwBtn.disabled = false;
                } else {
                    pwBtn.disabled = true;
                }
            });

            // Clear password field when clicked
            passwordInput.addEventListener('focus', function() {
                passwordInput.value = "";
                pwBtn.disabled = true; // Optionally keep the button disabled until the user types something new
            });
        });


        document.getElementById('email-btn').addEventListener('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to update the email?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let email = document.getElementById('email').value;
                    updateAdmin('email', email);
                }
            });
        });

        document.getElementById('pw-btn').addEventListener('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to update the password?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let password = document.getElementById('password').value;
                    updateAdmin('password', password);
                }
            });
        });

        function updateAdmin(field, value) {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_admin.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status == 200) {
                    Swal.fire(
                        'Updated!',
                        'Your changes have been saved.',
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Error!',
                        'There was an issue saving your changes.',
                        'error'
                    );
                }
            };
            xhr.send('field=' + field + '&value=' + value);
        }

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
                    // If the user clicks "Yes", navigate to the logout page
                    window.location.href = event.target.href = "../homepage/login_page.php";
                }
            });
        });
    </script>

</body>

</html>