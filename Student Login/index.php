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

    <form action="" class="FormLogin" method="POST" autocomplete="off">
      <div class="form-login-div">
        <h2>Student Login</h2>
        <p>Login to access your student account.</p>
        <br>

        <div class="input-div">
          <div class="input-div-icon">
            <?php include "../Assets/SVG/account_circle.svg"?>
          </div>
          <input type="text" placeholder="Username">
        </div>
        <br>
        <div class="input-div">
          <div class="input-div-icon">
            <?php include "../Assets/SVG/key.svg"?>
          </div>
          <input type="password" id="passwordInput" placeholder="Password">
        </div>
        <div class="show-pass-div">
          <input type="checkbox" id="myCheckbox">
          <label for="myCheckbox">Show password</label>
        </div>
        <br>
        <button>Login</button>
      </div>
    </form>

  </div>
</body>
</html>