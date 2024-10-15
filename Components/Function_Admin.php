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

// ADMIN LOGIN
if (isset($_POST["usernameLogin"])) {
  global $connMysqli, $connPDO;
  $username = trim(htmlspecialchars($_POST['usernameLogin']));
  $password = trim($_POST['passwordLogin']);

  if (!empty($username) && !empty($password)) {
    $stmt = $connMysqli->prepare("SELECT admin_eac_id, admin_password FROM admin_tb WHERE admin_username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $hashed_password = $row['admin_password'];
      $admin_eac_id = $row['admin_eac_id'];

      if (password_verify($password, $hashed_password)) {
        echo json_encode(array("success" => true, "message" => "Login Successfully"));
        $_SESSION['AdminSessionID'] = $admin_eac_id;

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








// $page = $_GET['page'] ?? 'home'; // Default to home page

// switch ($page) {
//     case 'admin':
//         include 'admin.php';
//         break;
//     case 'student':
//         include 'student.php';
//         break;
//     case 'home':
//     default:
//         include 'home.php';
//         break;
// }
?>