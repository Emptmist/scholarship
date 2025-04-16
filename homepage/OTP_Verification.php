<?php
session_start();
ob_start();

$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

include "OTP_generator.php";

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
        <link href="OTP_verification.css" rel="stylesheet">

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
                    <div class="container-fluid" style="justify-content: flex-start;">
                        <a href="homepage.php"><img src="logo.png" class="rounded float-start" alt="Logo" style="margin-left: 20px;"></a>
                        <a class="navbar-brand" href="homepage.php">SCHOLARSHIP SYSTEM</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        
                    </div>
                </nav>
            </div>
        </div>
        <!-- Background Image -->
        <div class="bg-image"></div>

        <?php
        
        if(isset($_POST['verify'])){

            $d1 = $_POST['digit_1'];
            $d2 = $_POST['digit_2'];
            $d3 = $_POST['digit_3'];
            $d4 = $_POST['digit_4'];

            $otp_verification = "$d1$d2$d3$d4";

           // Prepare the SQL statement
            $check_OTP = $conn->prepare("SELECT OTP_password FROM tbl_student_acc WHERE OTP_password = ?");
            if (!$check_OTP) {
                die("SQL prepare failed: " . $conn->error);
            }

            $check_OTP->bind_param("s", $otp_verification);
            $check_OTP->execute();
            $result = $check_OTP->get_result();

            if ($result->num_rows > 0) {
                // Fetch the row
                $row = $result->fetch_assoc();
                $OTP_value = $row['OTP_password'];
                
                // Compare the values using strict comparison
                if ($otp_verification === $OTP_value) {
                    $_SESSION["ref_otp"] = $OTP_value;
                    header('location: Reset_pass.php');
                }
            } else {
                echo '<script>
                            Swal.fire({
                            title: "Error",
                            text: "Incorrect OTP verification",
                            icon: "error",
                            confirmButtonColor: "#d33"
                                   })
                        </script>';
            }



            
            

            

        }
        
        ?>

        <div class="maildiv">
            <div class="contents">
                <img src="mail2.gif" alt="Envelope Icon" style="height:30%; width:50%;margin-left:4%;">
                <p class="inf">Please Check Your Email</p>
                <p class="inf2">We've Sent a code to <?php echo $_SESSION['email']?></p>
            </div>

            <form action="" method="post" class="container">

                <div class="container-fluid" style="display: flex; justify-content:space-evenly;">
                    <input type="text" class="containers" name="digit_1" oninput="validateNumberInput(event)" maxlength="1" style="text-align:center;" required>
                    <input type="text" class="containers" name="digit_2" oninput="validateNumberInput(event)" maxlength="1" style="text-align:center;" required>
                    <input type="text" class="containers" name="digit_3" oninput="validateNumberInput(event)" maxlength="1" style="text-align:center;" required>
                    <input type="text" class="containers" name="digit_4" oninput="validateNumberInput(event)" maxlength="1" style="text-align:center;" required>
                </div>


    <!-- Sa susunod na tong resend code, di ko pa alam e -->

                <!-- <div class="inf2" style="margin-top: 2%; margin-bottom: 5%;">Didn't get the code ?
                    <a href=""> <u style="color:green; font-weight: 530;"> Click here to resend</u></a>
                </div> -->

                <div class="buttons" style="margin-bottom: 5%; margin-top:25px;">
                    <a href="login_page.php"><button type="button" class="button_1">CANCEL</button></a>
                    <button type="submit" class="button_1" name="verify">VERIFY</button>
                </div>

            </form>
        </div>


        <script>
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



    </body>


    </html>
