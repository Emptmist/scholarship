<!doctype html>
<?php
include 'Time_Expiration.php';
non_activated_deletion($conn);



?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scholarship System</title>
    <!--bootstrap-->
    <link href="bootstrap.min.css" rel="stylesheet">
    <!--icon website-->
    <link rel="icon" type="image/x-icon" href="logo.png">
    <!--icons-->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!-- external css-->
    <link href="homepage.css" rel="stylesheet">

  </head>
  <body>
    <!-- navigation bar -->
    <div class="row">
        <div class="col-md-12 col-sm-12  nav-fixed">
            <nav class="navbar navbar-expand-lg" >
                <div class="container-fluid">
                    <a href="#"><img src="logo.png" class="rounded float-start" alt="..." style="margin-left: 20px;"></a>
                    <a class="navbar-brand" href="#">SCHOLARSHIP SYSTEM</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-left: 100px;">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#REQUIREMENTS">REQUIREMENTS</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#BENEFITS">BENEFITS</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#ABOUTS">ABOUTS US</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#FAQ">FAQ</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#CONTACTUS">CONTACT US</a>
                            </li>
                        </ul>
                        
                        <div class="d-grid gap-2 d-md-block">
                            <a href="student_number.php">
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
    <!-- bg picture cvsu start homapge -->
    <div class="row">
        <div class="col-sm-12 bg-image">
            <div class="content-title">
                <p class="h1">SCHOLARSHIP MANAGEMENT SYSTEM</p>
                <a href="student_number.php">
                <button class="btn btn-success btn-join" type="button" >JOIN</button>
                </a>
            </div>
        </div>
    </div>

    <!-- benefits row-->
    <div class="row bg-color" id="BENEFITS">
        <div class="col-sm-12 content-benefits">
            <h3 class="benefits">BENEFITS</h3>
            <div class="row content-three-title">
                <div class="col-sm-1" style="width: 200px;">
                </div>
                <div class="col-sm-3" align="center">ACCESS TO OPPORTUNITIES
                    <div class="card">
                        <div class="card-size">
                            <img src="access.png" alt="" style="width: 150px;">
                        </div>
                        Unlock diverse scholarship opportunities for further education and career advancement.
                    </div>
                </div>
                <div class="col-sm-3"  align="center">ENCOURAGE EXCELLENCE
                    <div class="card">
                            <div class="card-size">
                                <img src="excellence.png" alt="" style="width: 150px; height: 150px;">
                            </div>
                            Reward academic achievements, motivate for excellence, benefit students and society.
                        </div>
                    </div>
                <div class="col-sm-3"  align="center">ALLOWANCE
                    <div class="card">
                            <div class="card-size">
                                <img src="allowance.png" alt="" style="width: 150px;">
                            </div>
                            Receive financial assistance for living expenses.
                        </div>
                </div>
                <div class="col-sm-1" style="width: 250px;">

                </div>
            </div>
                <div class="col-sm-12" style="margin-top: 100px; color:#346473; padding-bottom: 50px; font-style: italic; text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
                font-family: Inter;
                font-size: 36px;
                font-style: italic;
                font-weight: 300;
                line-height: normal;">
                        <p class="h3">“Together, we build dreams and transform the future through educational opportunities”</p>
                </div>
        </div>
    </div>
    <!-- requirements row -->
    <div class="row requirements" id="REQUIREMENTS">
        <div class="col-lg-6 col-md-3 content-req">
            <p class="h3">ELIGIBILITY</p>
            
            <div class="card card-req">
            <br><br>
            <p class="txt-align">
                Applicants must meet the following criteria:
            </p> 
            <br>
            <ul class="txt-align">
                <li>
                Must maintain a minimum GPA of 85% or higher.
                </li> 
                <li>
                All required documents, including ID picture, grades, PSA documents and Application Form must be uploaded in the Manage Attachments section within the specified deadlines.
                </li>
                <li>
                Incomplete or inaccurate document submissions may result in disqualification from the scholarship.
                </li>
            </ul>
            </div>
        </div>
        <div class="col-lg-6 col-md-3 content-req">
            <p class="h3">REQUIREMENTS</p>
            <div class="card card-req">
            <br><br>
             <p class="txt-align">Applicants must have the following documents:</p>
            <br>
            <ul class="txt-align">
                <li>
                ID picture
                </li>
                <li>
                Academic grades/transcripts
                </li>
                <li>
                PSA (Philippine Statistics Authority) documents (for verification of identity)
                </li>
                <li>
                Proof of Enrollment
                </li>
                <li>
                Application Form
                </li>
            </ul>
            </div>
        </div>
    </div>
    <!-- mission, vision, values row -->
        <div class="row content-goals">
            <div class="row goals">
            <div class="col-sm-1" style="width: 250px;" >
            </div>
            <div class="col-sm-3" align="center"> 
                
                <div class="card-mission">
                    <div class="content-mission">
                    <p class="h3 mission">
                    OUR MISSION
                    </p>
                    <br><br>
                    <p class="h6">
                    Our mission outlines our purpose and what we aim to achieve as an organization.
                    </p><br><br>
                    <div class="line-our-mission"> </div>

                    <div class="popup" id="popup-1">
                        <div class="overlay"></div>
                        <div class="content-pop">
                            <div class="close-btn" onclick="togglePopup1()">&times;</div>
                            <br><br>
                            <h1>OUR MISSION</h1>
                            <p style="font-size: 24px; text-align: center; margin-inline-start: 100px; margin-inline-end: 100px;">With the aim of empowering and supporting students to pursue their educational goals, we provide meaningful scholarship opportunities that are accessible and merit based in order to enable them to achieve their goals. <br><br>

                                In order to foster excellence in education, foster equity, and develop leaders of the future who will make positive contributions to society, we are committed to nurturing academic excellence, equity, and diversity. <br><br>

                                To make education accessible to all by providing a comprehensive platform for scholarship applications and assistance. We strive to break down financial barriers and empower students to pursue their dreams.</p>
                                <button onclick="togglePopup1()" class="view-btn">Back</button>
                            </div>
                    </div>
                    <button onclick="togglePopup1()" class="view-btn">view</button>
                    </div>

                </div>
            </div>
            <div class="col-sm-3" align="center"> 
                
                <div class="card-mission">
                    <div class="content-mission">
                    <p class="h3 mission">
                    OUR VISION
                    </p>
                    <br><br>
                    <p class="h6">
                    Our vision represents our aspirations and the future impact we strive to make.
                    </p><br><br>
                    <div class="line-our-mission"> </div>

                    <div class="popup" id="popup-2">
                        <div class="overlay"></div>
                        <div class="content-pop">
                            <div class="close-btn" onclick="togglePopup2()">&times;</div>
                            <h1>OUR VISION</h1>
                            <p style="font-size: 24px; text-align: center; margin-inline-start: 100px; margin-inline-end: 100px;">In order to realize our vision, we aim to create an educational and economic environment where every student has an equal chance to acquire a quality education, regardless of his or her socioeconomic background. <br><br>

