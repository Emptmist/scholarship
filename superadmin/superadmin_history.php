<?php
session_start();
ob_start();

$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

// Fetch scholarship options for the select dropdown
$sql = "SELECT * FROM tbl_scholarship";
$result = $conn->query($sql);

$options = ""; // Initialize options string
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $scholarship_no = $row['scholarship_no'];
        $scholarship_name = $row['scholarship_name'];
        $options .= "<option value='$scholarship_no'>$scholarship_name</option>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin</title>

    <!-- Bootstrap -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap.bundle.min.js"></script>
    <script src="bootstrap.min.js"></script>

    <!-- Icons -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!-- Icon website -->
    <link rel="icon" type="image/x-icon" href="../homepage/logo.png">

    <!-- CSS -->
    <link rel="stylesheet" href="superadmin.css">

    <!-- SweetAlert2 -->
    <script src="sweetalert2.all.min.js"></script>
    <link href="sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <li><a href="superadmin_dashboard.php"><i class='bx bxs-home'></i><span class="link_name">DASHBOARD</span></a></li>
            <li><a href="superadmin_Student.php"><i class='bx bxs-user'></i><span class="link_name">STUDENT</span></a></li>
            <li><a href="superadmin_coor.php"><i class='bx bxs-user-detail'></i><span class="link_name">COORDINATOR</span></a></li>
            <li style="border-radius: 5px; background: rgba(244, 244, 244, 0.20); box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.25);">
                <a href="superadmin_history.php"><i class='bx bx-history'></i><span class="link_name">LOGIN HISTORY</span></a>
            </li>
            <li><a href="superadmin_setting.php"><i class='bx bxs-cog'></i><span class="link_name">SETTING</span></a></li>
            <li>
                <a href="superadmin_announcement.php">
                    <i class='bx bxs-megaphone'></i>
                    <span class="link_name">ANNOUNCEMENT</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">ANNOUNCEMENT</a></li>
                </ul>
            </li>
            <li><a href="" id="logout-link"><i class='bx bxs-log-out'></i><span class="link_name ">LOG OUT</span></a></li>
        </ul>
    </div>

    <section class="home-section">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <span class="ms-4 fw-bold">LOGIN HISTORY</span>
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
        <div class="main-container">
            <div class="row">
                <div class="col-sm-12">
                    <input type="date" id="date-input" name="search-date" class="input-fieldss">
                    <div class="content-application">
                        <form id="search-form" method="POST">
                            <select id="role-select" style="border: none; width:350px" class="application-btn" name="req_name" required>
                                <option value="" disabled selected>Select User</option>
                                <option value="coordinator">Coordinator</option>
                                <option value="student">Student</option>
                            </select>
                            <input id="search-input" class="search-input" type="text" name="search-pending" placeholder="Search">
                            <button name="submit" value="submit-pending">
                                <div class='bx bx-search'></div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12">
                    <table class="table-striped">
                        <tr>
                            <th>EMAIL</th>
                            <th>LAST APPLIED</th>
                            <th>LOGIN TIME</th>
                            <th>LOGOUT TIME</th>
                            <th>ACCOUNT STATUS</th>
                        </tr>
                        <tbody id="results-container">
                            <!-- Default data will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="one"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role-select');
            const searchInput = document.getElementById('search-input');
            const dateInput = document.getElementById('date-input');

            function fetchResults(role = '', searchTerm = '', searchDate = '') {
                const params = new URLSearchParams({
                    req_name: role,
                    search_pending: searchTerm,
                    search_date: searchDate
                });

                fetch('fetch_results.php', {
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

            // Fetch default data on page load
            fetchResults();

            // Attach event listeners
            roleSelect.addEventListener('change', () => fetchResults(roleSelect.value, searchInput.value, dateInput.value));
            searchInput.addEventListener('input', () => fetchResults(roleSelect.value, searchInput.value, dateInput.value));
            dateInput.addEventListener('input', () => fetchResults(roleSelect.value, searchInput.value, dateInput.value));
        });
    </script>

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

        // Log out button
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
