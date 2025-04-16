<?php 
        session_start();

        ob_start();

        $conn = new mysqli('localhost','root','','db_scholarship_system');


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

        include '../homepage/Time_Expiration.php';
        scholarship_expiration($conn);

?>
<!--php for pie chart-->
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_scholarship_system";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "SELECT C_Year_graduated, COUNT(*) as count
        FROM tbl_college_edu
        GROUP BY C_Year_graduated";
    $result = $conn->query($sql);

    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = array($row['C_Year_graduated'], (int)$row['count']);
    }

    $jsonData = json_encode($data);
    $jsonColors = json_encode(array('#CAF2D0', '#a9f2b4', '#83C78E', '#57805b', '#39563C'));
?>

<!--php for combo chart-->
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_scholarship_system";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT 
                s.scholarship_name,
                SUM(CASE WHEN a.C_status = 'approved' THEN 1 ELSE 0 END) AS approved_count,
                SUM(CASE WHEN a.C_status = 'rejected' THEN 1 ELSE 0 END) AS rejected_count,
                SUM(CASE WHEN a.C_status = 'pending' THEN 1 ELSE 0 END) AS pending_count,
                COUNT(a.C_status) AS total_count
            FROM 
                tbl_application_scholarship a
            JOIN 
                tbl_scholarship s ON a.scholarship_no = s.scholarship_no
            GROUP BY 
                s.scholarship_name";

    $result = $conn->query($sql);

    $dataArray = [["Scholarship Program", "Approved", "Rejected", "Under Review", "Total"]];
if ($result->num_rows > 0) {
    foreach ($result as $row) {
        $dataArray[] = [
            $row['scholarship_name'],
            (int)$row['approved_count'],
            (int)$row['rejected_count'],
            (int)$row['pending_count'],
            (int)$row['total_count']
        ];
    }
} else {
    $dataArray[] = ['No Data', 0, 0, 0, 0];
}
?>

<!--php for line chart-->
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_scholarship_system";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to calculate the average GWA per scholarship
    $sql = "SELECT 
                    s.scholarship_name,
                    AVG(e.C_GPA) AS average_gwa
                FROM 
                    tbl_college_edu e
                JOIN 
                    tbl_application_scholarship a ON e.student_no = a.student_no
                JOIN 
                    tbl_scholarship s ON a.scholarship_no = s.scholarship_no
                GROUP BY 
                    s.scholarship_name";

    $result = $conn->query($sql);

    $dataArraylinechart = [["Scholarships", "Average GWA"]];
    if ($result->num_rows > 0) {
        foreach ($result as $row) {
            $dataArraylinechart[] = [$row['scholarship_name'], (float)$row['average_gwa']];
        }
    } else {
        $dataArraylinechart[] = ['No Data', 0];
    }
?>

<!-- php for bar graph (number of applicants per month) -->
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_scholarship_system";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT 
                MONTHNAME(application_date) AS month,
                COUNT(*) AS applicant_count
            FROM 
                tbl_application_scholarship
            WHERE 
                YEAR(application_date) = 2024
            GROUP BY 
                MONTH(application_date)
            ORDER BY 
                MONTH(application_date);";

    $result = $conn->query($sql);

    $chartData = [];
    if ($result->num_rows > 0) {
        foreach ($result as $row) {
            $chartData[] = "['" . $row['month'] . "', " . $row['applicant_count'] . "]";
        }
    } else {
        $chartData[] = "['No Data', 0]";
    }
?>

<!--php for column chart (degree courses)-->
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_scholarship_system";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT 
            C_Degree_Course,
            COUNT(*) AS total_count
        FROM 
            tbl_college_edu 
        WHERE 
            C_Degree_Course IS NOT NULL AND C_Degree_Course != ''
        GROUP BY 
            C_Degree_Course";

    $result = $conn->query($sql);

    // Generate your color palette
    $colors = [
    "#83C78E",
    "#39563C", 
    "#69B67A", 
    "CAF2D0", 
    "#5AA16E", 
    "#77C59B", 
    ];
    
    // Create the chart data array
    $Cchart = [["Degree Course", "Total Students", ["role" => "style"]]];
    if ($result->num_rows > 0) {
        $i = 0;
        foreach ($result as $row) {
            $color = $colors[$i % count($colors)];
            $Cchart[] = [$row['C_Degree_Course'], (int)$row['total_count'], $color];
            $i++;
        }
    } else {
        $Cchart[] = ['No Data', 0, '#CCCCCC'];
    }
?>
<script type="text/javascript">
    var chartData = <?php echo json_encode($chartData); ?>;
    console.log(chartData); // Check if data is correct
</script>