The Scholarship Management System envisions a society in which the role of education is as a catalyst for positive change, encouraging the development of innovation, social mobility, and sustainable development. <br><br>

Our goal is to foster a society where every individual has the opportunity to realize their full potential through education, creating a world of equal opportunities and endless possibilities.</p>
                                <br><br>
                                <button onclick="togglePopup2()" class="view-btn">Back</button>
                            </div>
                    </div>
                    <button onclick="togglePopup2()" class="view-btn">view</button>
                    </div>

                </div>
            </div>
            <div class="col-sm-3" align="center"> 
                
                <div class="card-mission">
                    <div class="content-mission">
                    <p class="h3 mission">
                    OUR VALUES
                    </p>
                    <br><br>
                    <p class="h6">
                    Our values define the principles and beliefs that guide our actions and decisions.
                    </p><br><br>
                    <div class="line-our-mission"> </div>
                    

                    <div class="popup" id="popup-3">
                        <div class="overlay"></div>
                        <div class="content-pop">
                            <div class="close-btn" onclick="togglePopup3()">&times;</div>
                            <br><br>
                            <h1>OUR VALUES</h1>
                            <p style="font-size: 24px; text-align: center; margin-inline-start: 100px; margin-inline-end: 100px;">Integrity, inclusiveness, and excellence are the cornerstones of our values. We believe that all of our endeavors should be transparent and accountable in order to achieve success. <br><br>

We value diversity and inclusion in the workplace, and we recognize the strength that originates from being open to different perspectives and experiences. <br><br>

