<?php
session_start();
ob_start();

$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

include "verification_sender.php";
include "OTP_generator.php"

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scholarships System</title>
    <!-- Bootstrap -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <!-- Icon website -->
    <link rel="icon" type="image/x-icon" href="logo.png">
    <!-- external -->
    <link href="forgot_pass.css" rel="stylesheet">
    <!--sweetalert2-->
    <script src="sweetalert2.all.min.js"></script>
    <link href="sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Navigation Bar -->
    <div class="row">
        <div class="col-sm-12 nav-fixed">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a href="homepage.php"><img src="logo.png" class="rounded float-start" alt="Logo" style="margin-left: 20px;"></a>
                    <a class="navbar-brand" href="homepage.php">SCHOLARSHIPS SYSTEM</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-left: 100px;">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="display: none;">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="homepage.php#REQUIREMENTS">REQUIREMENTS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="homepage.php#BENEFITS">BENEFITS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="homepage.php#ABOUTS">ABOUT US</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="homepage.php#FAQ">FAQ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="homepage.php#CONTACTUS">CONTACT US</a>
                            </li>
                        </ul>
                        <div class="d-grid gap-2 d-md-block" >
                            <a href="signup.php" style="display: none;">
                                <button class="btn btn-success" type="button">Sign Up</button>
                            </a>
                            <a href="login_page.php" style="display: none;" >
                                <button class="btn btn-success" type="button">Sign In</button>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Background Image -->
    <div class="bg-image"></div>

    <?php

    $std_no = '';
    
    if(isset($_POST['search_std'])){
        $std_no = $_POST['std_no'];

        $check_query = $conn->query("SELECT Student_No FROM tbl_cvsu_students WHERE Student_No = '$std_no';");

        if ($check_query->num_rows == 0) {
            // Email does not exist in the database
            $_SESSION['status'] = '<p style="color: red;">This Student number is not Existing</p>';

        } else {

            $check_query_tbl_stud = $conn->query("SELECT Student_No FROM tbl_student_acc WHERE Student_No = '$std_no';");

            if ($check_query_tbl_stud->num_rows == 0){
                $_SESSION['std_no'] = $std_no;
                header('location: signup.php');
            }else{
                $_SESSION['status'] = '<p style="color: red;">This student number is officially signed-up</p>';
            }
        }
    }
    
    ?>



    <!-- Login Form -->

    

    <div class="form-container">
        <div class="form-content"   >
            <form action="" method="post">
                <h4 style="padding-left:2px; font-family:Inter; color: #346473; "><b>STUDENT NUMBER</b></h4>
                <p style="color: gray;">Enter your Student number to check If you are officially enrolled</p>
                <label for="email" style="color: #346473;">Student Number:</label>
                <div class="input-container">
                    <input type="text" id="std_no" placeholder="Enter your Student number" value="<?php echo $std_no; ?>" name="std_no" oninput="validateNumberInput(event)" maxlength="9" required>
                    <!-- <img src="emaill.png" alt="Email Icon"> -->
                </div>
                <p style="color: #346473;"><b>Note: </b><span style="color: gray;">If your student number is not yet available in the system <br> please wait for notification to inform you if it's available to sign up</span></p>
                <?php
    
                if (isset($_SESSION['status'])){
                    echo $_SESSION['status']; 
                    unset($_SESSION['status']);
                }
                
                ?>
                <button type="submit" name="search_std">ENTER</button> <span style="padding: 15px; float: right;"><a href="login_page.php">Back to Login</a></span>
            </form>
        </div>
    </div>
</body>

<!-- javascript  -->
<script src="bootstrap.bundle.min.js"></script>
<script src="bootstrap.min.js"></script>
<script>
    //show pass
    function myFunction() {
        var x = document.getElementById("pass");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
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

</script>

</html>