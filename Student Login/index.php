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
  <title>EACMed - Student Login</title>
</head>
<body>
  <div class="login-root">

    <form action="" id="StudentLoginForm" class="FormLogin" method="POST" autocomplete="off">
      <div class="form-login-div">
        <div class="form-login-div-header">
          <h2>Student Login</h2>
          <div class="theme-div">
            <div class="mode-div">
              <?php include "../Assets/SVG/dark_mode.svg"?>
              <?php include "../Assets/SVG/light_mode.svg"?>
            </div>
          </div>
        </div>
        <p>Login to access your student account.</p>
        <br>

        <div class="input-div">
          <div class="input-div-icon">
            <?php include "../Assets/SVG/account_circle.svg"?>
          </div>
          <input type="text" onkeyup="inputText('LoginUsername')" id="stdUsername" class="input-text input-LoginUsername">
          <i class="input-label label-LoginUsername">Username</i>
        </div>
        <br>
        <div class="input-div">
          <div class="input-div-icon">
            <?php include "../Assets/SVG/key.svg"?>
          </div>
          <input type="password" onkeyup="inputText('LoginPassword')" class="input-text input-LoginPassword passwordInput" id="stdPassword">
          <i class="input-label label-LoginPassword">Password</i>
        </div>
        <div class="show-pass-div">
          <input type="checkbox" id="myCheckbox">
          <label for="myCheckbox">Show password</label>
        </div>
        <div class="error-message-div">
          <div class=" error-message-div-child">
            <?php include "../Assets/SVG/error.svg"?>
            <p>Incorrect Username or Password!</p>
          </div>
        </div>
        <button type="button" id="login">Login</button>
        <!-- <button type="submit" class="login-link">Login</button> -->


      
        
        <br>
        <p>Don’t have an account? <span class="sign-link sign-up-link">Sign Up Here</span></p>
      </div>
    </form>

  </div>
  <?php include "../Components/Prompt_Message.php"?>
</body>
</html>