We strive for excellence in everything we do, continuously seeking ways to improve and innovate to better serve our students and communities.</p>
                                <button onclick="togglePopup3()" class="view-btn" style="position:absolute; bottom: 100px; left: 500px">Back</button>
                            </div>
                    </div>
                    <button onclick="togglePopup3()" class="view-btn">view</button>
                    
                    </div>

                </div>
            </div>
                <div class="col-sm-1" style="width: 250px;">

                </div>
            </div>
        </div>
        <!-- about us row       -------------------------->
        <div class="row about-us" id="ABOUTS">
            <div class="col-sm-12" >
                <div class="row content-about-us">
                    <div class="col-sm-1" style="width: 250px;">
                    </div>
                    <div class="col-sm-5 col-md-5 content-about" >
                        <p class="h-about">ABOUT US</p>
                        <br><br>
                        <P class="about-description">We are dedicated to breaking down barriers to education and fostering the next generation of leaders. Founded with a passion for empowering students, our platform connects deserving individuals with life-changing scholarship opportunities.</P>
                        <br><br><br><br>
                        <a href="AboutUs.php"><button class="view-btn learn-btn" >Learn More</button></a>
                    </div>
                    <div class="col-sm-5 col-md-5 content-about" >
                        <img class="about-image" src="aboutus.png" alt="">
                    </div>
                    <div class="col-sm-1" style="width: 250px;">
                    </div>
                </div>
            </div>
        </div>
        <!-- FAQ row --------------------------------->
        <div class="row faq" id="FAQ">
                <div class="row content-faq">
                    <div class="col-sm-12 faq-h">
                        <p class="h2">FAQ</p>
                        <p class="h3">Frequently Asked Questions</p>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-8">
                             <p class="h3">General</p>
                             <br>
                            <div class="faq-dropdown">
                                <div class="question-faq">
                                    <h3>How do I apply for scholarships through your platform?</h3> <img src="dropdown.png" class="drowpdown-icon" alt="">
                                </div>
                                <div class="answer-faq">
                                    <p>To apply for scholarships through our platform, you can create an account and complete the online application form. Be sure to review the eligibility criteria for each scholarship opportunity and gather all required documents before submitting your application.</p>
                                </div>
                            </div>
                            <div class="faq-dropdown">
                                <div class="question-faq">
                                    <h3>What types of scholarships are available through your platform? </h3><img src="dropdown.png" class="drowpdown-icon" alt="" >
                                </div>
                                <div class="answer-faq">
                                    <p>Our platform offers a variety of scholarship opportunities, including merit-based scholarships, need-based scholarships, Provincial and City/Municipal Scholarships, and CHED Scholarship. Each scholarship opportunity has its own eligibility criteria, requirements, and application process.</p>
                                </div>
                            </div>
                            <div class="faq-dropdown">
                                <div class="question-faq">
                                    <h3>Can I apply for multiple scholarships simultaneously? </h3><img src="dropdown.png" class="drowpdown-icon" alt="" >
                                </div>
                                <div class="answer-faq">
                                    <p>You can apply for multiple scholarships simultaneously through our platform. However, please ensure that you meet the eligibility criteria for each scholarship you apply for and submit separate applications for each opportunity. Keep in mind that you may need to provide different documents or information for each application.</p>
                                </div>
                            </div>
                            <?php
                            // Database connection
                            $host = 'localhost';
                            $dbname = 'db_scholarship_system';
                            $username = 'root';
                            $password = '';

                            try {
                                $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                // Query to fetch FAQs
                                $query = "SELECT question, answer FROM tbl_faq";
                                $stmt = $pdo->query($query);

                                // Fetch all FAQs
                                $faqs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            } catch (PDOException $e) {
                                die("Error: " . $e->getMessage());
                            }
                            ?>
                            <!-- Display FAQs from database -->
                            <?php foreach ($faqs as $faq): ?>
                                <div class="faq-dropdown">
                                    <div class="question-faq">
                                        <h3><?php echo htmlspecialchars($faq['question']); ?></h3>
                                        <img src="dropdown.png" class="drowpdown-icon" alt="">
                                    </div>
                                    <div class="answer-faq">
                                        <p><?php echo htmlspecialchars($faq['answer']); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="col-sm-2">
                        </div>
                    </div>
                </div>
        </div>
        <!-- contact us row -------------------------------->
        <div class="row contact" id="CONTACTUS">
            <div class="col-sm-12 contact-us" >
                <div class="row">
                    <div class="col-sm-1">

                    </div>
                    <div class="col-sm-5">
                        <p class="contact-h">Contact Us</p>
                        <p>123 Cabuco  Street,Bacoor Cavite, CA 94158 </p>
                        <br>
                        <p>scholarms@gmail.com</p>
                        <p>851-7781</p>
                    </div>
                    <div class="col-sm-2">

                    </div>
                    <div class="col-sm-4">
                        <p class="contact-h">Socials</p>
                        <a href="#"><p><div class='bx bxl-facebook-circle' style="font-size: 20px; margin-right: 10px;"></div>facebook.com/scholarsm</p></a>
                        <a href="#"><p><div class='bx bxl-instagram-alt' style="font-size: 20px; margin-right: 10px;" ></div>instagram.com/scholarsm</p></a>
                        <a href="#"><p><div class='bx bxl-twitter' style="font-size: 20px; margin-right: 10px;" ></div>twitter.com/scholarsm</p></a>
                        <a href="#"><p><div class='bx bxl-youtube' style="font-size: 20px; margin-right: 10px;"></div>youtube.com/@scholarsm</p></a>
                    </div>
                    <div class="col-sm-12" align="center">
                            <p>© 2024 Scholarship System | All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
</body>
    <!-- javascript  -->
    <script src="bootstrap.bundle.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script>
        const faqs = document.querySelectorAll(".faq-dropdown");
        faqs.forEach(faq =>{
            faq.addEventListener("click", ()=>{
                faq.classList.toggle("focus");
            })
        })

        function togglePopup1(){
            document.getElementById("popup-1").classList.toggle("focus");
        }
        function togglePopup2(){
            document.getElementById("popup-2").classList.toggle("focus");
        }
        function togglePopup3(){
            document.getElementById("popup-3").classList.toggle("focus");
        }
    </script>
</html>
