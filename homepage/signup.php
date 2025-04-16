<?php
    session_start();
    include "verification_sender.php";
    include 'Time_Expiration.php';
    non_activated_deletion($conn);


    $std_No = $_SESSION['std_no'];

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scholarship System</title>
    <!-- Bootstrap -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <!-- Icon website -->
    <link rel="icon" type="image/x-icon" href="logo.png">
    <!-- external CSS -->
    <link href="signup.css" rel="stylesheet">
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
                    <a class="navbar-brand" href="homepage.php">SCHOLARSHIP SYSTEM</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-left: 100px;">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
                        <div class="d-grid gap-2 d-md-block">
                            <a href="signup.php">
                                <button class="btn btn-success" type="button">Sign Up</button>
                            </a>
                            <a href="login_page.php">
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
    <!-- Signup Form -->
    <div class="signform-container">
        <?php
       $conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');


       // Check if form is submitted
       if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
           if (isset($_POST["pass"]) && isset($_POST["confirm_pass"])) {
               $pass = $_POST["pass"];
               $confirm_pass = $_POST["confirm_pass"];
               if ($pass != $confirm_pass) {
                   echo '<script>
                       Swal.fire({
                           title: "MISMATCH",
                           text: "Passwords do not match",
                           icon: "error",
                           confirmButtonColor: "#346473"
                       }).then(() => {
                           window.history.back();
                       });
                   </script>';
               } else {

                   // Get the sign up form data
                   $first_name = $_POST['fname'];
                   $last_name = $_POST['lname'];
                   $email_address = $_POST['email'];
                   $Verification_Token = md5(rand());

                   // Validate email pattern
                   if (!preg_match('/^ic\..+\..+@cvsu\.edu\.ph$/', $email_address)) {
                       echo '<script>
                           Swal.fire({
                               title: "Invalid Email",
                               text: "Please use a CvSU student account email (ic.*.*@cvsu.edu.ph)",
                               icon: "error",
                               confirmButtonColor: "#346473"
                           }).then(() => {
                               window.history.back();
                           });
                       </script>';
                   } else {
                       // Check if email already exists
                       $check_stmt = $conn->prepare("SELECT Email_Address FROM tbl_student_acc WHERE Email_Address = ?");
                       $check_stmt->bind_param("s", $email_address);
                       $check_stmt->execute();
                       $check_stmt->store_result();
       
                       if ($check_stmt->num_rows > 0) {
                           echo '<script>
                               Swal.fire({
                                   title: "Duplicate Entry",
                                   text: "Email Address already exists",
                                   icon: "error",
                                   confirmButtonColor: "#346473"
                               }).then(() => {
                                   window.history.back();
                               });
                           </script>';
                       } else {
                           // Hash the password
                           $hashed_password = password_hash($pass, PASSWORD_BCRYPT);
       
                           // Prepare and bind
                           $stmt = $conn->prepare("INSERT INTO tbl_student_acc (Student_No, First_name, Last_name, Email_Address, Password, Verification_Token) VALUES (?,?, ?, ?, ?, ?)");
                           $stmt->bind_param("ssssss", $std_No, $first_name, $last_name, $email_address, $hashed_password, $Verification_Token);

                           // Execute the statement
                           if ($stmt->execute()) {

                            $_SESSION['status'] = '<script>
                                   Swal.fire({
                                       title: "Verification",
                                       text: "Register Successful, Check you your email to verify your Email, You only have 1 Hour to verify",
                                       icon: "info",
                                       confirmButtonColor: "#25A55F"
                                   }).then(() => {
                                       window.location.href = "../homepage/login_page.php";
                                   });
                               </script>';

                            send_verification("Scholarship", "$email_address", "$Verification_Token");

                            $_SESSION['resend_verification'] = "<h6 style='color: green;'>Note:</h6><br><p style='color: green;'>If email not sent maybe your email is incorrect, please try again</p>";


                           } else {
                               echo '<script>
                                   Swal.fire({
                                       title: "Error",
                                       text: "An error occurred while creating the record",
                                       icon: "error",
                                       confirmButtonColor: "#d33"
                                   }).then(() => {
                                       window.history.back();
                                   });
                               </script>';
                           }
                           
                           // Close the statement
                           $stmt->close();
                       }

                       // Close the check statement
                       $check_stmt->close();
                   }

                   
               }

           }
        }

        if (isset($_SESSION['status'])){
            echo $_SESSION['status']; 
            unset($_SESSION['status']);
        }

        $check_query = $conn->query("SELECT * FROM tbl_cvsu_students WHERE Student_No = '$std_No';");

        $check_stmt = $check_query->fetch_assoc();

        ?>

        <div class="signform-content">
            <form id="signup-form" method="post">
                <div class="row">
                    <h4 style="padding-left:2px; padding-bottom:25px;font-family:Inter; color:#25A55F;">Sign up for your account</h4>
                    <div class="col-sm-6">
                        <label for="fname">First name:</label>
                        <div class="sign_input-container" style="width:95%;">
                            <input type="text" id="Fname" value=<?php echo $check_stmt['First_name'];?> placeholder="Enter your first name" name="fname" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="lname">Last name:</label>
                        <div class="sign_input-container" style="width: 95%;">
                            <input type="text" id="ln" value=<?php echo $check_stmt['Last_name'];?> placeholder="Enter your last name" name="lname" required>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label for="email">Email Address:</label>
                        <div class="sign_input-container full">
                            <input type="email" id="Em" value=<?php echo $check_stmt['CVSU_Email'];?> placeholder="Enter your email" name="email" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="psw">Password:</label>
                        <div class="sign_input-container" style="width:95%; padding-bottom:5px;">
                            <input type="password" id="psw" placeholder="Enter your password" name="pass" required>
                            <div id="password-feedback" style="color: red; font-size: 12px; padding-top: 5px; padding-bottom: 0;"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="con_psw">Confirm Password:</label>
                        <div class="sign_input-container" style="width:95%; padding-bottom:5px;">
                            <input type="password" id="confirm-psw" placeholder="Confirm your password" name="confirm_pass" required>
                        </div>
                    </div>

                    <?php
                        if (isset($_SESSION['resend_verification'])){
                            echo $_SESSION['resend_verification'];
                            if(isset($_POST['resend_email'])){
                                send_verification("Scholarship", "$email_address", "$Verification_Token");
                            }
                            unset($_SESSION['resend_verification']);
                        }           
                    ?>

                    

                    <div class="col-sm-8">
                        <input type="checkbox" name="check" id="check" style="margin-top: 15px; cursor:pointer;accent-color:#003cff;" required>
                        <label class="form-lbl" style="font-weight: 400; font-size:16px;padding-bottom:35px;cursor:pointer; color:#346473;" id="tac">I accept all terms and conditions</label>
                    </div>
                </div>

                <button type="submit" id="signup-btn">SIGN UP</button>
                <h5 style="padding-left:130px; padding-top:15px; font-family:Inter; color:#25A55F; font-size:15px;">Already have an account? <a href="login_page.php">Log in</a></h5>
            </form>
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

            <p>Governing Law: These terms and conditions shall be governed by and construed in accordance with the laws of the Philippines.
                Any disputes arising under these terms and conditions shall be subject to the exclusive jurisdiction of the courts in Cavite, Philippines.</p>
            <div class="tac-btn">
                <button id="accept" class="form-btn">Accept</button>
                <button id="decline">Decline</button>
            </div>
        </div>
    </div>



