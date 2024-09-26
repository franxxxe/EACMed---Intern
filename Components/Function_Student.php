<?php
session_start();
include '../Config/Configure.php';
date_default_timezone_set("Asia/Manila");
$Date = date("Y-m-d");
$DateID = date("Y-m-d");
$Time = date("h:i:sa");
$Day = date('l');

// JSON ERROR LOGS
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// DECRYPT ID
function decrypt_user_id($encrypted_data) {
  $encryption_key = 'your-encryption-key';
  list($encrypted_user_id, $iv) = explode('::', base64_decode($encrypted_data), 2);
  return openssl_decrypt($encrypted_user_id, 'aes-256-cbc', $encryption_key, 0, $iv);
}

// STUDENT LOGIN
if (isset($_POST["usernameLogin"])) {
  global $connMysqli, $connPDO;
  $username = trim(htmlspecialchars($_POST['usernameLogin']));
  $password = trim($_POST['passwordLogin']);

  if (!empty($username) && !empty($password)) {
    $stmt = $connMysqli->prepare("SELECT student_eac_id, student_password FROM student_tb WHERE student_username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $hashed_password = $row['student_password'];
      $student_eac_id = $row['student_eac_id'];

      if (password_verify($password, $hashed_password)) {
        echo json_encode(array("success" => true, "message" => "Login Successfully"));
        $_SESSION['StudentSessionID'] = $student_eac_id;

      } else {
        echo json_encode(array("success" => false, "message" => "Login Failed"));
      }
    } else {
      echo json_encode(array("success" => false, "message" => "Login Failed"));
    }
    $stmt->close();
  } else {
    echo json_encode(array("success" => false, "message" => "All fields are required."));
  }
}

// REGISTER NEW STUDENT
if (isset($_POST["username"])) {
  global $connMysqli, $connPDO;

  $username = trim(htmlspecialchars($_POST['username']));
  $password = trim($_POST['password']);
  $stdLastName = trim(htmlspecialchars($_POST['stdLastName']));
  $stdFirstName = trim(htmlspecialchars($_POST['stdFirstName']));
  $stdGender = trim(htmlspecialchars($_POST['stdGender']));
  $stdSchoolName = trim(htmlspecialchars($_POST['stdSchoolName']));
  $stdCourse = trim(htmlspecialchars($_POST['stdCourse']));
  $stdTrainingHours = (int)$_POST['stdTrainingHours'];

  $randomNumber = mt_rand(100000, 999999);
  $stdEACId = $DateID . $randomNumber;

  if (!empty($username) && !empty($password) && !empty($stdLastName) && !empty($stdFirstName) && !empty($stdGender) && !empty($stdSchoolName) && !empty($stdCourse) && !empty($stdTrainingHours)) {
    $stmt = $connMysqli->prepare("SELECT * FROM student_tb WHERE student_username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      echo json_encode(array("success" => false, "message" => "Username Exists"));
    } else {
      $hashed_password = password_hash($password, PASSWORD_BCRYPT);
      try {
        $InsertStudent = $connPDO->prepare("INSERT INTO student_tb (student_eac_id, student_firstname, student_lastname, student_gender, student_course, student_school, student_training_hrs, student_username, student_password) VALUES (?,?,?,?,?,?,?,?,?)");
        $InsertStudent->execute([$stdEACId, $stdFirstName, $stdLastName, $stdGender, $stdCourse, $stdSchoolName, $stdTrainingHours, $username, $hashed_password]);
        $_SESSION['StudentSessionID'] = $stdEACId;
        echo json_encode(array("success" => true, "message" => "Account Successfully Registered"));

      } catch (PDOException $e) {
        echo json_encode(array("success" => false, "message" => "An error occurred. Please try again later."));
        error_log("Database error: " . $e->getMessage());
      }
    }
    
    $stmt->close();
  }
  else{
    echo json_encode(array("success" => false, "message" => "All fields are required."));
  }
}

// USERNAME VALIDATION EXIST
if (isset($_POST["validateUsername"])) {
  global $connMysqli;
  $username = $_POST['validateUsername'];
  
  if (empty($username)) {
      echo json_encode(array("success" => true, "message" => "Empty"));
  } else {
      $stmt = $connMysqli->prepare("SELECT * FROM student_tb WHERE student_username = ?");
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $stmt->store_result();
      
      if ($stmt->num_rows > 0) {
          echo json_encode(array("success" => false, "message" => "Not Available"));
      } else {
          echo json_encode(array("success" => true, "message" => "Available"));
      }
      $stmt->close();
  }
}





