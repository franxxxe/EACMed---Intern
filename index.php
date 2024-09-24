<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script defer type="text/javascript" src="./Assets/JS_Public.js?ver=<?php echo time(); ?>"></script>
  <script defer type="text/javascript" src="./Assets/JS_Index.js?ver=<?php echo time(); ?>"></script>
  <link href = "./Assets/Images/EACMC_LOGO1.png" rel="icon" type="image/png">
  <link rel="stylesheet" href="./Assets/CSS_Public.css">
  <link rel="stylesheet" href="./Assets/CSS_Index.css">
  <title>EACMed - Intern DTR</title>
</head>
<body>

  <div class="index-root">
    <!-- HEADER -->
      <div class="header-root">
        <div class="logo-div">
          <img src="./Assets/Images/EACMC_LOGO2.png" alt="">
        </div>
        <div class="nav-div">
          <ul>
            <li onclick="navigate('home')">Home</li>
            <li onclick="navigate('intern')">Intern</li>
            <li onclick="navigate('immersion')">Immersion</li>
            <li onclick="navigate('admin')">Admin</li>
          </ul>
        </div>
        <div class="right-div">
          <div class="right-child">
            <button class="StudentSignIn-Link">Login</button>
            <!-- <button>Sign up</button> -->
            <div class="theme-div">
              <div class="mode-div">
                <?php include "./Assets/SVG/dark_mode.svg"?>
                <?php include "./Assets/SVG/light_mode.svg"?>
              </div>
            </div>
          </div>
        </div>
      </div>
    <!-- END -->

    <div class="main-root">
      <!-- MAIN CHILD -->
        <div class="main-child main-parent">
          <!-- HOME PAGE -->
            <div class="home-panel main-child-home">
              <!-- WELCOME DIV -->
                <div class="welcome-div">
                  <div class="welcome-div-child">
                    <img src="./Assets/Images/EACMC_LOGO1.png" alt="">
                    <h1>Welcome intern/immersion student!</h1>
                    <div class="loading-container">
                      <div class="dot"></div>
                      <div class="dot"></div>
                      <div class="dot"></div>
                    </div>

                  </div> 
                </div>
              <!-- END -->

              <!-- DIVIDER -->
                <div class="divider1"></div>
              <!-- END -->

              <!-- BANNER -->
                <div class="banner">
                  <div class="banner-overlay"></div>
                  <div class="banner-child">
                    <div class="banner-p">
                      <h1>EAC Medical Center - Internship</h1>
                      <p>Welcome to EACMed, where your journey towards excellence begins! We're thrilled to have you join our family, a community dedicated to nurturing your potential and guiding you on the path to success. At EACMed, we offer not just education but an experience that shapes future leaders. Let's grow, learn, and achieve greatness together!</p>
                      <br>
                      <button>Read More</button>
                    </div>
                    <div class="banner-total-div">
                      <div class="box">
                        <p>Total Intern</p>
                        <div class="box-child">
                          <?php include "./Assets/SVG/users-solid.svg"?>
                          <h1 id="totalIntern">89</h1>
                        </div>
                      </div>
                      <div class="box">
                        <p>Active Intern</p>
                        <div class="box-child">
                          <?php include "./Assets/SVG/user-ninja-solid.svg"?>
                          <h1 id="activeIntern">11</h1>
                        </div>
                      </div>
                    </div>
                    <!-- <h1 class="banner-title">EAC Medical Center - Internship</h1> -->
                  </div>
                </div>
              <!-- END -->

              <!-- DIVIDER -->
                <div class="divider1">
                  
                </div>
              <!-- END -->

              <!-- GALLERY -->
                <div class="gallery">
                  <div class="gallery-child">
                    gallery
                    <div class="gallery-pic-div-overlay">
                      <div class="gallery-pic-div scroll-container">
                        <div class="box-card"><img src="./Uploaded/gallery_1.png" alt=""></div>
                        <div class="box-card"><img src="./Uploaded/gallery_2.png" alt=""></div>
                        <div class="box-card"><img src="./Uploaded/gallery_3.png" alt=""></div>
                        <div class="box-card"><img src="./Uploaded/gallery_4.png" alt=""></div>
                        <div class="box-card"><img src="./Uploaded/gallery_5.png" alt=""></div>
                        <div class="box-card"><img src="./Uploaded/gallery_6.png" alt=""></div>
                        <div class="box-card"><img src="./Uploaded/gallery_7.png" alt=""></div>
                        <div class="box-card"><img src="./Uploaded/gallery_8.png" alt=""></div>
                        <div class="box-card"><img src="./Uploaded/gallery_9.png" alt=""></div>
                        <div class="box-card"><img src="./Uploaded/gallery_10.png" alt=""></div>
                      </div>
                    </div>
                    <div class="gallery-buttons">
                      <button id="prev">prev</button>
                      <button id="next">next</button>
                    </div>
                  </div>
                </div>
              <!-- END -->

              <!-- TESTIMONIALS -->
                <div class="testimonial">
                  <div class="testimonial-child">
                    testimonial
                    <input type="text">
                  </div>
                </div>
              <!-- END -->
            </div>
          <!-- END -->

          <!-- INTERN -->
            <div class="intern-panel main-child-intern">
              <div class="intern-div">
                <div class="intern-div-header">
                  <h2>Intern Students</h2>
                  <div class="input-div">
                    <input type="text" placeholder="Search">
                    <div class="input-div-icon">
                      <?php include "./Assets/SVG/search.svg"?>
                    </div>
                  </div>
                </div>
                <br>
                <div class="table-navigation">
                  <ul>
                    <li onclick="tableNav(1)" class="nav-li nav-active1 nav-add-class1">Active Intern</li>
                    <li onclick="tableNav(2)" class="nav-li nav-active2 nav-add-class2">Former Intern</li>
                  </ul>
                </div>
                <div class="intern-table-div">
                  <div class="intern-table-child active-table1">
                    <table class="intern-table">
                      <thead>
                        <tr>
                          <th>Student Name</th>
                          <th>School Name</th>
                          <th>Course</th>
                          <th>Total Hours</th>
                          <th>Day/s Remaining</th>
                          <th>Training Hours</th>
                        </tr> 
                      </thead>
                      <tbody class="intern-tbody">
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        
                      </tbody>
                    </table>
                  </div>
                  <div class="intern-table-child active-table2">
                    <table class="intern-table">
                      <thead>
                        <tr>
                          <th>Student Name</th>
                          <th>School Name</th>
                          <th>Course</th>
                          <th>Total Hours</th>
                          <th>Day/s Remaining</th>
                          <th>Training Hours</th>
                        </tr> 
                      </thead>
                      <tbody class="intern-tbody">
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <!-- END -->

          <!-- IMMERSION -->
           <div class="immersion-panel main-child-immersion">
              <div class="intern-div">
                <div class="intern-div-header">
                  <h2>Immersion</h2>
                  <div class="input-div">
                    <input type="text" placeholder="Search">
                    <div class="input-div-icon">
                      <?php include "./Assets/SVG/search.svg"?>
                    </div>
                  </div>
                </div>
                <br>
                <div class="table-navigation">
                  <ul>
                    <li onclick="tableNav(3)" class="nav-li nav-active3 nav-add-class1">Active Students</li>
                    <li onclick="tableNav(4)" class="nav-li nav-active4 nav-add-class2">Former Students</li>
                  </ul>
                </div>
                <div class="intern-table-div">
                  <div class="intern-table-child active-table3">
                    <table class="intern-table">
                      <thead>
                        <tr>
                          <th>Student Name</th>
                          <th>School Name</th>
                          <th>Course</th>
                          <th>Total Hours</th>
                          <th>Day/s Remaining</th>
                          <th>Training Hours</th>
                        </tr> 
                      </thead>
                      <tbody class="intern-tbody">
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        
                        
                      </tbody>
                    </table>
                  </div>
                  <div class="intern-table-child active-table4">
                    <table class="intern-table">
                      <thead>
                        <tr>
                          <th>Student Name</th>
                          <th>School Name</th>
                          <th>Course</th>
                          <th>Total Hours</th>
                          <th>Day/s Remaining</th>
                          <th>Training Hours</th>
                        </tr> 
                      </thead>
                      <tbody class="intern-tbody">
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        <tr>
                          <td>France Joshua Alfelor</td>
                          <td>National College of Science and Technology</td>
                          <td>BSIT</td>
                          <td>100</td>
                          <td>60</td>
                          <td>486</td>
                        </tr>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
           </div>
          <!-- END -->

          <!-- ADMIN -->
           <div class="admin-panel main-child-admin">
            admin
           </div>
          <!-- END -->
        </div>
      <!-- END -->
      

      <!-- FOOTER -->
        <div class="footer">
          <div class="footer-child">
            <?php include "./Components/footer.php"?>
          </div>
        </div>
      <!-- END -->
    </div>
  </div>
</body>
</html>