</body>
<!-- javascript  -->
<script src="bootstrap.bundle.min.js"></script>
<script src="bootstrap.min.js"></script>
<script>
    const faqs = document.querySelectorAll(".faq-dropdown");
    faqs.forEach(faq => {
        faq.addEventListener("click", () => {
            faq.classList.toggle("focus");
        })
    })

    function togglePopup() {
        document.getElementById("popup-1").classList.toggle("focus");
    }

    function togglePopup() {
        document.getElementById("popup-2").classList.toggle("focus");
    }

    function togglePopup() {
        document.getElementById("popup-3").classList.toggle("focus");
    }

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

    const passwordInput = document.getElementById('psw');
    const passwordFeedback = document.getElementById('password-feedback');
    const signupButton = document.getElementById('signup-btn');
    const signupForm = document.getElementById('signup-form'); // Make sure to add this line if the form element wasn't declared earlier

    function validatePassword(password) {
        const criteria = {
            hasUpperCase: /[A-Z]/.test(password),
            hasLowerCase: /[a-z]/.test(password),
            hasNumber: /\d/.test(password),
            hasSymbol: /[!@#$%^&*(),.?":{}|<>]/.test(password), // Optional
            isLongEnough: password.length >= 8
        };

        let feedback = '';

        if (!criteria.hasUpperCase) feedback += 'Must contain an uppercase letter. ';
        if (!criteria.hasLowerCase) feedback += 'Must contain a lowercase letter. ';
        if (!criteria.hasNumber) feedback += 'Must contain a number. ';
        if (!criteria.hasSymbol) feedback += 'Should contain a symbol. '; // Optional
        if (!criteria.isLongEnough) feedback += 'Should be at least 8 characters. '; // Optional

        return {
            isValid: criteria.hasUpperCase && criteria.hasLowerCase && criteria.hasNumber && criteria.isLongEnough,
            feedback
        };
    }

    passwordInput.addEventListener('input', function() {
        const {
            feedback
        } = validatePassword(passwordInput.value);
        passwordFeedback.textContent = feedback;
        passwordFeedback.style.color = feedback === '' ? 'green' : 'red';
    });

    signupForm.addEventListener('submit', function(event) {
        const {
            isValid
        } = validatePassword(passwordInput.value);

        if (!isValid) {
            event.preventDefault(); // Prevent form submission
            Swal.fire({
                title: "Invalid Password",
                text: "Password must contain at least one uppercase letter, one lowercase letter, and one number.",
                icon: "error",
                confirmButtonColor: "#346473"
            });
        }
    });
    function validateForm() {
            const fname = document.getElementById('fname').value;
            const lname = document.getElementById('lname').value;
            const email = document.getElementById('email').value;
            const pass = document.getElementById('pass').value;
            const confirm_pass = document.getElementById('confirm_pass').value;

            // Validate password match
            if (pass !== confirm_pass) {
                Swal.fire({
                    title: "MISMATCH",
                    text: "Passwords do not match",
                    icon: "error",
                    confirmButtonColor: "#346473"
                });
                return false;
            }

            // Validate email pattern
            const emailPattern = /^ic\..+\..+@cvsu\.edu\.ph$/;
            if (!emailPattern.test(email)) {
                Swal.fire({
                    title: "Invalid Email",
                    text: "Please use a CvSU student account email (ic.*.*@cvsu.edu.ph)",
                    icon: "error",
                    confirmButtonColor: "#346473"
                });
                return false;
            }

            // If all validations pass, proceed with form submission
            return true;
        }
</script>

</html>