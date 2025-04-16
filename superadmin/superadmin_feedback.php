<?php
session_start();
ob_start();

$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

// Initialize variables for filtering
$categoryFilter = isset($_POST['feeback-category']) ? $_POST['feeback-category'] : '';
$searchTerm = isset($_POST['search-feedback']) ? $_POST['search-feedback'] : '';

// SQL query to filter feedback based on category and search term
$sql = "SELECT 
                tbl_feedback.feedback_date, 
                tbl_feedback.feedback_category, 
                tbl_student_acc.Email_Address, 
                tbl_student_acc.Student_No, 
                tbl_feedback.feedback_message,
                tbl_feedback.feedback_image
            FROM tbl_feedback 
            LEFT JOIN tbl_student_acc 
                ON tbl_feedback.Student_No = tbl_student_acc.Student_No
            WHERE 1=1"; // Start with a true condition

// Apply category filter if selected
if (!empty($categoryFilter)) {
    $sql .= " AND tbl_feedback.feedback_category = '$categoryFilter'";
}

// Apply search filter if search term is entered
if (!empty($searchTerm)) {
    $sql .= " AND (tbl_feedback.feedback_date LIKE '%$searchTerm%' 
                    OR tbl_feedback.feedback_category LIKE '%$searchTerm%'
                    OR tbl_student_acc.Email_Address LIKE '%$searchTerm%')";
}

$result = $conn->query($sql);
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
    <link rel="icon" type="image/x-icon" href="logo.png">

    <!--css-->
    <link rel="stylesheet" href="superadmin.css">

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
                <span class=" ms-4 fw-bold">COORDINATOR</span>
                <div class="d-flex ms-auto">
                    <a href="#" class="nav-link d-flex align-items-center">
                        <span class="me-2 fw-normal">SUPER ADMIN</span>
                        <i class='bx bxs-user-circle custom-icon'></i>
                    </a>
                </div>
            </div>
        </nav>

        <hr>

        <!-- Main content -->
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
        <div class="main-container col-lg-9">
            <div class="row">
                <!-- Feedback form -->
                <div class="col-sm-7 content-student">
                    <div class="feedback-content">
                        <form action="" method="POST">
                            <select style="border: none; margin-top:10px; padding-left:6px;" name="feeback-category" id="category" class="category-btn" placeholder="Category" onchange="this.form.submit()" required>
                                <option value="" disabled selected>Select Category</option>
                                <option value="Bug Reports" <?php if ($categoryFilter == 'Bug Reports') echo 'selected'; ?>>Bug Reports</option>
                                <option value="Comments" <?php if ($categoryFilter == 'Comments') echo 'selected'; ?>>Comments</option>
                                <option value="Suggestions" <?php if ($categoryFilter == 'Suggestions') echo 'selected'; ?>>Suggestions</option>
                                <option value="Questions" <?php if ($categoryFilter == 'Questions') echo 'selected'; ?>>Questions</option>
                            </select>
                            <input class="search-feedback2" type="text" name="search-feedback" placeholder="   Search" value="<?php echo $searchTerm; ?>">
                            <button name="submit" value="submit-search">
                                <div class='bx bx-search'></div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Left side: Feedback Table -->
                <div class="col-sm-7 content-student">
                    <?php
                    if ($result->num_rows > 0) {
                        echo "<table>
                                    <tr>
                                        <th>DATE</th>
                                        <th>FEEDBACK CATEGORY</th>
                                        <th>EMAIL</th>
                                        <th style='text-align: center;'>ACTION</th>
                                    </tr>";
                        while ($row = $result->fetch_assoc()) {
                            $feedback_date = $row['feedback_date'];
                            $feedback_category = $row['feedback_category'];
                            $email = $row['Email_Address'];
                            $feedback_message = $row['feedback_message'];
                            $feedback_image = $row['feedback_image'];

                            echo "<tr>
                                        <td>$feedback_date</td>
                                        <td>$feedback_category</td>
                                        <td>$email</td>
                                        <td style='text-align: center;'>
                                            <button type='button' class='btn' style='color: #25A55F; font-weight:600; border:none;' onclick='showFeedbackDetails(\"$feedback_date\",\"$feedback_message\", \"$feedback_image\")'>View</button>
                                        </td>
                                      </tr>";
                        }
                        echo "</table><br><br>";
                    } else {
                        echo "<table>
                                    <tr>
                                        <th>DATE</th>
                                        <th>FEEDBACK CATEGORY</th>
                                        <th>EMAIL</th>
                                        <th style='text-align: center;'>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td colspan='4' style='text-align: center;'>NO FEEDBACK AVAILABLE!</td>
                                    </tr>
                                  </table>";
                    }
                    ?>
                </div>

                <!-- Right side: Feedback Details -->

                <div class="col-sm-5">
                    <div id="feedback-details-container" style="background-color: white; border-radius: 10px; padding: 10px;">
                        <h4>Feedback Details</h4>
                        <div id="feedback-date"></div>
                        <div id="feedback-message">Please select a feedback to view details.</div>
                        <div id="feedback-image"></div>
                    </div>
                </div>
            </div>
        </div>

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

            function showFeedbackDetails(date, message, image) {
                // Display the feedback date
                document.getElementById('feedback-date').innerText = "Date: " + date;

                // Display the feedback message
                document.getElementById('feedback-message').innerText = message;

                // Display the feedback image
                if (image) {
                    var imagePath = '../adminside/admin-UPLOAD_FILEs/' + image;
                    document.getElementById('feedback-image').innerHTML = '<img src="' + imagePath + '" alt="Feedback Image" style="max-width: 100%;">';
                } else {
                    document.getElementById('feedback-image').innerHTML = '';
                }
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