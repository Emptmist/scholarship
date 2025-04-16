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
            <li style="border-radius: 5px;
background: rgba(244, 244, 244, 0.20);
box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.25);">
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
            <li>
                <a href="superadmin_setting.php">
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
                <span class=" ms-4 fw-bold">STUDENT</span>
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
        <div class="main-container" id="div1">
            <div class="row">
                <div class="col-sm-12">
                    <button class="application-btn" id="buttonInDiv1" style="float: left;"><i class='bx bxs-user-detail'></i>Enrolled Student List</button>
                    <div class="content-application">
                        <form action="" method="POST">
                            <select style="border: none; width:350px; text-align:center;" class="application-btn" id="select_Scholar_name" name="req_name">
                                <option value="" disabled selected>Select Scholarship Name</option>
                                <?php echo $options; ?>
                            </select>
                            <select style="border: none;" name="status_select" id="status_select" class="application-btn">
                                <option value="" disabled selected>Select Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <input class="search-input" type="text" name="search_user" id="search_user" value="<?php echo isset($_POST['search_user']) ? htmlspecialchars($_POST['search_user']) : ''; ?>" placeholder="   Search">
                            <button type="button" name="submit" value="submit-pending">
                                <div class='bx bx-search'></div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 content-student">
                    <table class="table-striped">
                        <tr>
                            
                            <th>STUDENT ID</th>
                            <th>LAST NAME</th>
                            <th>FIRST NAME</th>
                            <th>EMAIL ADDRESS</th>
                            <th>SCHOLARSHIP NAME</th>
                            <th style='text-align: center;'>COORDINATOR ID</th>
                            <th style='text-align: center;'>STATUS</th>
                        </tr>
                        <tbody id="results-container">
                        <?php

                            // Number of records to show per page
                            $records_per_page = 10;

                            // Get the current page or set a default
                            $current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

                            // Calculate the starting record for the query
                            $offset = ($current_page - 1) * $records_per_page;

                            // Get the total number of records
                            $total_records_sql = "SELECT COUNT(*) AS total FROM tbl_student_acc";
                            $total_records_result = $conn->query($total_records_sql);
                            $total_records = $total_records_result->fetch_assoc()['total'];

                            // Calculate the total number of pages
                            $total_pages = ceil($total_records / $records_per_page);

                            // Default display for the table when the page loads
                            $sql_default = "
                                SELECT 
                                    tbl_student_acc.Student_No, 
                                    tbl_student_acc.First_name, 
                                    tbl_student_acc.Last_name, 
                                    tbl_student_acc.Email_Address, 
                                    tbl_scholarship.scholarship_name,
                                    tbl_application_scholarship.Admin_id,
                                    tbl_application_scholarship.C_status
                                FROM 
                                    tbl_student_acc 
                                LEFT JOIN 
                                    tbl_application_scholarship 
                                ON 
                                    tbl_student_acc.Student_No = tbl_application_scholarship.Student_No 
                                LEFT JOIN 
                                    tbl_scholarship 
                                ON 
                                    tbl_scholarship.scholarship_no = tbl_application_scholarship.scholarship_no 
                                ORDER BY 
                                    tbl_student_acc.Last_name ASC
                                LIMIT $records_per_page OFFSET $offset
                            ";
                            $result_default = $conn->query($sql_default);

                            if ($result_default->num_rows > 0) {
                                $row_count = 0; // Counter for row colors

                                while ($row = $result_default->fetch_assoc()) {
                                    // Alternate row color
                                    $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
                                    $row_count++;

                                    // Use a placeholder if value is NULL
                                    $admin_id = !empty($row["Admin_id"]) ? htmlspecialchars($row["Admin_id"]) : 'Not Assigned';
                                    $scholarship_name = !empty($row["scholarship_name"]) ? htmlspecialchars($row["scholarship_name"]) : 'No Scholarship';
                                    $c_status = !empty($row["C_status"]) ? htmlspecialchars($row["C_status"]) : 'Status Unknown';

                                    // Determine the color for status
                                    $status_color = '#346473'; // Default color
                                    if (strtolower($c_status) == 'pending') {
                                        $status_color = 'gray';
                                    } elseif (strtolower($c_status) == 'approved') {
                                        $status_color = 'green';
                                    } elseif (strtolower($c_status) == 'rejected') {
                                        $status_color = 'red';
                                    }

                                    echo "<tr class='$row_class'>
                                        <td>" . htmlspecialchars($row["Student_No"]) . "</td>
                                        <td>" . htmlspecialchars($row["Last_name"]) . "</td>
                                        <td>" . htmlspecialchars($row["First_name"]) . "</td>
                                        <td>" . htmlspecialchars($row["Email_Address"]) . "</td>
                                        <td>" . $scholarship_name . "</td>
                                        <td style='text-align: center;'>" . $admin_id . "</td>
                                        <td style='text-align: center; color: $status_color;'>" . $c_status . "</td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr>
                                    <td colspan='7' style='text-align: center;'>NO AVAILABLE APPLICATION!</td>
                                </tr>";
                            }
                            ?>

                        </tbody>
                    </table>
                    <?php
                    // Pagination controls
                            echo "<div class='pagination' style='text-align: center; margin-top: 20px;'>";
                            if ($current_page > 1) {
                                echo "<a href='?page=" . ($current_page - 1) . "'>&laquo; Previous</a> ";
                            }

                            for ($page = 1; $page <= $total_pages; $page++) {
                                if ($page == $current_page) {
                                    echo "<a href='' style='background-color:#dddddd;'>$page</a> ";
                                } else {
                                    echo "<a href='?page=$page'>$page</a> ";
                                }
                            }

                            if ($current_page < $total_pages) {
                                echo "<a href='?page=" . ($current_page + 1) . "'>Next &raquo;</a>";
                            }
                            echo "</div>";


                    ?>
                </div>
            </div>


        </div>
        <div id="div2" style="display: none;">
            <div class="row" style="margin: 0px 0px -30px 50px;">
                <div class="col-sm-12">
                    <div class="m-3 ms-0" id="buttonInDiv2">
                        <i style="font-size: 26px;; border: #e0e0e0 solid 1px; background-color: #fff; border-radius: 5px; padding: 0px 5px 0px 5px;" class='bx bx-arrow-back'></i>
                    </div>
                </div>
            </div>
            <div class="main-container">
                <div class="row">
                    <div class="col-sm-8 col-md-8">
                        <span style="font-size: 20px; color:#346473;">CAVITE STATE UNIVERSITY STUDENT LIST</span>
                        <div class="content-application">
                            <form action="import_excel.php" method="post" enctype="multipart/form-data">
                                <label for="file-input" class="custom-file-label">Choose File</label>
                                <input type="file" id="file-input" class="custom-file-input" name="import-file" accept=".xlsx, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
                                <button class="application-btn" name="excel-data">
                                    <div style="font-size: 16px;" class='bx bx-list-plus'></div> Import Student List
                                </button>

                            </form>
                        </div>
                    </div>
                    <?php
                        // Check if 'student_no' is set
                        if (isset($_POST['student_no'])) {
                            $student_no = $conn->real_escape_string($_POST['student_no']);

                            // Prepare the SQL DELETE statement
                            $sql = "DELETE FROM tbl_cvsu_students WHERE Student_No = '$student_no'";

                            if ($conn->query($sql) === TRUE) {
                                echo '<script>Swal.fire({
                                        title: "Deleted!",
                                        text: "Student Data has been deleted.",
                                        icon: "success",
                                        confirmButtonColor: "#28a745"
                                        });</script>';
                            } else {
                                echo "Error deleting record: " . $conn->error;
                            }
                        }


                    ?>
                    
                    <div class="col-lg-4 col-md-12">
                        <form id="searchForm">
                            <input class="search-input" type="text" id="search_student" name="search_student" value="<?php echo isset($_POST['search_student']) ? htmlspecialchars($_POST['search_student']) : ''; ?>" placeholder="   Search">
                            <button type="button" id="searchButton">
                                <div class='bx bx-search'></div>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 content-student">

                        <div id="results-container2">

                        </div>

                    </div>
                </div>

    </section>

    <div class="one"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectScholarName = document.getElementById('select_Scholar_name');
            const statusSelect = document.getElementById('status_select');
            const searchUser = document.getElementById('search_user');

            function fetchResultss() {
                const ScholarName = selectScholarName.value;
                const status = statusSelect.value;
                const searchUserVal = searchUser.value;

                // Prepare the data for AJAX request
                const params = new URLSearchParams({
                    req_name: ScholarName,
                    status_select: status,
                    search_user: searchUserVal
                });

                fetch('student_results.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: params.toString()
                    })
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('results-container').innerHTML = data;
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Attach event listeners
            selectScholarName.addEventListener('change', fetchResultss);
            statusSelect.addEventListener('change', fetchResultss); // Use 'change' for select elements
            searchUser.addEventListener('input', fetchResultss);
        });


        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search_student');
            const resultsContainer = document.getElementById('results-container2');
            const searchButton = document.getElementById('searchButton');

            function fetchResults(page = 1) {
                const searchTerm = searchInput.value;

                const params = new URLSearchParams({
                    search_student: searchTerm,
                    page: page
                });

                fetch('cvsustudent.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: params.toString()
                    })
                    .then(response => response.text())
                    .then(data => {
                        resultsContainer.innerHTML = data;
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Trigger search on input
            searchInput.addEventListener('input', function() {
                fetchResults(); // Fetch results when typing
            });

            // Trigger search on button click
            searchButton.addEventListener('click', function() {
                fetchResults(); // Fetch results on button click
            });

            // Handle pagination clicks
            document.addEventListener('click', function(event) {
                if (event.target.classList.contains('pagination-link')) {
                    event.preventDefault();
                    const page = event.target.getAttribute('data-page');
                    fetchResults(page);
                }
            });

            // Initial fetch to load first page
            fetchResults();
        });



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
        function replaceDiv(targetDiv) {
            const div1 = document.getElementById('div1');
            const div2 = document.getElementById('div2');

            // Hide both divs initially
            div1.style.display = 'none';
            div2.style.display = 'none';

            // Show the target div based on the parameter
            if (targetDiv === 'div2') {
                div2.style.display = 'block';
            } else if (targetDiv === 'div1') {
                div1.style.display = 'block';
            }
        }

        // Add event listener to the button in div1
        document.getElementById('buttonInDiv1').addEventListener('click', () => {
            replaceDiv('div2'); // Adjust to show div2 and hide div1
        });

        // You can add a similar event listener to return to div1
        document.getElementById('buttonInDiv2').addEventListener('click', () => {
            replaceDiv('div1'); // Adjust to show div1 and hide div2
        });

        function showDiv2() {
            // Display the div when the form is submitted
            document.getElementById('div2').style.display = 'block';
        }


        document.addEventListener('DOMContentLoaded', function() {
            // Check URL parameters to show div2
            const urlParams = new URLSearchParams(window.location.search);
            const showDiv2 = urlParams.get('showDiv2');

            if (showDiv2 === 'true') {
                replaceDiv('div2');
            }

            <?php if (isset($_SESSION['message'])): ?>
                const messageType = '<?php echo $_SESSION['message']['type']; ?>';
                const messageText = '<?php echo $_SESSION['message']['text']; ?>';

                Swal.fire({
                    icon: messageType,
                    title: messageText,
                    showConfirmButton: true,
                    confirmButtonColor: '#25A55F',
                }).then((result) => {
                    if (result.isConfirmed) {
                        <?php unset($_SESSION['message']); ?>
                        // Reset the file input after the alert
                        document.querySelector('input[name="import-file"]').value = '';
                    }
                });
            <?php endif; ?>
        });

        function replaceDiv(divId) {
            const divs = ['div1', 'div2'];

            divs.forEach(id => {
                const div = document.getElementById(id);
                if (div) {
                    div.style.display = 'none';
                }
            });

            const selectedDiv = document.getElementById(divId);
            if (selectedDiv) {
                selectedDiv.style.display = 'block';
            }
        }
        document.getElementById('file-input').addEventListener('change', function() {
            const fileName = this.files.length > 0 ? this.files[0].name : 'Choose File';
            document.querySelector('.custom-file-label').textContent = fileName;
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
                    // If the user clicks "Yes", navigate to the logout page
                    window.location.href = event.target.href = "../homepage/login_page.php";
                }
            });
        });
    </script>

</body>

</html>