// CHECKING VIEW ID
if (isset($_POST["viewID"])) {
  $encrypted_user_id = $_POST['StudentID'];
  $decrypted_user_id = decrypt_user_id($encrypted_user_id);
  echo "Decrypted User ID: " . $decrypted_user_id;
}


// INSERT PENDING ATTENDANCE
if (isset($_POST["submitAttendanceType"])) {
  global $connPDO;
  
  $attendance_timein = $_POST["submitTimeIn"];
  $attendance_timeout = $_POST["submitTimeOut"];
  $Date = $_POST["submitDate"];
  $encrypted_user_id = $_POST["StudentID"];
  $decrypted_user_id = decrypt_user_id($encrypted_user_id);
  $attendance_note = $_POST["stdNote"];

  // Validate and sanitize input
  if (!empty($attendance_timein) && !empty($attendance_timeout) && !empty($Date)) {
      $timeInObj = new DateTime($attendance_timein);
      $timeOutObj = new DateTime($attendance_timeout);

      // Calculate the difference
      $interval = $timeOutObj->diff($timeInObj);
      if ($timeInObj > $timeOutObj) {
        // echo "Warning: Invalid because your time in is later than your time out.";
        echo json_encode(array("success" => true, "message" => "Warning: Invalid because your time in is later than your time out."));
        // exit;
      }

      $hours = $interval->h - 1;
      $minutes = $interval->i;
      $attendance_total = $hours . "hrs " . $minutes . "min";
      $dateObj = new DateTime($Date);
      $attendance_date = $dateObj->format('F j, Y');
      $dayObj = new DateTime($Date);
      $attendance_day = $dayObj->format('l');

      $attendance_status = "Pending";


      preg_match('/(\d+)hrs (\d+)min/', $attendance_total, $matches);
      $hours = (int)$matches[1];
      $minutes = (int)$matches[2];
      // $hours -= 1;
      $isLate = "{$hours}hrs {$minutes}min";
      $rendered = "{$hours}hrs 0min";

      if($rendered < 8){
        $attendance_rendered = $isLate;
      }
      else{
        $attendance_rendered = $rendered;
      }

      if ($_POST["submitAttendanceType"] == "insert") {
        $stmt = $connMysqli->prepare("SELECT * FROM attendance_tb WHERE attendance_student_id = ? AND attendance_date = ?");
        if ($stmt === false) { die('Prepare failed: ' . htmlspecialchars($connMysqli->error));}
        $stmt->bind_param("ss", $decrypted_user_id, $attendance_date);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
          // echo "Date Existed";
          echo json_encode(array("success" => false, "message" => "Date Existed", "message2" => "2"));
        } else {
          try {
            $InsertDoctor = $connPDO->prepare("INSERT INTO `attendance_tb` (attendance_student_id, attendance_date, attendance_day, attendance_timein, attendance_timeout, attendance_total, attendance_rendered, attendance_note, attendance_status) VALUES (?,?,?,?,?,?,?,?,?)");
            $InsertDoctor->execute([$decrypted_user_id, $attendance_date, $attendance_day, $attendance_timein, $attendance_timeout, $attendance_total, $attendance_rendered, $attendance_note, $attendance_status]);
            // echo "<p>Total: " .$ attendance_total."</p> <p>Attendance recorded successfully.</p>";
            echo json_encode(array(
              "success" => true, 
              "message" => "<p>Total: " .$attendance_total."</p> <p>Attendance recorded successfully.</p>",
              "message2" => "1"
            ));
          } 
          catch (PDOException $e) {
            // echo "Error recording attendance: " . $e->getMessage();
            echo json_encode(array("success" => false, "message" => "Error recording attendance: " . $e->getMessage()));
          }
        }
        $stmt->close();
      }
      else{
        // echo "Total: " .$attendance_total;
        
        echo json_encode(array("success" => false, "message" => "Total: " .$attendance_total));
      }
  } else {
      // echo "All fields are required.";
      echo json_encode(array("success" => false, "message" => "All fields are required."));
  }
}






?>