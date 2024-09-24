<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script defer type="text/javascript" src="../Assets/JS_Public.js"></script>
  <script defer type="text/javascript" src="../Assets/JS_Login.js"></script>
  <link href = "../Assets/Images/EACMC_LOGO1.png" rel="icon" type="image/png">
  <link rel="stylesheet" href="../Assets/CSS_Public.css">
  <link rel="stylesheet" href="../Assets/CSS_Login.css">
  <title>EACMed - Student Register</title>
</head>
<body>
  <div class="login-root">
    <form form action="" class="FormLogin" method="POST" autocomplete="off">
      <div class="form-login-div">
        <div class="form-login-div-header">
          <h2>Student Register</h2>
          <div class="theme-div">
            <div class="mode-div">
              <?php include "../Assets/SVG/dark_mode.svg"?>
              <?php include "../Assets/SVG/light_mode.svg"?>
            </div>
          </div>
        </div>
        <p>Create your account.</p>
        <br>

        <div class="student-name-div">        
          <div class="input-div">
            <div class="input-div-icon">
              <?php include "../Assets/SVG/account_circle.svg"?>
            </div>
            <input type="text" id="stdLastName" onkeyup="this.value=this.value.replace(/[^A-Za-zñ\s]/g,''); inputText('Reg-FirstName');" class="input-text input-Reg-FirstName text-trans-upp">
            <i class="input-label label-Reg-FirstName">Last Name</i>
          </div>

          <div class="input-div student-first-name-div">
            <input type="text" id="stdFirstName" onkeyup="this.value=this.value.replace(/[^A-Za-zñ\s]/g,''); inputText2('Reg-LastName')" class="input-text input-Reg-LastName text-trans-upp">
            <i class="input-label label2-Reg-LastName">First Name</i>
          </div>
        </div>
        <br>
        <div class="input-div">
          <div class="input-div-icon">
            <?php include "../Assets/SVG/gender.svg"?>
          </div>
           <select name="" id="stdGender" onchange="inputText('Reg-Gender')">
            <option value="" selected disabled></option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
           </select>
          <i class="input-label label-Reg-Gender">Gender</i>
        </div>
        <br>
        <div class="hr"></div>
        <br>
        <div class="input-div">
          <div class="input-div-icon">
            <?php include "../Assets/SVG/school.svg"?>
          </div>
          <input type="text" id="stdSchoolName" onkeyup="inputText('Reg-School')" class="input-text input-Reg-School text-trans-upp">
          <i class="input-label label-Reg-School">School</i>
        </div>
        <br>
        <div class="input-div">
          <div class="input-div-icon">
            <?php include "../Assets/SVG/book.svg"?>
          </div>
          <input type="text" id="stdCourse" onkeyup="inputText('Reg-Course')" class="input-text input-Reg-Course text-trans-upp">
          <i class="input-label label-Reg-Course">Course</i>
        </div>
        <br>
        <div class="input-div">
          <div class="input-div-icon">
            <?php include "../Assets/SVG/schedule.svg"?>
          </div>
          <input type="number" id="stdTrainingHours" onkeyup="inputText('Reg-Training-Hours')" class="input-text input-Reg-Training-Hours text-trans-upp no-spinner" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="5">
          <i class="input-label label-Reg-Training-Hours">Training Hours</i>
        </div>
        <br>
        <div class="hr"></div>
        <br>
        <div class="input-div">
          <div class="input-div-icon">
            <?php include "../Assets/SVG/badge.svg"?>
          </div>
          <input type="text" id="stdUsername" onkeyup="inputText('RegUsername'); userNameValidation('username')" class="input-text input-RegUsername">
          <i class="input-label label-RegUsername">Username</i>
        </div>
        <br>
        <div class="input-div">
          <div class="input-div-icon">
            <?php include "../Assets/SVG/password.svg"?>
          </div>
          <input type="password" id="stdPassword" onkeyup="inputText('LoginPassword')" class="input-text input-LoginPassword passwordInput">
          <i class="input-label label-LoginPassword">Password</i>
        </div>
        <div class="show-pass-div">
          <input type="checkbox" id="myCheckbox">
          <label for="myCheckbox">Show password</label>
        </div>
        <div class="error-message-div">
          <div class="error-message-div-child">
            <div class="">
              <div class="svg-check"><?php include "../Assets/SVG/task_alt_check.svg"?></div>
              <div class="svg-error"><?php include "../Assets/SVG/error.svg"?></div>
            </div>
            <p id="error-p-message">Username already used</p>
          </div>
        </div>
        <button type="button" id="register">Sign Up</button>
        <!-- <button type="button" class="register-link">Sign Up</button> -->

      
        
        <br>
        <p>Don’t have an account? <span class="sign-link sign-in-link">Sign In Here</span></p>
      </div>
    </form>

  </div>
  <?php include "../Components/Prompt_Message.php"?>
</body>
</html>