<?php

include 'FormSanitization.php';

session_start();

$conn = mysqli_connect("localhost", "root", "", "db_scholarship_system");

// Check if the session variable is set
if (!isset($_SESSION['Student_No'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ../homepage/login_page.php");
    exit();
}else{
    $student_no = $_SESSION['Student_No'];
}
// Fetch data from database
$sql = "SELECT * FROM tbl_student_acc WHERE Student_No = $student_no";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $student_No = $row['Student_No'];
        $Email_Address = $row['Email_Address'];
        $Password = $row['Password'];
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Personal Information</title>

    <!--bootstrap-->
    <link href="bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap.bundle.min.js"></script>
    <script src="bootstrap.min.js"></script>

    <!--icons-->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!--css-->
    <link rel="stylesheet" href="std_info.css">
    <!--icon website-->
    <link rel="icon" type="image/x-icon" href="logo.png">

    <!--sweetalert2-->
    <script src="sweetalert2.all.min.js"></script>
    <link href="sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    .read-only {
        background-color: #346473;
        /* Change this to the color you want */
        color: white;
        /* Change the text color */
    }
</style>

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
                <a href="std_dash-view.php">
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
                <a href="#">
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
                <span class=" ms-4 fw-bold">PERSONAL INFORMATION</span>
                <div class="d-flex ms-auto">
                    <a href="#" class="nav-link d-flex align-items-center">
                        <span class="me-2 fw-normal">STUDENT</span>
                        <i class='bx bxs-user-circle custom-icon'></i>
                    </a>
                </div>
            </div>
        </nav>

        <hr>

        <!--main form-->
        <form action="std_info.php" class="form-style">
            <div class="row">
                <div class="col-lg-9">
                    <span style="font-size: 18px; font-weight: bold;">ACCOUNT INFORMATION</span>
                </div>
                <div class="col-lg-3" align="right">
                    <span class="form-label">Student No. <?php echo $student_No; ?></span>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label class="form-lbl">Email Address:</label><br>
                    <input class="form-ipt" value="<?= htmlspecialchars($Email_Address); ?>" placeholder="Email Address" readonly>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label class="form-lbl">Password:</label><br>
                    <input type="password" class="form-ipt" value="**********" placeholder="Password" readonly>
                    </div>
                <div class="col-lg-4" align="right">
                    <br><br>
                    <div>
                        <button type="button" class="form-btn" id="update_modal">Update</button>
                    </div>
                </div>
            </div>
        </form>
        <?php
        $conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

        if (isset($_POST['save-form']) && isset($_POST['check'])) {
            ////////////////////////personal info
            $lastName = sanitize_input($_POST['lastName']);
            $firstName = sanitize_input($_POST['firstName']);
            $middleName = sanitize_input($_POST['middleName']);
            $civilStatus = $_POST['civilStatus'];
            $birthDate = $_POST['birthDate'];
            $birthPlace = sanitize_input($_POST['birthPlace']);
            $gender = $_POST['gender'];
            $nationality = sanitize_input($_POST['nationality']);
            $religion = $_POST['religion'];
            $phoneNo = sanitize_input($_POST['phoneNo']);
            $age = $_POST['age'];
            $email = sanitize_input($_POST['email']);

            $sql_tbl_personal = "UPDATE tbl_personal_info SET Last_Name = '$lastName', First_Name = '$firstName', Middle_Name = '$middleName', Date_of_Birth = '$birthDate', 
                                        Place_Of_Birth = '$birthPlace', Gender = '$gender', Nationality = '$nationality', Civil_Status =  '$civilStatus', Religion = '$religion', Phone_No = '$phoneNo', 
                                        Age = '$age', Email = '$email' WHERE Student_No = $student_No";

            $result = mysqli_query($conn, $sql_tbl_personal);

            ////////////////////////address
            $region = $_POST['region'];
            $province = $_POST['province'];
            $municipality = $_POST['municipality'];
            $barangay = $_POST['barangay'];
            $hnsb = sanitize_input($_POST['hnsb']);

            $sql_tbl_address = "UPDATE tbl_address SET Region = '$region', Province = '$province', Municipality = '$municipality', Barangay = '$barangay', House_No_Street_Barangay = '$hnsb' WHERE Student_No = $student_No";

            $result = mysqli_query($conn, $sql_tbl_address);

            ////////////////////////mother info
            $mLastName = sanitize_input($_POST['mLastName']);
            $mFirstName = sanitize_input($_POST['mFirstName']);
            $mMiddleI = sanitize_input($_POST['mMiddleI']);
            $mOccupation = sanitize_input($_POST['mOccupation']);
            $mConNo = sanitize_input($_POST['mConNo']);
            $mCitizen = sanitize_input($_POST['mCitizen']);
            $mReligion = $_POST['mReligion'];
            $mIncome = sanitize_input($_POST['mIncome']);

            $sql_tbl_mother_info = "UPDATE tbl_mother_info SET M_Last_Name = '$mLastName', M_First_Name = '$mFirstName', M_MI = '$mMiddleI', M_Occupation = '$mOccupation', 
                                            M_Contact_No = '$mConNo', M_Citizenship = '$mCitizen', M_Religion = '$mReligion', M_Income = '$mIncome' WHERE Student_No = $student_No";

            $result = mysqli_query($conn, $sql_tbl_mother_info);

            ////////////////////////father info
            $fLastName = sanitize_input($_POST['fLastName']);
            $fFirstName = sanitize_input($_POST['fFirstName']);
            $fMiddleI = sanitize_input($_POST['fMiddleI']);
            $fOccupation = sanitize_input($_POST['fOccupation']);
            $fConNo = sanitize_input($_POST['fConNo']);
            $fCitizen = sanitize_input($_POST['fCitizen']);
            $fReligion = $_POST['fReligion'];
            $fIncome = sanitize_input($_POST['fIncome']);

            $sql_tbl_father_info = "UPDATE tbl_father_info SET F_Last_Name = '$fLastName', F_First_Name = '$fFirstName', F_MI = '$fMiddleI', F_Occupation = '$fOccupation', 
                                            F_Contact_No = '$fConNo', F_Citizenship = '$fCitizen', F_Religion = '$fReligion', F_Income = '$fIncome' WHERE Student_No = $student_No";

            $result = mysqli_query($conn, $sql_tbl_father_info);

            //////////////////////educational background
            $elementary = sanitize_input($_POST['elementary']);
            $jrHigh = sanitize_input($_POST['jrHigh']);
            $srHigh = sanitize_input($_POST['srHigh']);
            $college = sanitize_input($_POST['college']);
            $elemYrGrad = sanitize_input($_POST['elemYrGrad']);
            $jrYrGrad = sanitize_input($_POST['jrYrGrad']);
            $srYrGrad = sanitize_input($_POST['srYrGrad']);
            $clgYrGrad = sanitize_input($_POST['clgYrGrad']);
            $degreeCourse = $_POST['degreeCourse'];
            $unit = sanitize_input($_POST['unit']);
            $gpa = sanitize_input($_POST['gpa']);

            $sql_tbl_elementary = "UPDATE tbl_elem_edu_bg SET Elem_Name_of_school = '$elementary', Elem_Year_graduated = '$elemYrGrad' WHERE Student_No = $student_No";
            $result = mysqli_query($conn, $sql_tbl_elementary);

            $sql_tbl_jh = "UPDATE tbl_jh_edu_bg SET JH_Name_of_school = '$jrHigh', JH_Year_graduated = '$jrYrGrad' WHERE Student_No = $student_No";
            $result = mysqli_query($conn, $sql_tbl_jh);

            $sql_tbl_sh = "UPDATE tbl_sh_edu_bg SET SH_Name_of_school = '$srHigh', SH_Year_graduated = '$srYrGrad' WHERE Student_No = $student_No";
            $result = mysqli_query($conn, $sql_tbl_sh);

            $sql_tbl_college = "UPDATE tbl_college_edu SET C_Name_of_school = '$college', C_Year_graduated = '$clgYrGrad', C_Degree_Course = '$degreeCourse', 
                                        C_Degree_Unit = '$unit', C_GPA = '$gpa' WHERE Student_No = $student_No";

            $result = mysqli_query($conn, $sql_tbl_college);

            //pop upp
            echo "<script>Swal.fire({
                    title: 'SAVED',
                    text: 'Successfully Completed!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2000
                    });</script>";
        } else {
            //PERSONAL INFO
            $sql_personal = "SELECT * FROM tbl_personal_info WHERE Student_No = $student_No";
            $result_per = $conn->query($sql_personal);
            if ($result_per->num_rows > 0) {
                while ($row = $result_per->fetch_assoc()) {
                    $lastName = $row['Last_Name'];
                    $firstName = $row['First_Name'];
                    $middleName = $row['Middle_Name'];
                    $civilStatus = $row['Civil_Status'];
                    $birthDate = $row['Date_of_Birth'];
                    $birthPlace = $row['Place_Of_Birth'];
                    $gender = $row['Gender'];
                    $nationality = $row['Nationality'];
                    $religion = $row['Religion'];
                    $phoneNo = $row['Phone_No'];
                    $age = $row['Age'];
                    $email = $row['Email'];
                }
            }

            //ADDRESS
            $sql_address = "SELECT * FROM tbl_address WHERE Student_No = $student_No";
            $result_address = $conn->query($sql_address);
            if ($result_address->num_rows > 0) {
                while ($row = $result_address->fetch_assoc()) {
                    $region = $row['Region'];
                    $province = $row['Province'];
                    $municipality = $row['Municipality'];
                    $barangay = $row['Barangay'];
                    $hnsb = $row['House_No_Street_Barangay'];
                }
            }

            //MOTHER INFO
            $sql_m_info = "SELECT * FROM tbl_mother_info WHERE Student_No = $student_No";
            $result_m_info = $conn->query($sql_m_info);
            if ($result_m_info->num_rows > 0) {
                while ($row = $result_m_info->fetch_assoc()) {
                    $mLastName = $row['M_Last_Name'];
                    $mFirstName = $row['M_First_Name'];
                    $mMiddleI = $row['M_MI'];
                    $mOccupation = $row['M_Occupation'];
                    $mConNo = $row['M_Contact_No'];
                    $mCitizen = $row['M_Citizenship'];
                    $mReligion = $row['M_Religion'];
                    $mIncome = $row['M_Income'];
                }
            }

            //FATHER INFO
            $sql_f_info = "SELECT * FROM tbl_father_info WHERE Student_No = $student_No";
            $result_f_info = $conn->query($sql_f_info);
            if ($result_f_info->num_rows > 0) {
                while ($row = $result_f_info->fetch_assoc()) {
                    $fLastName = $row['F_Last_Name'];
                    $fFirstName = $row['F_First_Name'];
                    $fMiddleI = $row['F_MI'];
                    $fOccupation = $row['F_Occupation'];
                    $fConNo = $row['F_Contact_No'];
                    $fCitizen = $row['F_Citizenship'];
                    $fReligion = $row['F_Religion'];
                    $fIncome = $row['F_Income'];
                }
            }

            //ELEMENTARY BACKGROUND
            $sql_elementary = "SELECT * FROM tbl_elem_edu_bg WHERE Student_No = $student_No";
            $result_elem = $conn->query($sql_elementary);
            if ($result_elem->num_rows > 0) {
                while ($row = $result_elem->fetch_assoc()) {
                    $elementary = $row['Elem_Name_of_school'];
                    $elemYrGrad = $row['Elem_Year_graduated'];
                }
            }

            //JUNIOR HIGHSCHOOL BACKGROUND
            $sql_jh = "SELECT * FROM tbl_jh_edu_bg WHERE Student_No = $student_No";
            $result_jh = $conn->query($sql_jh);
            if ($result_jh->num_rows > 0) {
                while ($row = $result_jh->fetch_assoc()) {
                    $jrHigh = $row['JH_Name_of_school'];
                    $jrYrGrad = $row['JH_Year_graduated'];
                }
            }

            //SENIOR HIGHSCHOOL BACKGROUND
            $sql_sh = "SELECT * FROM tbl_sh_edu_bg WHERE Student_No = $student_No";
            $result_sh = $conn->query($sql_sh);
            if ($result_sh->num_rows > 0) {
                while ($row = $result_sh->fetch_assoc()) {
                    $srHigh = $row['SH_Name_of_school'];
                    $srYrGrad = $row['SH_Year_graduated'];
                }
            }

            //COLLEGE BACKGROUND
            $sql_college = "SELECT * FROM tbl_college_edu WHERE Student_No = $student_No";
            $result_college = $conn->query($sql_college);
            if ($result_college->num_rows > 0) {
                while ($row = $result_college->fetch_assoc()) {
                    $college = $row['C_Name_of_school'];
                    $clgYrGrad = $row['C_Year_graduated'];
                    $degreeCourse = $row['C_Degree_Course'];
                    $unit = $row['C_Degree_Unit'];
                    $gpa = $row['C_GPA'];
                }
            }
        }
        ?>

        <form action="" method="POST" class="form-style" id="pi-form">
            <div class="row">
                <span class="form-span">PERSONAL INFORMATION</span>
                <hr>
                <?php

                $sql_personal = "SELECT * FROM tbl_student_acc WHERE Student_No = $student_No";
                $result_per = $conn->query($sql_personal);

                $row = $result_per->fetch_assoc()


                ?>
                <div class="col-lg-3 col-md-6 form-col">
                    <label class="form-lbl">Last Name</label><br>
                    <input type="text" class="form-ipt" value="<?= htmlspecialchars($row['Last_name']) ?>" placeholder="Enter Last Name" name="lastName" id="lastName" oninput="validateInput(event)" readonly>
                </div>
                <div class="col-lg-3 col-md-6 form-col">
                    <label class="form-lbl">First Name</label><br>
                    <input type="text" class="form-ipt" value="<?= htmlspecialchars($row['First_name']) ?>" placeholder="Enter First Name" name="firstName" id="firstName" oninput="validateInput(event)" readonly>
                </div>
                <div class="col-lg-3 col-md-6 form-col">
                    <label class="form-lbl">Middle Name</label><br>
                    <input type="text" class="form-ipt" value="<?= htmlspecialchars($middleName); ?>" placeholder="Enter Middle Name" name="middleName" id="middleName" oninput="validateInput(event)">
                </div>
                <div class="col-lg-3 col-md-6 form-col">
                    <label class="form-lbl">Civil Status</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <select name="civilStatus" id="civilStatus" class="form-ipt" value="<?= htmlspecialchars($civilStatus); ?>" required>
                        <option value="" disable <?= empty($civilStatus) ? 'selected' : '' ?>>Select Civil Status</option>
                        <option value="Single" <?= $civilStatus == 'Single' ? 'selected' : '' ?>>Single</option>
                        <option value="Married" <?= $civilStatus == 'Married' ? 'selected' : '' ?>>Married</option>
                        <option value="Divorced/Widowed" <?= $civilStatus == 'Divorced/Widowed' ? 'selected' : '' ?>>Divorced/Widowed</option>
                    </select>
                </div>
                <div class="col-lg-1 col-md-6 form-col">
                    <label for="" class="form-lbl">Sex</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <input type="radio" id="male" name="gender" value="male" <?php if ($gender == 'male') echo 'checked'; ?> required>
                    <label for="male" style="font-size: 12px;">Male</label><br>
                    <input type="radio" id="female" name="gender" value="female" <?php if ($gender == 'female') echo 'checked'; ?> required>
                    <label for="female" style="font-size: 12px;">Female</label>
                </div>


                <div class="col-lg-2 col-md-6 form-col">
                    <label class="form-lbl">Date of Birth</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <input type="date" class="form-ipt" value="<?= htmlspecialchars($birthDate); ?>" placeholder="Birthdate" name="birthDate" id="birthDate" required oninput="calculateAge()">

                    <script>
        
                    function calculateAge() {
                        const birthYearInput = document.getElementById('birthDate').value;
                        const currentYear = new Date().getFullYear();
                        const ageInput = document.getElementById('age');
                        const message = document.getElementById('message');

                        // Check if the input is valid
                        if (birthYearInput) {
                            const birthYear = new Date(birthYearInput).getFullYear();
                            
                            // Calculate age
                            if (birthYear > 0 && birthYear <= currentYear) {
                                const age = currentYear - birthYear;
                                ageInput.value = age;
                                message.innerHTML = '';
                                if (age < 17) {
                                    ageInput.value = '';
                                    message.innerHTML = 'Age must be 17 or older';
                                }
                            } else {
                                ageInput.value = '';
                            }
                        } else {
                            ageInput.value = '';
                        }
                    }

                    document.getElementById('pi-form').onsubmit = function(event) {
                        const age = document.getElementById('age').value;
                        if (age < 17) {
                            event.preventDefault(); // Prevent form submission
                            document.getElementById('message').innerHTML = 'Age must be 17 or older';
                        }
                    };

                    </script>
                
                </div>
                <div class="col-lg-3 col-md-6 form-col">
                    <label class="form-lbl">Place of Birth</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <input type="text" class="form-ipt" value="<?= htmlspecialchars($birthPlace); ?>" placeholder="Enter Place of Birth" name="birthPlace" id="birthPlace" required oninput="validateInput(event)">
                </div>
                <div class="col-lg-3 col-md-6 form-col">
                    <label class="form-lbl">Nationality</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <input type="text" class="form-ipt" value="<?= htmlspecialchars($nationality); ?>" placeholder="Enter Nationality" name="nationality" id="nationality" required oninput="validateInput(event)">
                </div>
                <div class="col-lg-3 col-md-6 form-col">
                    <label class="form-lbl">Religion</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <select name="religion" id="religion" class="form-ipt" value="<?= htmlspecialchars($religion); ?>" required>
                        <option value="" disable <?= empty($religion) ? 'selected' : '' ?>>Select Religion</option>
                        <option value="Muslim" <?= $religion == 'Muslim' ? 'selected' : '' ?>>Muslim</option>
                        <option value="Roman Catholic" <?= $religion == 'Roman Catholic' ? 'selected' : '' ?>>Roman Catholic</option>
                        <option value="Christian" <?= $religion == 'Christian' ? 'selected' : '' ?>>Christian</option>
                        <option value="IglesiaNiCristo" <?= $religion == 'IglesiaNiCristo' ? 'selected' : '' ?>>Iglesia Ni Cristo</option>
                        <option value="Protestant" <?= $religion == 'Protestant' ? 'selected' : '' ?>>Protestant</option>
                        <option value="Buddhism" <?= $religion == 'Buddhism' ? 'selected' : '' ?>>Buddhism</option>
                        <option value="None" <?= $religion == 'None' ? 'selected' : '' ?>>None</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6 form-col">
                    <label class="form-lbl">Phone</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <span class="form-num input-group-text" style="width: 18%; float: left; margin-right: 7px;" id="addon-wrapping">+63</span>
                    <input type="text" class="form-num form-control" value="<?= htmlspecialchars($phoneNo); ?>" placeholder="Enter Phone" oninput="validateNumberInput(event)" maxlength="10" name="phoneNo" id="phoneNo" required>
                    <script>
                        const phoneInput = document.getElementById('phoneNo');
                        phoneInput.addEventListener('input', () => {
                            const charCount = phoneInput.value.length;
                            const charValue = phoneInput.value;
                            if (charCount >= 10 && charValue >= 9000000000) {
                                phoneInput.value = phoneInput.value.substring(0, 10);
                                phoneInput.setCustomValidity('');
                            } else if (charCount != 10) {
                                phoneInput.setCustomValidity(`Must be a valid 10 digits (9XX-XXX-XXXX)`);
                            }
                        });
                    </script>
                </div>
                <div class="col-lg-3 col-md-6 form-col">
                    <label class="form-lbl">Age</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <input type="text" class="form-ipt" value="<?= htmlspecialchars($age); ?>" placeholder="Enter Age" name="age" id="age" min="17" readonly required>
                    <p id="message" style="color: red;"></p>
                </div>
                <div class="col-lg-4 col-md-6 form-col">
                    <label class="form-lbl">Email</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <input type="email" class="form-ipt" value="<?= htmlspecialchars($email); ?>" placeholder="Enter Email" name="email" id="email" required>
                </div>
            </div>
            <div class="row">
                <span class="form-span" style="margin-top: 20px;">ADDRESS</span>
                <div class="col-lg-3 col-md-6 form-col">
                    <label class="form-lbl">Region</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <!--<input type="text" class="form-ipt" value="" placeholder="Enter Region" name="region" id="region" required>-->
                    <select id="region" value="<?= htmlspecialchars($region); ?>" onchange="populateProvinces()" name="region" class="form-ipt" required>
                        <option value="" disable <?= empty($region) ? 'selected' : '' ?>>Select a region</option>
                        <option value="NCR" <?= $region == 'NCR' ? 'selected' : '' ?>>NCR</option>
                        <option value="CALABARZON" <?= $region == 'CALABARZON' ? 'selected' : '' ?>>CALABARZON</option>
                        <option value="ILOCOS REGION" <?= $region == 'ILOCOS REGION' ? 'selected' : '' ?>>ILOCOS REGION</option>
                        <option value="CAGAYAN VALLEY" <?= $region == 'CAGAYAN VALLEY' ? 'selected' : '' ?>>CAGAYAN VALLEY</option>
                        <option value="CENTRAL LUZON" <?= $region == 'CENTRAL LUZON' ? 'selected' : '' ?>>CENTRAL LUZON</option>
                        <option value="MIMAROPA" <?= $region == 'MIMAROPA' ? 'selected' : '' ?>>MIMAROPA</option>
                        <option value="BICOL REGION" <?= $region == 'BICOL REGION' ? 'selected' : '' ?>>BICOL REGION</option>
                        <option value="WESTERN VISAYAS" <?= $region == 'WESTERN VISAYAS' ? 'selected' : '' ?>>WESTERN VISAYAS</option>
                        <option value="CENTRAL VISAYAS" <?= $region == 'CENTRAL VISAYAS' ? 'selected' : '' ?>>CENTRAL VISAYAS</option>
                        <option value="EASTERN VISAYAS" <?= $region == 'EASTERN VISAYAS' ? 'selected' : '' ?>>EASTERN VISAYAS</option>
                        <option value="ZAMBOANGA PENINSULA" <?= $region == 'ZAMBOANGA PENINSULA' ? 'selected' : '' ?>>ZAMBOANGA PENINSULA</option>
                        <option value="NORTHERN MINDANAO" <?= $region == 'NORTHERN MINDANAO' ? 'selected' : '' ?>>NORTHERN MINDANAO</option>
                        <option value="DAVAO REGION" <?= $region == 'DAVAO REGION' ? 'selected' : '' ?>>DAVAO REGION</option>
                        <option value="SOCCSKARGEN" <?= $region == 'SOCCSKARGEN' ? 'selected' : '' ?>>SOCCSKARGEN</option>
                        <option value="CARAGA" <?= $region == 'CARAGA' ? 'selected' : '' ?>>CARAGA</option>
                        <option value="BARMM" <?= $region == 'BARMM' ? 'selected' : '' ?>>BARMM</option>
                        <option value="CAR" <?= $region == 'CAR' ? 'selected' : '' ?>>CAR</option>


                    </select>
                </div>
                <div class="col-lg-3 col-md-6 form-col">
                    <label class="form-lbl">Province</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <!--<input type="text" class="form-ipt" value="" placeholder="Enter Province" name="province" id="province" required>-->
                    <select id="province" value="<? htmlspecialchars($province); ?>" onchange="populateMunicipalities()" name="province" class="form-ipt" placeholder="Select Province" required>
                        <option value="" disable <?= empty($province) ? 'selected' : '' ?>>Select Province</option>
                        <!-- NCR -->
                        <option value="Manila" hidden <?= $province == 'Manila' ? 'selected' : '' ?>>Manila</option>
                        <option value="Quezon City" hidden <?= $province == 'Quezon City' ? 'selected' : '' ?>>Quezon City</option>
                        <option value="Makati" hidden <?= $province == 'Makati' ? 'selected' : '' ?>>Makati</option>
                        <option value="Taguig" hidden <?= $province == 'Taguig' ? 'selected' : '' ?>>Taguig</option>
                        <option value="Pasig" hidden <?= $province == 'Pasig' ? 'selected' : '' ?>>Pasig</option>
                        <option value="Marikina" hidden <?= $province == 'Marikina' ? 'selected' : '' ?>>Marikina</option>
                        <option value="Mandaluyong" hidden <?= $province == 'Mandaluyong' ? 'selected' : '' ?>>Mandaluyong</option>
                        <option value="San Juan" hidden <?= $province == 'San Juan' ? 'selected' : '' ?>>San Juan</option>
                        <option value="Caloocan" hidden <?= $province == 'Caloocan' ? 'selected' : '' ?>>Caloocan</option>
                        <option value="Valenzuela" hidden <?= $province == 'Valenzuela' ? 'selected' : '' ?>>Valenzuela</option>
                        <option value="Malabon" hidden <?= $province == 'Malabon' ? 'selected' : '' ?>>Malabon</option>
                        <option value="Navotas" hidden <?= $province == 'Navotas' ? 'selected' : '' ?>>Navotas</option>
                        <option value="Las Piñas" hidden <?= $province == 'Las Piñas' ? 'selected' : '' ?>>Las Piñas</option>
                        <option value="Muntinlupa" hidden <?= $province == 'Muntinlupa' ? 'selected' : '' ?>>Muntinlupa</option>
                        <option value="Pateros" hidden <?= $province == 'Pateros' ? 'selected' : '' ?>>Pateros</option>



                        <!-- CALABARZON -->
                        <option value="Cavite" hidden <?= $province == 'Cavite' ? 'selected' : '' ?>>Cavite</option>
                        <option value="Batangas" hidden <?= $province == 'Batangas' ? 'selected' : '' ?>>Batangas</option>
                        <option value="Laguna" hidden <?= $province == 'Laguna' ? 'selected' : '' ?>>Laguna</option>
                        <option value="Rizal" hidden <?= $province == 'Rizal' ? 'selected' : '' ?>>Rizal</option>
                        <option value="Quezon" hidden <?= $province == 'Quezon' ? 'selected' : '' ?>>Quezon</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6 form-col">
                    <label class="form-lbl">Municipality</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <!--<input type="text" class="form-ipt" value="" placeholder="Enter Municipality" name="municipality" id="municipality" required>-->
                    <select id="municipality" value="<?= htmlspecialchars($municipality); ?>" onchange="populateBarangay()" name="municipality" class="form-ipt" placeholder="Select Municipality" required>
                        <option value="" disable <?= empty($municipality) ? 'selected' : '' ?>>Select Municipality</option>
                        <!-- MANILA -->
                        <option value="Manila" hidden <?= $municipality == 'Manila' ? 'selected' : '' ?>>Manila</option>
                        <!-- QUEZON CITY -->
                        <option value="Quezon City" hidden <?= $municipality == 'Quezon City' ? 'selected' : '' ?>>Quezon City</option>
                        <!-- MAKATI -->
                        <option value="Makati" hidden <?= $municipality == 'Makati' ? 'selected' : '' ?>>Makati</option>
                        <option value="Taguig" hidden <?= $municipality == 'Taguig' ? 'selected' : '' ?>>Taguig</option>
                        <!-- CAVITE -->
                        <option value="Alfonso" hidden <?= $municipality == 'Alfonso' ? 'selected' : '' ?>>Alfonso</option>
                        <option value="Bacoor" hidden <?= $municipality == 'Bacoor' ? 'selected' : '' ?>>Bacoor</option>
                        <option value="Carmona" hidden <?= $municipality == 'Carmona' ? 'selected' : '' ?>>Carmona</option>
                        <option value="Dasmariñas" hidden <?= $municipality == 'Dasmariñas' ? 'selected' : '' ?>>Dasmariñas</option>
                        <option value="General Trias" hidden <?= $municipality == 'General Trias' ? 'selected' : '' ?>>General Trias</option>
                        <option value="Imus" hidden <?= $municipality == 'Imus' ? 'selected' : '' ?>>Imus</option>
                        <option value="Kawit" hidden <?= $municipality == 'Kawit' ? 'selected' : '' ?>>Kawit</option>
                        <option value="Maragondon" hidden <?= $municipality == 'Maragondon' ? 'selected' : '' ?>>Maragondon</option>
                        <option value="Naic" hidden <?= $municipality == 'Naic' ? 'selected' : '' ?>>Naic</option>
                        <option value="Noveleta" hidden <?= $municipality == 'Noveleta' ? 'selected' : '' ?>>Noveleta</option>
                        <option value="Rosario" hidden <?= $municipality == 'Rosario' ? 'selected' : '' ?>>Rosario</option>
                        <option value="Silang" hidden <?= $municipality == 'Silang' ? 'selected' : '' ?>>Silang</option>
                        <option value="Tagaytay" hidden <?= $municipality == 'Tagaytay' ? 'selected' : '' ?>>Tagaytay</option>
                        <option value="Tanza" hidden <?= $municipality == 'Tanza' ? 'selected' : '' ?>>Tanza</option>
                        <option value="Ternate" hidden <?= $municipality == 'Ternate' ? 'selected' : '' ?>>Ternate</option>
                        <option value="Trece Martires" hidden <?= $municipality == 'Trece Martires' ? 'selected' : '' ?>>Trece Martires</option>
                        <!-- LAGUNA -->
                        <option value="Alaminos" hidden <?= $municipality == 'Alaminos' ? 'selected' : '' ?>>Alaminos</option>
                        <option value="Bay" hidden <?= $municipality == 'Bay' ? 'selected' : '' ?>>Bay</option>
                        <option value="Biñan" hidden <?= $municipality == 'Biñan' ? 'selected' : '' ?>>Biñan</option>
                        <option value="Cabuyao" hidden <?= $municipality == 'Cabuyao' ? 'selected' : '' ?>>Cabuyao</option>
                        <option value="Calamba" hidden <?= $municipality == 'Calamba' ? 'selected' : '' ?>>Calamba</option>
                        <option value="Calauan" hidden <?= $municipality == 'Calauan' ? 'selected' : '' ?>>Calauan</option>
                        <option value="Cavinti" hidden <?= $municipality == 'Cavinti' ? 'selected' : '' ?>>Cavinti</option>
                        <option value="Kalayaan" hidden <?= $municipality == 'Kalayaan' ? 'selected' : '' ?>>Kalayaan</option>
                        <option value="Liliw" hidden <?= $municipality == 'Liliw' ? 'selected' : '' ?>>Liliw</option>
                        <option value="Los Baños" hidden <?= $municipality == 'Los Baños' ? 'selected' : '' ?>>Los Baños</option>
                        <option value="Rizal" hidden <?= $municipality == 'Rizal' ? 'selected' : '' ?>>Rizal</option>
                        <option value="San Pablo" hidden <?= $municipality == 'San Pablo' ? 'selected' : '' ?>>San Pablo</option>
                        <option value="San Pedro" hidden <?= $municipality == 'San Pedro' ? 'selected' : '' ?>>San Pedro</option>
                        <option value="Santa Cruz" hidden <?= $municipality == 'Santa Cruz' ? 'selected' : '' ?>>Santa Cruz</option>
                        <option value="Santa Maria" hidden <?= $municipality == 'Santa Maria' ? 'selected' : '' ?>>Santa Maria</option>
                        <option value="Santa Cruz" hidden <?= $municipality == 'Santa Cruz' ? 'selected' : '' ?>>Santa Cruz</option>
                        <!-- BATANGAS -->
                        <option value="Agoncilo" hidden <?= $municipality == 'Agoncilo' ? 'selected' : '' ?>>Agoncilo</option>
                        <option value="Balayan" hidden <?= $municipality == 'Balayan' ? 'selected' : '' ?>>Balayan</option>
                        <option value="Batangas City" hidden <?= $municipality == 'Batangas City' ? 'selected' : '' ?>>Batangas City</option>
                        <option value="Bauan" hidden <?= $municipality == 'Bauan' ? 'selected' : '' ?>>Bauan</option>
                        <option value="Calaca" hidden <?= $municipality == 'Calaca' ? 'selected' : '' ?>>Calaca</option>
                        <option value="Calatagan" hidden <?= $municipality == 'Calatagan' ? 'selected' : '' ?>>Calatagan</option>
                        <option value="Lemery" hidden <?= $municipality == 'Lemery' ? 'Lemery' : '' ?>>Alaminos</option>
                        <option value="Lipa" hidden <?= $municipality == 'Lipa' ? 'selected' : '' ?>>Lipa</option>
                        <option value="Nasugbu" hidden <?= $municipality == 'Nasugbu' ? 'selected' : '' ?>>Nasugbu</option>
                        <option value="Rosario" hidden <?= $municipality == 'Rosario' ? 'selected' : '' ?>>Rosario</option>
                        <option value="San Jose" hidden <?= $municipality == 'San Jose' ? 'selected' : '' ?>>San Jose</option>
                        <option value="San Juan" hidden <?= $municipality == 'San Juan' ? 'selected' : '' ?>>San Juan</option>
                        <option value="Santo Tomas" hidden <?= $municipality == 'Santo Tomas' ? 'selected' : '' ?>>Santo Tomas</option>
                        <option value="Tanauan" hidden <?= $municipality == 'Tanauan' ? 'selected' : '' ?>>Tanauan</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6 form-col">
                    <label class="form-lbl">Barangay</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <select name="barangay" value="" id="barangay" class="form-ipt" placeholder="Select Barangay" required>
                        <option value="" disable <?= empty($barangay) ? 'selected' : '' ?>>Select Barangay</option>
                        <!-- IMUS -->
                        <option value="Anabu" hidden <?= $barangay == 'Anabu' ? 'selected' : '' ?>>Anabu</option>
                        <option value="Bucandala" hidden <?= $barangay == 'Bucandala' ? 'selected' : '' ?>>Bucandala</option>
                        <option value="Carsadang Bago" hidden <?= $barangay == 'Carsadang Bago' ? 'selected' : '' ?>>Carsadang Bago</option>
                        <option value="Malagasang" hidden <?= $barangay == 'Malagasang' ? 'selected' : '' ?>>Malagasang</option>
                        <option value="Medicion" hidden <?= $barangay == 'Medicion' ? 'selected' : '' ?>>Medicion</option>
                        <!-- BACOOR -->
                        <option value="Zapote" hidden <?= $barangay == 'Zapote' ? 'selected' : '' ?>>Zapote</option>
                        <option value="Talaba" hidden <?= $barangay == 'Talaba' ? 'selected' : '' ?>>Talaba</option>
                        <option value="Niog" hidden <?= $barangay == 'Niog' ? 'selected' : '' ?>>Niog</option>
                        <option value="Panapaan" hidden <?= $barangay == 'Panapaan' ? 'selected' : '' ?>>Panapaan</option>
                        <!-- KAWIT -->
                        <option value="Balsahan-Bisita" hidden <?= $barangay == 'Balsahan-Bisita' ? 'selected' : '' ?>>Balsahan-Bisita</option>
                        <option value="Binakayan-Aplaya" hidden <?= $barangay == 'Binakayan-Aplaya' ? 'selected' : '' ?>>Binakayan-Aplaya</option>
                        <option value="Binakayan-Kanluran" hidden <?= $barangay == 'Binakayan-Kanluran' ? 'selected' : '' ?>>Binakayan-Kanluran</option>
                        <option value="Gahak" hidden <?= $barangay == 'Gahak' ? 'selected' : '' ?>>Gahak</option>
                        <!-- DASMARINAS -->
                        <option value="Paliparan" hidden <?= $barangay == 'Paliparan' ? 'selected' : '' ?>>Paliparan</option>
                        <option value="Langkaan" hidden <?= $barangay == 'Langkaan' ? 'selected' : '' ?>>Langkaan</option>
                        <option value="Burol" hidden <?= $barangay == 'Burol' ? 'selected' : '' ?>>Burol</option>
                        <option value="Salitran" hidden <?= $barangay == 'Salitran' ? 'selected' : '' ?>>Salitran</option>
                    </select>
                </div>
                <div class="col-lg-6 form-col">
                    <label class="form-lbl">House Number and Street</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <input type="text" class="form-ipt" value="<?= htmlspecialchars($hnsb); ?>" placeholder="Enter House Number and Street" name="hnsb" id="hnsb" required>
                </div>
            </div>
            <div class="row form-row">
                <span class="form-span">FAMILY BACKGROUND</span>
                <span class="form-span">Mother's Name</span>
                <div class="col-lg-3 col-md-6 form-col">
                    <label class="form-lbl">Last Name</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <input type="text" class="form-ipt" value="<?= htmlspecialchars($mLastName); ?>" placeholder="Enter Last Name" name="mLastName" id="mLastName" required oninput="validateInput(event)">
                </div>
                <div class="col-lg-3 col-md-6 form-col">
                    <label class="form-lbl">First Name</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <input type="text" class="form-ipt" value="<?= htmlspecialchars($mFirstName); ?>" placeholder="Enter First Name" name="mFirstName" id="mFirstName" required oninput="validateInput(event)">
                </div>
                <div class="col-lg-2 col-md-6 form-col">
                    <label class="form-lbl">MI</label><br>
                    <input type="text" class="form-ipt" value="<?= htmlspecialchars($mMiddleI); ?>" placeholder="Enter Middle Initial" name="mMiddleI" id="mMiddleI" oninput="validateInput(event)">
                </div>
                <div class="col-lg-4 col-md-6 form-col">
                    <label class="form-lbl">Occupation</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <input type="text" class="form-ipt" value="<?= htmlspecialchars($mOccupation); ?>" placeholder="Enter Occupation" name="mOccupation" id="mOccupation" required oninput="validateInput(event)">
                </div>
                <div class="col-lg-3 col-md-6 form-col">
                    <label class="form-lbl">Contact No.</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <span class="form-num input-group-text" style="width: 17%; float: left; margin-right: 7px;" id="addon-wrapping">+63</span>
                    <input type="text" class="form-num form-control" value="<?= htmlspecialchars($mConNo); ?>" placeholder="Enter Contact Number" oninput="validateNumberInput(event)" maxlength="10" name="mConNo" id="mConNo" required>
                    <p id="error-message-m" style="color: red; font-size: 16px;"></p>
                    <script>
                        const phoneInput_m = document.getElementById('mConNo');
                        phoneInput_m.addEventListener('input', () => {
                            const charCount_m = phoneInput_m.value.length;
                            const charValue_m = phoneInput_m.value;
                            if (charCount_m >= 10 && charValue_m >= 9000000000) {
                                phoneInput_m.value = phoneInput_m.value.substring(0, 10);
                                phoneInput_m.setCustomValidity('');
                            } else if (charCount_m != 10) {
                                phoneInput_m.setCustomValidity(`Must be a valid 10 digits (9XX-XXX-XXXX)`);
                            }
                        });
                    </script>
                </div>
                <div class="col-lg-3 col-md-6 form-col">
                    <label class="form-lbl">Citizenship</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <input type="text" class="form-ipt" value="<?= htmlspecialchars($mCitizen); ?>" placeholder="Enter Citizenship" name="mCitizen" id="mCitizen" required oninput="validateInput(event)">
                </div>
                <div class="col-lg-3 form-col">
                    <label class="form-lbl">Religion</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <!--<input type="text" class="form-ipt" value="" placeholder="Enter Religion" name="mReligion" id="mReligion" required>-->
                    <select name="mReligion" id="mReligion" class="form-ipt" value="<?= htmlspecialchars($mReligion); ?>" required>
                        <option value="" disable <?= empty($mReligion) ? 'selected' : '' ?>>Select Religion</option>
                        <option value="Muslim" <?= $mReligion == 'Muslim' ? 'selected' : '' ?>>Muslim</option>
                        <option value="Roman Catholic" <?= $mReligion == 'Roman Catholic' ? 'selected' : '' ?>>Roman Catholic</option>
                        <option value="Christian" <?= $mReligion == 'Christian' ? 'selected' : '' ?>>Christian</option>
                        <option value="IglesiaNiCristo" <?= $mReligion == 'IglesiaNiCristo' ? 'selected' : '' ?>>Iglesia Ni Cristo</option>
                        <option value="Protestant" <?= $mReligion == 'Protestant' ? 'selected' : '' ?>>Protestant</option>
                        <option value="Buddhism" <?= $mReligion == 'buddhism' ? 'selected' : '' ?>>Buddhism</option>
                        <option value="None" <?= $mReligion == 'None' ? 'selected' : '' ?>>None</option>
                    </select>
                </div>
                <div class="col-lg-3 form-col">
                    <label class="form-lbl">Income</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <input type="number" class="form-ipt" value="<?= htmlspecialchars($mIncome); ?>" placeholder="Enter Income" name="mIncome" id="mIncome" step="0.01" required>
                </div>
            </div>
                <div class="row form-row">
                    <span class="form-span">Father's Name</span>
                    <div class="col-lg-3 col-md-6 form-col">
                        <label class="form-lbl">Last Name</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                        <input type="text" class="form-ipt" value="<?= htmlspecialchars($fLastName); ?>" placeholder="Enter Last Name" name="fLastName" id="fLastName" required oninput="validateInput(event)">
                    </div>
                    <div class="col-lg-3 col-md-6 form-col">
                        <label class="form-lbl">First Name</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                        <input type="text" class="form-ipt" value="<?= htmlspecialchars($fFirstName); ?>" placeholder="Enter First Name" name="fFirstName" id="fFirstName" required oninput="validateInput(event)">
                    </div>
                    <div class="col-lg-2 col-md-6 form-col">
                        <label class="form-lbl">MI</label><br>
                        <input type="text" class="form-ipt" value="<?= htmlspecialchars($fMiddleI); ?>" placeholder="Enter Middle Initial" name="fMiddleI" id="fMiddleI" oninput="validateInput(event)">
                    </div>
                    <div class="col-lg-4 col-md-6 form-col">
                        <label class="form-lbl">Occupation</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                        <input type="text" class="form-ipt" value="<?= htmlspecialchars($fOccupation); ?>" placeholder="Enter Occupation" name="fOccupation" id="fOccupation" required oninput="validateInput(event)">
                    </div>
                    <div class="col-lg-3 col-md-6 form-col">
                        <label class="form-lbl">Contact No.</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                        <span class="form-num input-group-text" style="width: 17%; float: left; margin-right: 7px;" id="addon-wrapping">+63</span>
                        <input type="number" class="form-num form-control" value="<?= htmlspecialchars($fConNo); ?>" placeholder="Enter Contact Number" oninput="validateNumberInput(event)" maxlength="10" name="fConNo" id="fConNo" required>
                        <p id="error-message-f" style="color: red; font-size: 16px;"></p>
                        <script>
                            const phoneInput_f = document.getElementById('fConNo');
                            phoneInput_f.addEventListener('input', () => {
                                const charCount_f = phoneInput_f.value.length;
                                const charValue_f = phoneInput_f.value;
                                if (charCount_f >= 10 && charValue_f >= 9000000000) {
                                    phoneInput_f.value = phoneInput_f.value.substring(0, 10);
                                    phoneInput_f.setCustomValidity('');
                                } else if (charCount_f != 10) {
                                    phoneInput_f.setCustomValidity(`Must be a valid 10 digits (9XX-XXX-XXXX)`);
                                }
                            });
                        </script>
                    </div>
                    <div class="col-lg-3 col-md-6 form-col">
                        <label class="form-lbl">Citizenship</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                        <input type="text" class="form-ipt" value="<?= htmlspecialchars($fCitizen); ?>" placeholder="Enter Citizenship" name="fCitizen" id="fCitizen" required oninput="validateInput(event)">
                    </div>
                    <div class="col-lg-3 form-col">
                        <label class="form-lbl">Religion</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                        <select name="fReligion" id="fReligion" class="form-ipt" value="<?= htmlspecialchars($fReligion); ?>" required>
                            <option value="" disable <?= empty($fReligion) ? 'selected' : '' ?>>Select Religion</option>
                            <option value="Muslim" <?= $fReligion == 'Muslim' ? 'selected' : '' ?>>Muslim</option>
                            <option value="RomanCatholic" <?= $fReligion == 'RomanCatholic' ? 'selected' : '' ?>>Roman Catholic</option>
                            <option value="Christian" <?= $fReligion == 'Christian' ? 'selected' : '' ?>>Christian</option>
                            <option value="IglesiaNiCristo" <?= $fReligion == 'IglesiaNiCristo' ? 'selected' : '' ?>>Iglesia Ni Cristo</option>
                            <option value="Protestant" <?= $fReligion == 'Protestant' ? 'selected' : '' ?>>Protestant</option>
                            <option value="Buddhism" <?= $fReligion == 'Buddhism' ? 'selected' : '' ?>>Buddhism</option>
                            <option value="None" <?= $fReligion == 'None' ? 'selected' : '' ?>>None</option>
                        </select>
                    </div>
                    <div class="col-lg-3 form-col">
                        <label class="form-lbl">Income</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                        <input type="number" class="form-ipt" value="<?= htmlspecialchars($fIncome); ?>" placeholder="Enter Income" name="fIncome" id="fIncome" step="0.01" required>
                </div>
                </div>
            <div class="row">
                <div class="col-lg-12 form-col">
                    <span class="form-span">EDUCATIONAL BACKGROUND</span><br>
                    <div style="display: flex; flex-direction: row;">
                        <div style="float: left; width: 20%;">
                            <label class="form-lbl">LEVEL</label><br>
                            <label class="form-lbl">Elementary</label><br>
                            <label class="form-lbl">Junior High</label><br>
                            <label class="form-lbl">Senior High</label><br>
                            <label class="form-lbl">College</label><br>
                        </div>
                        <div style="margin: 0 auto; width: 60%;">
                            <label class="form-lbl">NAME OF SCHOOL</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                            <input type="text" class="form-ipt" value="<?= htmlspecialchars($elementary); ?>" placeholder="Enter Name of Elementary School" oninput="isValidateLettersAndNumbers(event)" ; style="width: 95%; margin: 7px 0px 7px 0px;" name="elementary" id="elementary"><br>
                            <input type="text" class="form-ipt" value="<?= htmlspecialchars($jrHigh); ?>" placeholder="Enter Name of Junior High" oninput="isValidateLettersAndNumbers(event)" ; style="width: 95%; margin: 7px 0px 7px 0px;" name="jrHigh" id="jrHigh"><br>
                            <input type="text" class="form-ipt" value="<?= htmlspecialchars($srHigh); ?>" placeholder="Enter Name of Senior High" oninput="isValidateLettersAndNumbers(event)" ; style="width: 95%; margin: 7px 0px 7px 0px;" name="srHigh" id="srHigh"><br>
                            <input type="text" class="form-ipt" value="<?= htmlspecialchars($college); ?>" placeholder="Enter Name of College" oninput="isValidateLettersAndNumbers(event)" ; style="width: 95%; margin: 7px 0px 7px 0px;" name="college" id="college"><br>
                        </div>
                        <div style="float: right; width: 20%;">
                            <label class="form-lbl">YEAR</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                            <!-- <input type="number" class="form-ipt" value="<?= htmlspecialchars($elemYrGrad); ?>" placeholder="Year Graduated" style="width: 75%; margin: 7px 0px 7px 0px;" name="elemYrGrad" id="elemYrGrad"><br>
                            <input type="number" class="form-ipt" value="<?= htmlspecialchars($jrYrGrad); ?>" placeholder="Year Graduated" style="width: 75%; margin: 7px 0px 7px 0px;" name="jrYrGrad" id="jrYrGrad"><br>
                            <input type="number" class="form-ipt" value="<?= htmlspecialchars($srYrGrad); ?>" placeholder="Year Graduated" style="width: 75%; margin: 7px 0px 7px 0px;" name="srYrGrad" id="srYrGrad"><br>
                            <input type="number" class="form-ipt" value="<?= htmlspecialchars($clgYrGrad); ?>" placeholder="Year Graduated" style="width: 75%; margin: 7px 0px 7px 0px;" name="clgYrGrad" id="clgYrGrad"><br> -->
                            <select name="elemYrGrad" id="elemYrGrad" class="form-ipt" style="width: 85%; margin: 8px 0px 8px 0px;" required>
                                <option value="" disable <?= empty($elemYrGrad) ? 'selected' : '' ?>>Year Graduated</option>
                                <option value="2008" <?= $elemYrGrad == '2008' ? 'selected' : '' ?>>2008</option>
                                <option value="2009" <?= $elemYrGrad == '2009' ? 'selected' : '' ?>>2009</option>
                                <option value="2010" <?= $elemYrGrad == '2010' ? 'selected' : '' ?>>2010</option>
                                <option value="2011" <?= $elemYrGrad == '2011' ? 'selected' : '' ?>>2011</option>
                                <option value="2012" <?= $elemYrGrad == '2012' ? 'selected' : '' ?>>2012</option>
                                <option value="2013" <?= $elemYrGrad == '2013' ? 'selected' : '' ?>>2013</option>
                                <option value="2014" <?= $elemYrGrad == '2014' ? 'selected' : '' ?>>2014</option>
                                <option value="2015" <?= $elemYrGrad == '2015' ? 'selected' : '' ?>>2015</option>
                                <option value="2016" <?= $elemYrGrad == '2016' ? 'selected' : '' ?>>2016</option>
                                <option value="2017" <?= $elemYrGrad == '2017' ? 'selected' : '' ?>>2017</option>
                                <option value="2018" <?= $elemYrGrad == '2018' ? 'selected' : '' ?>>2018</option>
                                <option value="2019" <?= $elemYrGrad == '2019' ? 'selected' : '' ?>>2019</option>
                                <option value="2020" <?= $elemYrGrad == '2020' ? 'selected' : '' ?>>2020</option>
                                <option value="2021" <?= $elemYrGrad == '2021' ? 'selected' : '' ?>>2021</option>
                                <option value="2022" <?= $elemYrGrad == '2022' ? 'selected' : '' ?>>2022</option>
                                <option value="2023" <?= $elemYrGrad == '2023' ? 'selected' : '' ?>>2023</option>
                                <option value="2024" <?= $elemYrGrad == '2024' ? 'selected' : '' ?>>2024</option>
                            </select>
                            <select name="jrYrGrad" id="jrYrGrad" class="form-ipt" style="width: 85%; margin: 8px 0px 8px 0px;" required>
                                <option value="" disable <?= empty($jrYrGrad) ? 'selected' : '' ?>>Year Graduated</option>
                                <option value="2008" <?= $jrYrGrad == '2008' ? 'selected' : '' ?>>2008</option>
                                <option value="2009" <?= $jrYrGrad == '2009' ? 'selected' : '' ?>>2009</option>
                                <option value="2010" <?= $jrYrGrad == '2010' ? 'selected' : '' ?>>2010</option>
                                <option value="2011" <?= $jrYrGrad == '2011' ? 'selected' : '' ?>>2011</option>
                                <option value="2012" <?= $jrYrGrad == '2012' ? 'selected' : '' ?>>2012</option>
                                <option value="2013" <?= $jrYrGrad == '2013' ? 'selected' : '' ?>>2013</option>
                                <option value="2014" <?= $jrYrGrad == '2014' ? 'selected' : '' ?>>2014</option>
                                <option value="2015" <?= $jrYrGrad == '2015' ? 'selected' : '' ?>>2015</option>
                                <option value="2016" <?= $jrYrGrad == '2016' ? 'selected' : '' ?>>2016</option>
                                <option value="2017" <?= $jrYrGrad == '2017' ? 'selected' : '' ?>>2017</option>
                                <option value="2018" <?= $jrYrGrad == '2018' ? 'selected' : '' ?>>2018</option>
                                <option value="2019" <?= $jrYrGrad == '2019' ? 'selected' : '' ?>>2019</option>
                                <option value="2020" <?= $jrYrGrad == '2020' ? 'selected' : '' ?>>2020</option>
                                <option value="2021" <?= $jrYrGrad == '2021' ? 'selected' : '' ?>>2021</option>
                                <option value="2022" <?= $jrYrGrad == '2022' ? 'selected' : '' ?>>2022</option>
                                <option value="2023" <?= $jrYrGrad == '2023' ? 'selected' : '' ?>>2023</option>
                                <option value="2024" <?= $jrYrGrad == '2024' ? 'selected' : '' ?>>2024</option>
                            </select>
                            <select name="srYrGrad" id="srYrGrad" class="form-ipt" style="width: 85%; margin: 8px 0px 8px 0px;" required>
                                <option value="" disable <?= empty($srYrGrad) ? 'selected' : '' ?>>Year Graduated</option>
                                <option value="2008" <?= $srYrGrad == '2008' ? 'selected' : '' ?>>2008</option>
                                <option value="2009" <?= $srYrGrad == '2009' ? 'selected' : '' ?>>2009</option>
                                <option value="2010" <?= $srYrGrad == '2010' ? 'selected' : '' ?>>2010</option>
                                <option value="2011" <?= $srYrGrad == '2011' ? 'selected' : '' ?>>2011</option>
                                <option value="2012" <?= $srYrGrad == '2012' ? 'selected' : '' ?>>2012</option>
                                <option value="2013" <?= $srYrGrad == '2013' ? 'selected' : '' ?>>2013</option>
                                <option value="2014" <?= $srYrGrad == '2014' ? 'selected' : '' ?>>2014</option>
                                <option value="2015" <?= $srYrGrad == '2015' ? 'selected' : '' ?>>2015</option>
                                <option value="2016" <?= $srYrGrad == '2016' ? 'selected' : '' ?>>2016</option>
                                <option value="2017" <?= $srYrGrad == '2017' ? 'selected' : '' ?>>2017</option>
                                <option value="2018" <?= $srYrGrad == '2018' ? 'selected' : '' ?>>2018</option>
                                <option value="2019" <?= $srYrGrad == '2019' ? 'selected' : '' ?>>2019</option>
                                <option value="2020" <?= $srYrGrad == '2020' ? 'selected' : '' ?>>2020</option>
                                <option value="2021" <?= $srYrGrad == '2021' ? 'selected' : '' ?>>2021</option>
                                <option value="2022" <?= $srYrGrad == '2022' ? 'selected' : '' ?>>2022</option>
                                <option value="2023" <?= $srYrGrad == '2023' ? 'selected' : '' ?>>2023</option>
                                <option value="2024" <?= $srYrGrad == '2024' ? 'selected' : '' ?>>2024</option>
                            </select>
                            <select name="clgYrGrad" id="clgYrGrad" class="form-ipt" style="width: 85%; margin: 8px 0px 8px 0px;">
                                <option value="" disable <?= empty($clgYrGrad) ? 'selected' : '' ?>>Current Year Level</option>
                                <option value="1ST YEAR" <?= $clgYrGrad == '1ST YEAR' ? 'selected' : '' ?>>1ST YEAR</option>
                                <option value="2ND YEAR" <?= $clgYrGrad == '2ND YEAR' ? 'selected' : '' ?>>2ND YEAR</option>
                                <option value="3RD YEAR" <?= $clgYrGrad == '3RD YEAR' ? 'selected' : '' ?>>3RD YEAR</option>
                                <option value="4TH YEAR" <?= $clgYrGrad == '4TH YEAR' ? 'selected' : '' ?>>4TH YEAR</option>
                                <option value="5TH YEAR" <?= $clgYrGrad == '5TH YEAR' ? 'selected' : '' ?>>5TH YEAR</option>
                                
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 form-col">
                    <label class="form-lbl">Degree Course</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <select name="degreeCourse" id="degreeCourse" class="form-ipt" value="<?= htmlspecialchars($degreeCourse); ?>" required>
                        <option value="" disable <?= empty($degreeCourse) ? 'selected' : '' ?>>Select Degree Course</option>
                        <option value="BS Business Management" <?= $degreeCourse == 'BS Business Management' ? 'selected' : '' ?>>BS Business Management</option>
                        <option value="BS Computer Science" <?= $degreeCourse == 'BS Computer Science' ? 'selected' : '' ?>>BS Computer Science</option>
                        <option value="BS Entrepreneurship" <?= $degreeCourse == 'BS Entrepreneurship' ? 'selected' : '' ?>>BS Entrepreneurship</option>
                        <option value="BS Information Technology" <?= $degreeCourse == 'BS Information Technology' ? 'selected' : '' ?>>BS Information Technology</option>
                        <option value="BS Hotel and Restaurant Management" <?= $degreeCourse == 'BS Hotel and Restaurant Management' ? 'selected' : '' ?>>BS Hotel and Restaurant Management</option>
                        <option value="BS Office Administration" <?= $degreeCourse == 'BS Office Administration' ? 'selected' : '' ?>>BS Office Administration</option>
                        <option value="BS Secondary Education" <?= $degreeCourse == 'BS Secondary Education' ? 'selected' : '' ?>>BS Secondary Education</option>
                        <option value="BS Arts in Journalism" <?= $degreeCourse == 'BS Arts in Journalism' ? 'selected' : '' ?>>BS Arts in Journalism</option>
                        <option value="BS Early Childhood Education" <?= $degreeCourse == 'BS Early Childhood Education' ? 'selected' : '' ?>>BS Early Childhood Education</option>
                        <option value="BS Elementary Education" <?= $degreeCourse == 'BS Elementary Education' ? 'selected' : '' ?>>BS Elementary Education</option>
                        <option value="BS Psychology" <?= $degreeCourse == 'BS Psychology' ? 'selected' : '' ?>>BS Psychology</option>
                    </select>
                </div>
                <div class="col-lg-2 form-col">
                    <label class="form-lbl">Unit of Semester</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <input type="number" class="form-ipt" value="<?= htmlspecialchars($unit); ?>" placeholder="Unit" name="unit" id="unit" required>
                </div>
                <div class="col-lg-2 form-col">
                    <label class="form-lbl">GPA</label><sup style="color: red; font-weight: 900;"> *</sup><br>
                    <input type="number" class="form-ipt" value="<?= htmlspecialchars($gpa); ?>" placeholder="GPA" name="gpa" id="gpa" step="0.01" min="0" max="4" required>
                </div>
            </div><br>
            <br><br>

            <input type="checkbox" name="check" id="check" style="margin-top: 15px;" required>
            <label class="form-lbl" style="font-weight: 400;" id="tac">&nbsp;Terms and Conditions</label> <br><br>
            <button class="form-btn" style="width: 80px;" name="save-form">Save</button><br>

        </form>
        <!--popup for saving-->
        <div class="popup-container" id="update-popup">
            <div class="popup-save">
                <span class="close" id="close">&times;</span><br><br>
                <h1>Update</h1>
                <div class="row">
                    <div class="col-md-12">

                    </div>
                </div>
            </div>
        </div>

        <div class="popup-container" id="tac-popup">
            <div class="popup-tac">
                <i class='bx bxs-copy-alt'></i><br><br>
                <span>TERMS AND CONDITIONS</span>
                <h6>for Scholarship Application</h6><br>
                <p>Eligibility: By applying for this scholarship, applicants acknowledge that they meet the eligibility
                    criteria as outlined in the scholarship description. Eligibility criteria may include academic achievement,
                    financial need, extracurricular activities, and any other requirements specified by the scholarship provider.</p>

                <p>Application Deadline: All applications must be submitted by the specified deadline. Late applications will
                    not be considered unless explicitly stated otherwise by the scholarship provider.</p>

                <p>Accuracy of Information: Applicants are responsible for providing accurate and truthful information in
                    their application materials. Misrepresentation of any information may result in disqualification from the scholarship.</p>

                <p>Submission Format: Applications must be submitted through the designated online platform or via the specified submission
                    method. Any applications submitted through other means will not be accepted.</p>

                <p>Intellectual Property: By submitting an application, applicants grant the scholarship provider the right to use their
                    name, likeness, and application materials for promotional purposes related to the scholarship program.</p>

                <p>Confidentiality: All personal information collected from applicants will be kept confidential and used only for
                    the purpose of evaluating scholarship applications.</p>

                <p>Selection Process: Scholarship recipients will be selected based on criteria determined by the scholarship provider,
                    which may include academic achievement, extracurricular involvement, essays, letters of recommendation, and other
                    relevant factors.</p>

                <p>Notification: Scholarship recipients will be notified via the contact information provided in their application. If a
                    recipient cannot be reached within a reasonable period of time or fails to respond to the notification, the scholarship
                    may be forfeited, and an alternate recipient may be selected.</p>

                <p>Disbursement of Funds: Scholarship funds will be disbursed according to the terms specified by the scholarship provider.
                    Recipients may be required to provide proof of enrollment or other documentation before funds are released.</p>

                <p>Cancellation or Modification: The scholarship provider reserves the right to cancel, modify, or suspend the scholarship
                    program at any time for any reason. In the event of cancellation, no obligation will be incurred by the scholarship
                    provider.</p>

                <p>Governing Law: These terms and conditions shall be governed by and construed in accordance with the laws of
                    [insert jurisdiction]. Any disputes arising under these terms and conditions shall be subject to the exclusive
                    jurisdiction of the courts in [insert jurisdiction].</p>
                <br>
                <div class="tac-btn">
                    <button id="accept" class="form-btn">Accept</button>
                    <button id="decline">Decline</button>
                </div>
            </div>
        </div>

        <div id="popup1" class="popup" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5);">
            <div class="popup-content2">
                <br>
                <div class="row">
                    <div class="col-md-6 content3">
                        <span class="close-button" id="close_popup" style="display: flex; justify-content: end; position: relative; top: -20px; left: 7px; font-size: 25px; cursor: pointer;">&times;</span>
                        <div class="text-Popup">UPDATE</div>
                        <form style="padding-left: 0px;" method="POST">
                            <label class="form-lbl" style="color: #346473;">Current Password:</label><br>
                            <input class="lblpoptitle" type="password" id="cur_pass" name="cur_pass" value="**********" placeholder="Password" readonly><br><br>
                            <label class="form-lbl" style="color: #346473;">New Password:</label><br>
                            <input class="lblpoptitle" type="password" id="newpass" name="newpass" placeholder="New Password" required>
                            <div id="password-feedback" style="color: red; font-size: 12px; padding: 0; margin: 0;"></div>
                            <label class="form-lbl" style="color: #346473;">Re-enter New Password:</label><br>
                            <input class="lblpoptitle" type="password" id="re_newpass" name="re_newpass" placeholder="Re-enter New Password:" required><br><br>
                            <br>
                            <div style="padding-left: 25%;">
                                <button class="btn btn-lg shadow post-btn px-5" id="confirm_newpass">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <div class="one"></div>
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


        // popups
        var tac = document.getElementById("tac");
        var tacPopup = document.getElementById("tac-popup");
        var check = document.getElementById("check");
        var accept = document.getElementById("accept");
        var decline = document.getElementById("decline");

        tac.onclick = function() {
            tacPopup.style.display = "block";
        }

        accept.onclick = function() {
            tacPopup.style.display = "none";
            document.getElementById("check").checked = true;
        }

        decline.onclick = function() {
            tacPopup.style.display = "none";
            document.getElementById("check").checked = false;
        }

        // Show the popup when "Update" button is clicked
        document.getElementById("update_modal").onclick = function() {
            document.getElementById("popup1").style.display = "block";
        };

        // Close the popup when the close button is clicked
        document.getElementById("close_popup").onclick = function() {
            document.getElementById("popup1").style.display = "none";
        };

        // Hide the popup if the user clicks outside of it
        window.onclick = function(event) {
            var popup = document.getElementById("popup1");
            if (event.target == popup) {
                popup.style.display = "none";
            }
        };

        $(document).ready(function() {
            $('#confirm_newpass').click(function(event) {
                event.preventDefault(); // Prevent default form submission

                var newpass = $('#newpass').val();
                var re_newpass = $('#re_newpass').val();

                if (newpass.length < 8) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Password must be at least 8 characters long!',
                        confirmButtonColor: '#28a745',
                    });
                } else if (newpass !== re_newpass) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Passwords do not match!',
                        confirmButtonColor: '#28a745',
                    });
                } else {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, update it!',
                        cancelButtonText: 'No, cancel!',
                        confirmButtonColor: "#28a745",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "std_upt_pass.php",
                                data: {
                                    newpass: newpass,
                                    Student_No: "<?php echo $student_no; ?>"
                                },
                                success: function(response) {
                                    console.log("Password updated successfully");
                                    Swal.fire({
                                    title: 'Updated!',
                                    text: 'Your password has been updated.',
                                    icon: 'success',
                                    confirmButtonColor: '#28a745',
                                }).then(() => {
                                        console.log("Reloading page");
                                        window.location.reload(); // Reload the page after the success popup
                                    });
                                },
                                error: function() {
                                    console.error("Error updating password");
                                    Swal.fire(
                                        'Error!',
                                        'There was an error updating your password.',
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                }
            });
        });

        //address dropdown
        function populateProvinces() {
            var selectedRegion = document.getElementById("region").value;
            var provinceDropdown = document.getElementById("province");

            // Reset province dropdown
            provinceDropdown.innerHTML = '<option value="">Select Province</option>';

            // Add options based on selected region
            if (selectedRegion === "NCR") {
                addOption(provinceDropdown, "Manila");
                addOption(provinceDropdown, "Quezon City");
                addOption(provinceDropdown, "Makati");
                addOption(provinceDropdown, "Taguig");
                addOption(provinceDropdown, "Pasig");
                addOption(provinceDropdown, "Marikina");
                addOption(provinceDropdown, "Mandaluyong");
                addOption(provinceDropdown, "San Juan");
                addOption(provinceDropdown, "Caloocan");
                addOption(provinceDropdown, "Valenzuela");
                addOption(provinceDropdown, "Malabon");
                addOption(provinceDropdown, "Navotas");
                addOption(provinceDropdown, "Las Piñas");
                addOption(provinceDropdown, "Muntinlupa");
                addOption(provinceDropdown, "Pateros");
                addOption(provinceDropdown, "Pasay");

            } else if (selectedRegion === "CALABARZON") {
                addOption(provinceDropdown, "Cavite");
                addOption(provinceDropdown, "Batangas");
                addOption(provinceDropdown, "Laguna");
                addOption(provinceDropdown, "Rizal");
                addOption(provinceDropdown, "Quezon");

            } else if (selectedRegion === "ILOCOS REGION") {
                addOption(provinceDropdown, "Ilocos Norte");
                addOption(provinceDropdown, "Ilocos Sur");
                addOption(provinceDropdown, "La Union");
                addOption(provinceDropdown, "Pangasinan");

            } else if (selectedRegion === "CAGAYAN VALLEY") {
                addOption(provinceDropdown, "Batanes");
                addOption(provinceDropdown, "Cagayan");
                addOption(provinceDropdown, "Isabela");
                addOption(provinceDropdown, "Nueva Vizcaya");
                addOption(provinceDropdown, "Quirino");

            } else if (selectedRegion === "CENTRAL LUZON") {
                addOption(provinceDropdown, "Aurora");
                addOption(provinceDropdown, "Bataan");
                addOption(provinceDropdown, "Bulacan");
                addOption(provinceDropdown, "Nueva Ecija");
                addOption(provinceDropdown, "Nueva Vizcaya");
                addOption(provinceDropdown, "Pampanga");
                addOption(provinceDropdown, "Tarlac");
                addOption(provinceDropdown, "Zambales");

            } else if (selectedRegion === "MIMAROPA") {
                addOption(provinceDropdown, "Occidental Mindoro");
                addOption(provinceDropdown, "Oriental Mindoro");
                addOption(provinceDropdown, "Marinduque");
                addOption(provinceDropdown, "Palawan");
                addOption(provinceDropdown, "Romblon");

            } else if (selectedRegion === "BICOL REGION") {
                addOption(provinceDropdown, "Albay");
                addOption(provinceDropdown, "Camarines Norte");
                addOption(provinceDropdown, "Camarines Sur");
                addOption(provinceDropdown, "Catanduanes");
                addOption(provinceDropdown, "Masbate");
                addOption(provinceDropdown, "Sorsogon");

            } else if (selectedRegion === "WESTERN VISAYAS") {
                addOption(provinceDropdown, "Antique");
                addOption(provinceDropdown, "Aklan");
                addOption(provinceDropdown, "Capiz");
                addOption(provinceDropdown, "Iloilo");
                addOption(provinceDropdown, "Negros Occidental");

            } else if (selectedRegion === "CENTRAL VISAYAS") {
                addOption(provinceDropdown, "Bohol");
                addOption(provinceDropdown, "Cebu");
                addOption(provinceDropdown, "Negros Oriental");
                addOption(provinceDropdown, "Siquijor");

            } else if (selectedRegion === "EASTERN VISAYAS") {
                addOption(provinceDropdown, "Biliran");
                addOption(provinceDropdown, "Eastern Samar");
                addOption(provinceDropdown, "Leyte");
                addOption(provinceDropdown, "Northern Samar");
                addOption(provinceDropdown, "Southern Leyte");
                addOption(provinceDropdown, "Samar");

            } else if (selectedRegion === "ZAMBOANGA PENINSULA") {
                addOption(provinceDropdown, "Zamboanga del Norte");
                addOption(provinceDropdown, "Zamboanga del Sur");
                addOption(provinceDropdown, "Zamboanga Sibugay");
                addOption(provinceDropdown, "City of Zamboanga");

            } else if (selectedRegion === "NORTHERN MINDANAO") {
                addOption(provinceDropdown, "Bukidnon");
                addOption(provinceDropdown, "Camiguin");
                addOption(provinceDropdown, "Lanao del Norte");
                addOption(provinceDropdown, "Misamis Occidental");
                addOption(provinceDropdown, "Misamis Oriental");

            } else if (selectedRegion === "DAVAO REGION") {
                addOption(provinceDropdown, "Davao de Oro");
                addOption(provinceDropdown, "Davao del Norte");
                addOption(provinceDropdown, "Davao del Sur");
                addOption(provinceDropdown, "Davao Occidental");
                addOption(provinceDropdown, "Davao Oriental");

            } else if (selectedRegion === "SOCCSKARGEN") {
                addOption(provinceDropdown, "Cotabato");
                addOption(provinceDropdown, "Sarangani");
                addOption(provinceDropdown, "South Cotabato");
                addOption(provinceDropdown, "Sultan Kudarat");

            } else if (selectedRegion === "CARAGA") {
                addOption(provinceDropdown, "Agusan del Norte");
                addOption(provinceDropdown, "Agusan del Sur");
                addOption(provinceDropdown, "Bucas Grande Islands");
                addOption(provinceDropdown, "Surigao del Norte");
                addOption(provinceDropdown, "Surigao del Sur");

            } else if (selectedRegion === "BARMM") {
                addOption(provinceDropdown, "Basilan");
                addOption(provinceDropdown, "Lanao del Sur");
                addOption(provinceDropdown, "Maguindanao");
                addOption(provinceDropdown, "Sulu");
                addOption(provinceDropdown, "Tawi-Tawi");

            } else if (selectedRegion === "CAR") {
                addOption(provinceDropdown, "Abra");
                addOption(provinceDropdown, "Apayao");
                addOption(provinceDropdown, "Benguet");
                addOption(provinceDropdown, "Ifugao");
                addOption(provinceDropdown, "Kalinga");
                addOption(provinceDropdown, "Mountain Province");
            }
            // Reset municipality dropdown
            resetMunicipalityDropdown();
            resetBarangayDropdown();
        }

        function populateMunicipalities() {
            var selectedProvince = document.getElementById("province").value;
            var municipalityDropdown = document.getElementById("municipality");

            // Reset municipality dropdown
            municipalityDropdown.innerHTML = '<option value="">Select Municipality</option>';

            // Add options based on selected province
            if (selectedProvince === "Manila") {
                addOption(municipalityDropdown, "Manila");
            } else if (selectedProvince === "Quezon City") {
                addOption(municipalityDropdown, "Quezon City");
            } else if (selectedProvince === "Makati") {
                addOption(municipalityDropdown, "Makati");
                addOption(municipalityDropdown, "Taguig");
            } else if (selectedProvince === "Cavite") {
                addOption(municipalityDropdown, "Alfonso");
                addOption(municipalityDropdown, "Bacoor");
                addOption(municipalityDropdown, "Carmona");
                addOption(municipalityDropdown, "Dasmariñas");
                addOption(municipalityDropdown, "General Trias");
                addOption(municipalityDropdown, "Imus");
                addOption(municipalityDropdown, "Kawit");
                addOption(municipalityDropdown, "Maragondon");
                addOption(municipalityDropdown, "Naic");
                addOption(municipalityDropdown, "Noveleta");
                addOption(municipalityDropdown, "Rosario");
                addOption(municipalityDropdown, "Silang");
                addOption(municipalityDropdown, "Tagaytay");
                addOption(municipalityDropdown, "Tanza");
                addOption(municipalityDropdown, "Ternate");
                addOption(municipalityDropdown, "Trece Martires");
            } else if (selectedProvince === "Batangas") {
                addOption(municipalityDropdown, "Agoncilo");
                addOption(municipalityDropdown, "Balayan");
                addOption(municipalityDropdown, "Batangas City");
                addOption(municipalityDropdown, "Bauan");
                addOption(municipalityDropdown, "Calaca");
                addOption(municipalityDropdown, "Calatagan");
                addOption(municipalityDropdown, "Lemery");
                addOption(municipalityDropdown, "Lipa");
                addOption(municipalityDropdown, "Nasugbu");
                addOption(municipalityDropdown, "Rosario");
                addOption(municipalityDropdown, "San Jose");
                addOption(municipalityDropdown, "San Juan");
                addOption(municipalityDropdown, "Santo Tomas");
                addOption(municipalityDropdown, "Tanauan");

            } else if (selectedProvince === "Rizal") {
                addOption(municipalityDropdown, "Antipolo");
                addOption(municipalityDropdown, "Cainta");
                addOption(municipalityDropdown, "Cardona");
                addOption(municipalityDropdown, "Jalajala");
                addOption(municipalityDropdown, "Morong");
                addOption(municipalityDropdown, "Binangonan");
                addOption(municipalityDropdown, "Taytay");
                addOption(municipalityDropdown, "Rodriguez");
                addOption(municipalityDropdown, "San Mateo");
                addOption(municipalityDropdown, "Teresa");
                addOption(municipalityDropdown, "Tanay");
                addOption(municipalityDropdown, "Baras");
                addOption(municipalityDropdown, "Pililla");

            } else if (selectedProvince === "Quezon") {
                addOption(municipalityDropdown, "Agdangan");
                addOption(municipalityDropdown, "Buenavista");
                addOption(municipalityDropdown, "Burdeos");
                addOption(municipalityDropdown, "Calauag");
                addOption(municipalityDropdown, "Candelaria");
                addOption(municipalityDropdown, "Dolores");
                addOption(municipalityDropdown, "General Luna");
                addOption(municipalityDropdown, "General Nakar");
                addOption(municipalityDropdown, "Guinayangan");
                addOption(municipalityDropdown, "Gumaca");
                addOption(municipalityDropdown, "Infanta");
                addOption(municipalityDropdown, "Jomalig");
                addOption(municipalityDropdown, "Lopez");
                addOption(municipalityDropdown, "Luisiana");
                addOption(municipalityDropdown, "Macalelon");
                addOption(municipalityDropdown, "Mauban");
                addOption(municipalityDropdown, "Mulanay");
                addOption(municipalityDropdown, "Padua");
                addOption(municipalityDropdown, "Pagbilao");
                addOption(municipalityDropdown, "Panukulan");
                addOption(municipalityDropdown, "Pitogo");
                addOption(municipalityDropdown, "Plaridel");
                addOption(municipalityDropdown, "Quezon");
                addOption(municipalityDropdown, "Real");
                addOption(municipalityDropdown, "San Andres");
                addOption(municipalityDropdown, "San Antonio");
                addOption(municipalityDropdown, "San Francisco");
                addOption(municipalityDropdown, "San Narciso");
                addOption(municipalityDropdown, "San Pablo");
                addOption(municipalityDropdown, "San Pedro");
                addOption(municipalityDropdown, "Santa Elena");
                addOption(municipalityDropdown, "Santa Ignacia");
                addOption(municipalityDropdown, "Santa Lucia");
                addOption(municipalityDropdown, "Santa Maria");
                addOption(municipalityDropdown, "Santo Niño");
                addOption(municipalityDropdown, "Tiaong");
                addOption(municipalityDropdown, "Unisan");

            } else if (selectedProvince === "Laguna") {
                addOption(municipalityDropdown, "Alaminos");
                addOption(municipalityDropdown, "Bay");
                addOption(municipalityDropdown, "Biñan");
                addOption(municipalityDropdown, "Cabuyao");
                addOption(municipalityDropdown, "Calamba");
                addOption(municipalityDropdown, "Calauan");
                addOption(municipalityDropdown, "Cavinti");
                addOption(municipalityDropdown, "Kalayaan");
                addOption(municipalityDropdown, "Liliw");
                addOption(municipalityDropdown, "Los Baños");
                addOption(municipalityDropdown, "Rizal");
                addOption(municipalityDropdown, "San Pablo");
                addOption(municipalityDropdown, "San Pedro");
                addOption(municipalityDropdown, "Santa Cruz");
                addOption(municipalityDropdown, "Santa Maria");
                addOption(municipalityDropdown, "Santa Cruz");

                resetBarangayDropdown();
            }
        }

        function populateBarangay() {
            var selectedMunicipality = document.getElementById("municipality").value;
            var barangayDropdown = document.getElementById("barangay");

            barangayDropdown.innerHTML = '<option value="">Select Barangay</option>';

            if (selectedMunicipality === "Imus") {
                addOption(barangayDropdown, "Anabu")
                addOption(barangayDropdown, "Bucandala")
                addOption(barangayDropdown, "Carsadang Bago")
                addOption(barangayDropdown, "Medicion")
                addOption(barangayDropdown, "Malagasang")
            } else if (selectedMunicipality === "Bacoor") {
                addOption(barangayDropdown, "Zapote")
                addOption(barangayDropdown, "Talaba")
                addOption(barangayDropdown, "Niog")
                addOption(barangayDropdown, "Panapaan")
            } else if (selectedMunicipality === "Kawit") {
                addOption(barangayDropdown, "Balsahan-Bisita")
                addOption(barangayDropdown, "Binakayan-Aplaya")
                addOption(barangayDropdown, "Binakayan-Kanluran")
                addOption(barangayDropdown, "Gahak")
            } else if (selectedMunicipality === "Dasmariñas") {
                addOption(barangayDropdown, "Paliparan")
                addOption(barangayDropdown, "Langkaan")
                addOption(barangayDropdown, "Burol")
                addOption(barangayDropdown, "Salitran")
            }
        }

        function addOption(selectElement, optionValue) {
            var option = document.createElement("option");
            option.text = optionValue;
            option.value = optionValue;
            selectElement.add(option);
        }

        function resetMunicipalityDropdown() {
            var municipalityDropdown = document.getElementById("municipality");
            municipalityDropdown.innerHTML = '<option value="">Select Municipality</option>';
        }

        function addOption(selectElement, optionValue) {
            var option = document.createElement("option");
            option.text = optionValue;
            option.value = optionValue;
            selectElement.add(option);
        }

        function resetBarangayDropdown() {
            var municipalityDropdown = document.getElementById("barangay");
            municipalityDropdown.innerHTML = '<option value="">Select Barangay</option>';
        }

        /// log out button
        document.getElementById('logout-link').addEventListener('click', function(event) {
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

        function validateInput(event) {
            const regex = /^[A-Za-z\s]*$/; // Regex to allow only letters and spaces
            const inputField = event.target;

            if (!regex.test(inputField.value)) {
                inputField.value = inputField.value.replace(/[^A-Za-z\s]/g, ''); // Remove invalid characters
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

        function isValidateLettersAndNumbers(event) {
            const regex = /^[A-Za-z0-9\s]*$/; // Regex to allow only letters, numbers, and spaces
            const inputField = event.target;

            // Check if the input value matches the regex
            if (!regex.test(inputField.value)) {
                // Remove invalid characters
                inputField.value = inputField.value.replace(/[^A-Za-z0-9\s]/g, '');
            }
        }
    </script>

</body>

</html>