<!-- php for area chart (average income per year level) -->
 <?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_scholarship_system";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT 
            c.C_Year_Graduated AS Year_Level, 
            AVG(f.F_Income) AS Average_Father_Income,
            AVG(m.M_Income) AS Average_Mother_Income
        FROM 
            tbl_college_edu c
        JOIN 
            tbl_father_info f ON c.Student_No = f.Student_No
        JOIN 
            tbl_mother_info m ON c.Student_No = m.Student_No
        GROUP BY 
            c.C_Year_Graduated
    ";

    $result = $conn->query($sql);

    $dataArrayArea = [['Year Level', 'Average Father Income', 'Average Mother Income']];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dataArrayArea[] = [
                $row['Year_Level'], 
                (float)$row['Average_Father_Income'], 
                (float)$row['Average_Mother_Income']
            ];
        }
    } else {
        $dataArray[] = ['No Data', 0, 0];
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

    <!--area chart / average income of parents per year level -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo json_encode($dataArrayArea); ?>);

        var options = {
          title: 'STUDENT FAMILY INCOME',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          vAxis: {
                viewWindow: {
                    min: 0,
                    max: 2000
                },
                ticks: [0, 500, 1000, 1500, 2000]  // Optional: Specify custom tick values
            },
            series: {
                0: {type: 'area', color: '#CAF2D0'}, // Color for the first series
                1: {type: 'area', color: '#39563C'}  // Color for the second series
            }
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_area_div'));
        chart.draw(data, options);
      }
    </script>

    <!-- column chart / number of students per course -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawChart);
        
        function drawChart() {
            var data = google.visualization.arrayToDataTable(<?php echo json_encode($Cchart); ?>);
        
            var options = {
                title: 'CVSU Student Degree Courses',
                hAxis: {
                    title: 'Degree Course'
                },
                vAxis: {
                title: 'Number of Student per Course',
                viewWindow: {
                    min: 0,
                    max: 50
                },
                ticks: [0, 10, 20, 30, 40, 50]  // Optional: Specify custom tick values
            },
                bars: 'vertical', // Required for Material Bar Charts.
                colors: ['#83C78E'], // Set the color for the bars
                legend: { position: 'none' }
            };
        
            var chart = new google.visualization.ColumnChart(
                document.getElementById('chart_bar_div'));
            
            chart.draw(data, options);
        }
    </script>

    <!-- bar chart / number of applicants -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ["Month", "Applicants"],
                <?php echo implode(", ", $chartData); ?>
            ]);

            var options = {
                title: "Number of Applicants per Month",
                width: 400,
                height: 300,
                bars: 'horizontal', // Change to vertical if preferred
                legend: { position: "none" },
                colors: ['#83C78E'], // Set the color for all bars
                hAxis: {
                viewWindow: {
                    min: 0,
                    max: 300
                },
                ticks: [0, 50, 100, 150, 200, 250, 300]  // Optional: Specify custom tick values
            }
            };

            var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
            chart.draw(data, options);
        }

        // Example of a resizeChart function (make sure it’s defined if used)
        function resizeChart() {
            if (typeof chart !== 'undefined') {
                chart.draw(data, options); // Ensure 'data' and 'options' are defined globally or passed as parameters
            }
        }
    </script>

    <!-- combo chart / performance per program -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        var data = google.visualization.arrayToDataTable(<?php echo json_encode($dataArray); ?>);

        var options = {
            title: 'Scholarship Application Status Performance',
            vAxis: {
                title: 'Number of Applications',
                viewWindow: {
                    min: 0,
                    max: 20
                },
                ticks: [0, 5, 10, 15, 20]  // Optional: Specify custom tick values
            },
            hAxis: {title: 'Scholarship Program'},
            seriesType: 'bars',
            series: {
                0: {type: 'bars'}, // 'Approved'
                1: {type: 'bars'}, // 'Rejected'
                2: {type: 'bars'}, // 'Pending'
                3: {type: 'line'}
            },
            colors: ['#83C78E', '#39563C', '#CAF2D0', '#2196F3']
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>

    <!-- line chart / average gwa per program -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // Retrieve PHP data and parse it for the chart
            var data = google.visualization.arrayToDataTable(<?php echo json_encode($dataArraylinechart); ?>);

            var options = {
                title: 'Scholarship Performance Based on Average GWA',
                curveType: 'function',
                legend: {
                    position: 'bottom'
                },
                hAxis: {
                    title: 'Scholarships'
                },
                vAxis: {
                    title: 'Average GWA'
                },
                series: {
                    0: {
                        type: 'lines'
                    }
                },
                colors: ['#83C78E']
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, options);
        }
    </script>

    <!--pie chart / number of students per year level -->
    <style>
        /* Center the chart container */
        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
    
        #donutchart {
            width: 340px;
            height: 400px;
        }
    </style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);
    
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Year Level', 'Count'],
                <?php
                // Output the data from PHP into JavaScript
                foreach ($data as $d) {
                    echo "['" . $d[0] . "', " . $d[1] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Year Levels of Students',
                pieHole: 0.4,
                legend: {
                    position: 'bottom'
                },
                colors: <?php echo $jsonColors; ?> // Use the colors array from PHP
            };
        
            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        }
    </script>
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
                    <i class='bx bxs-user' ></i>
                    <span class="link_name">STUDENT</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">STUDENT</a></li>
                </ul>
            </li>
            <li>
                <a href="superadmin_coor.php">
                    <i class='bx bxs-user-detail' ></i>
                    <span class="link_name">COORDINATOR</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">COORDINATOR</a></li>
                </ul>
            </li>
            <li>
                <a href="superadmin_history.php">
                <i class='bx bx-history' ></i>
                    <span class="link_name">LOGIN HISTORY</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">LOGIN HISTORY</a></li>
                </ul>
            </li>
            <li>
                <a href="superadmin_setting.php">
                    <i class='bx bxs-cog' ></i>
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
                <a href="#" id="logout-link">
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
                <span class=" ms-4 fw-bold">REPORT SUMMARY</span>
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
        <div class="dash-container">
            <div class="row">
                <div class="col-lg-3 dash-col">
                    <div class="dash-count" >
                        <i class='bx bxs-group dash-icon'></i>
                        <span>
                            <p style="margin: 0;">COORDINATOR</p>
                            <p style="font-size: 30px; margin: 0;">
                                <!-- dito php -->
                                 <?php
                                // SQL query to count rows
                                 $sql = "SELECT COUNT(*) as count FROM tbl_admin_account";
                                $result = $conn->query($sql);

                                // Fetch the result
                                $row_count = 0;
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $row_count = $row['count'];
                                    echo $row_count;
                                } else {
                                    echo "0";
                                }
                                ?>
                            </p>
                        </span>
                    </div>
                </div>
                <div class="col-lg-3 dash-col">
                    <div class="dash-count" style="background-color: #57a47a;">
                        <i class='bx bxs-user dash-icon'></i>
                        <span>
                            <p style="margin: 0;">STUDENT</p>
                            <p style="font-size: 30px; margin: 0;">
                                <!-- dito php -->
                                 <?php
                                // SQL query to count rows
                                $sql = "SELECT COUNT(*) as count FROM tbl_student_acc";
                                $result = $conn->query($sql);

                                // Fetch the result
                                $row_count = 0;
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $row_count = $row['count'];
                                    echo $row_count;
                                } else {
                                    echo "0";
                                }
                                ?>
                            </p>
                        </span>
                    </div>
                </div>
                <div class="col-lg-3 dash-col">
                    <div class="dash-count">
                        <i class='bx bxs-graduation dash-icon'></i>
                         <span>
                            <p style="margin: 0;">SCHOLARSHIP</p>
                            <p style="font-size: 30px; margin: 0;">
                                <!-- dito php -->
                                <?php
                                // SQL query to count rows
                                $sql = "SELECT COUNT(*) as count FROM tbl_scholarship";
                                $result = $conn->query($sql);

                                // Fetch the result
                                $row_count = 0;
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $row_count = $row['count'];
                                    echo $row_count;
                                } else {
                                    echo "0";
                                }
                                ?>
                            </p>
                        </span>
                    </div>
                </div>
                <div class="col-lg-3 dash-col">
                    <div class="dash-count" style="background-color: #57a47a;">
                        <i class='bx bx-bell dash-icon'></i>
                         <span>
                            <p style="margin: 0;">ANNOUNCEMENT</p>
                            <p style="font-size: 30px; margin: 0;">
                                <!-- dito php -->
                                <?php
                                // SQL query to count rows
                                $sql = "SELECT COUNT(*) as count FROM tbl_announcement";
                                $result = $conn->query($sql);

                                // Fetch the result
                                $row_count = 0;
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $row_count = $row['count'];
                                    echo $row_count;
                                } else {
                                    echo "0";
                                }
                                ?>
                            </p>
                        </span>
                    </div>
                </div>
            </div>

            <!-- chart -->
            <div class="row my-5">
                <div class="col-lg-12">
                    <div class="border rounded-3 shadow-sm chart-container" style="height: 20rem;">
                        <div id="chart_div" style="width: 90%; height: 300px;"></div>
                    </div>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-lg-4">
                    <div class="border rounded-3 shadow-sm chart-container" style="height: 20rem;">
                        <div id="donutchart"></div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="border rounded-3 shadow-sm chart-container" style="height: 20rem;">
                        <div id="chart_bar_div" style="width: 90%; height: 300px;"></div>
                    </div>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-lg-7">
                    <div class="border rounded-3 shadow-sm chart-container" style="height: 20rem;">
                        <div id="curve_chart" style="width: 90%; height: 300px"></div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="border rounded-3 shadow-sm chart-container" style="height: 20rem;">
                        <div id="barchart_values" style="width: 80%; height: 400px;"></div>
                    </div>
                </div>
            </div>
            <div class="row my-5">
                
                <div class="col-lg-12">
                    <div class="border rounded-3 shadow-sm chart-container" style="height: 20rem;">
                        <div id="chart_area_div" style="width: 100%; height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>


    </section>



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
                    // If the user clicks "Yes", navigate to the logout page
                    window.location.href = event.target.href="../homepage/login_page.php";
                }
            });
        });

    </script>
    
</body>

</html>