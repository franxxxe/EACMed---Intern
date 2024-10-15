<?php
  session_start();
  include "../Config/Configure.php";
  if (isset($_SESSION['AdminSessionID'])) {
    $user_id = $_SESSION['AdminSessionID'];
    // ENCRYPT ID
    function encrypt_user_id($user_id) {
      $encryption_key = 'your-encryption-key';
      $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
      $encrypted_user_id = openssl_encrypt($user_id, 'aes-256-cbc', $encryption_key, 0, $iv);
      return base64_encode($encrypted_user_id . '::' . $iv);
    }
    // DECRYPT ID
    function decrypt_user_id($encrypted_data) {
      $encryption_key = 'your-encryption-key';
      list($encrypted_user_id, $iv) = explode('::', base64_decode($encrypted_data), 2);
      return openssl_decrypt($encrypted_user_id, 'aes-256-cbc', $encryption_key, 0, $iv);
    }
    $encrypted_user_id = encrypt_user_id($user_id);
    $decrypted_user_id = decrypt_user_id($encrypted_user_id);

    // echo $encrypted_user_id;
    // FETCH STUDENT
    $FetchStudent = "SELECT * FROM admin_tb WHERE admin_eac_id = '$decrypted_user_id' ";
    $FetchStudent = mysqli_query($connMysqli, $FetchStudent);
    if ($FetchStudent->num_rows > 0) {
      while ($rowTotal = $FetchStudent->fetch_assoc()) {
        // $TrainingHours = $rowTotal['student_training_hrs'];
      }
    };
  }else{
    header('Location: ../Admin Login');
    exit();
  }


  // // FETCH RENDERED HOURS
  // $FetchTotalHours = "SELECT * FROM attendance_tb WHERE attendance_student_id = '$decrypted_user_id' AND attendance_status = 'Approved'";
  // $FetchTotalHours = mysqli_query($connMysqli, $FetchTotalHours);
  // $dataArray = [];
  // $TotalRenderedDuration = "0hrs 0min";
  // if ($FetchTotalHours->num_rows > 0) {
  //   while ($rowTotal = $FetchTotalHours->fetch_assoc()) {
  //     $dataArray[] = $rowTotal['attendance_rendered'];
  //     $totalMinutes = 0;

  //     foreach ($dataArray as $duration) {
  //       preg_match('/(\d+)hrs (\d+)min/', $duration, $matches);
  //       $hours = (int)$matches[1];
  //       $minutes = (int)$matches[2];
  //       $totalMinutes += ($hours * 60) + $minutes;
  //     }
  //     $totalHours = floor($totalMinutes / 60);
  //     $remainingMinutes = $totalMinutes % 60;
  //   }
  //   $TotalRenderedDuration = $totalHours . "hrs " . $remainingMinutes . "min";
  // };


  // // FETCH PENDING HOURS
  // $FetchPendingHours = "SELECT * FROM attendance_tb WHERE attendance_student_id = '$decrypted_user_id' AND attendance_status = 'Pending'";
  // $FetchPendingHours = mysqli_query($connMysqli, $FetchPendingHours);
  // $pendingArray = [];
  // $TotalPendingDuration = "0hrs 0min";
  // $PendingHrs = "0hrs 0min";
  // if ($FetchPendingHours->num_rows > 0) {
  //   while ($rowTotal = $FetchPendingHours->fetch_assoc()) {
  //     $pendingArray[] = $rowTotal['attendance_total'];
  //     $totalMinutes = 0;

  //     foreach ($pendingArray as $duration) {
  //       preg_match('/(\d+)hrs (\d+)min/', $duration, $matches);
  //       $hours = (int)$matches[1];
  //       $minutes = (int)$matches[2];
  //       $totalMinutes += ($hours * 60) + $minutes;
  //     }
  //     $totalHours = floor($totalMinutes / 60);
  //     $remainingMinutes = $totalMinutes % 60;
  //   }
  //   $TotalPendingDuration = $totalHours . "hrs " . $remainingMinutes . "min";
  //   $PendingHrs = $totalHours . "hrs " . $remainingMinutes . "min";
  // };


  // // FETCH TENTATIVE HOURS
  // $FetchTentativeHours = "SELECT * FROM attendance_tb WHERE attendance_student_id = '$decrypted_user_id' ";
  // $FetchTentativeHours = mysqli_query($connMysqli, $FetchTentativeHours);
  // $tentativeArray = [];
  // $TotalTentativeDuration = "0hrs 0min";
  // if($TotalPendingDuration == "0hrs 0min"){
  //   $TotalTentativeDuration = "0hrs 0min";
  // }
  // else{
  //   if ($FetchTentativeHours->num_rows > 0) {
  //     while ($rowTotal = $FetchTentativeHours->fetch_assoc()) {
  //       $tentativeArray[] = $rowTotal['attendance_total'];
  //       $totalMinutes = 0;
  
  //       foreach ($tentativeArray as $duration) {
  //         preg_match('/(\d+)hrs (\d+)min/', $duration, $matches);
  //         $hours = (int)$matches[1];
  //         $minutes = (int)$matches[2];
  //         $totalMinutes += ($hours * 60) + $minutes;
  //       }
  //       $totalHours = floor($totalMinutes / 60);
  //       $remainingMinutes = $totalMinutes % 60;
  //     }
  //     $TotalTentativeDuration = $totalHours . "hrs " . $remainingMinutes . "min";
  //   };
  // }


  // // CALCULATE REMAINING HOURS
  // function convertToMinutes($time) {
  //   preg_match('/(\d+)hrs\s*(\d+)min/', $time, $matches);
  //   return $matches[1] * 60 + $matches[2];
  // }

  // function formatDuration($totalMinutes) {
  //   $hours = floor($totalMinutes / 60);
  //   $minutes = $totalMinutes % 60;
  //   return "{$hours}hrs {$minutes}min";
  // }

  // $TrainingHoursConverted = $TrainingHours . "hrs 0min";
  // $TrainingHoursInMinutes = convertToMinutes($TrainingHoursConverted);
  // $TrainingHoursInMinutes1 = convertToMinutes($TrainingHoursConverted);
  // $PendingHrsInMinutes = convertToMinutes($TotalPendingDuration);
  // $TentativeHrsInMinutes = convertToMinutes($TotalTentativeDuration);
  // $RenderedHrsInMinutes = convertToMinutes($TotalRenderedDuration);

  // $CalcPending = $TrainingHoursInMinutes1 - $PendingHrsInMinutes;
  // $CalcTentative = $TrainingHoursInMinutes1 - $TentativeHrsInMinutes;
  // $CalcRendered = $TrainingHoursInMinutes - $RenderedHrsInMinutes;
  // $CalcRendered2 = $PendingHrsInMinutes - 480 ;

  // $RemainingHrsPending = formatDuration($CalcPending);
  // $RemainingHrsTentative = formatDuration($CalcTentative);
  // $RemainingHrsRendered = formatDuration($CalcRendered);

  // // CALCULATE REMAINING DAYS
  // $PendingRemainingDays = ceil(($CalcPending / 60) / 8) . "Day/s";
  // $TentativeRemainingDays = ceil(($CalcTentative / 60) /8) . "Day/s";
  // $RenderedRemainingDays = ceil(($CalcRendered / 60) / 8) . "Day/s";

  // // COUNT DAYS TENTATIVE
  // $CountDayTentative = mysqli_query($connMysqli, "SELECT * FROM attendance_tb WHERE attendance_student_id = '$decrypted_user_id' ");
  // $CountDayTentative = mysqli_num_rows($CountDayTentative);

  // // COUNT DAYS RENDERED
  // $CountDayRendered = mysqli_query($connMysqli, "SELECT * FROM attendance_tb WHERE attendance_student_id = '$decrypted_user_id' AND attendance_status = 'Approved' ");
  // $CountDayRendered = mysqli_num_rows($CountDayRendered);

  // // COUNT DAYS PENDING
  // $CountDayPending = mysqli_query($connMysqli, "SELECT * FROM attendance_tb WHERE attendance_student_id = '$decrypted_user_id' AND attendance_status = 'Pending' ");
  // $CountDayPending = mysqli_num_rows($CountDayPending);

  // // COUNT LATE
  // $CountDayLate = mysqli_query($connMysqli, "SELECT * FROM attendance_tb WHERE attendance_student_id = '$decrypted_user_id' AND attendance_status = 'Pending' ");
  // $CountDayLate = mysqli_num_rows($CountDayLate);

  // if($PendingHrsInMinutes == 0){
  //   $TrainingHoursInMinutes1 = 0;
  //   $TentativeHrsInMinutes = 0;
  //   $CountDayTentative = 0;
  //   $RemainingHrsPending = "0hrs 0min";
  //   $RemainingHrsTentative = "0hrs 0min";
  //   $PendingRemainingDays = "0Day/s";
  //   $TentativeRemainingDays = "0Day/s";
  // }

  // if($PendingHrsInMinutes > $CalcRendered2 && $PendingHrsInMinutes < $CalcRendered){
  //   $PendingRemainingDays = "Last Day";
  //   $TentativeRemainingDays = "Last Day";
  //   $RemainingHrsPending = "Last Day";
  //   $RemainingHrsTentative = "Last Day";

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script defer type="text/javascript" src="../Assets/JS_Public.js?ver=<?php echo time(); ?>"></script>
  <script defer type="text/javascript" src="../Assets/JS_Admin.js?ver=<?php echo time(); ?>"></script>
  <link href = "../Assets/Images/EACMC_LOGO1.png" rel="icon" type="image/png">
  <link rel="stylesheet" href="../Assets/CSS_Public.css">
  <link rel="stylesheet" href="../Assets/CSS_Admin.css">
  <title>EACMed - Admin Page</title>
</head>
<body>

  <div class="admin-root">
    <div class="admin-flex">
      <div class="admin-sidebar">
        <div class="sidebar-header">
          header
        </div>
        <div class="sidebar-middle">
          <div class="sidebar-content">
            <ul>
              <li onclick="liActive('sidebar',1)" class="sideLi1 li-active"><i><?php include "../Assets/SVG/dashboard.svg"?></i> <p>Dashboard</p></li>
              <li onclick="liActive('sidebar',2)" class="sideLi2 li-inactive"><i><?php include "../Assets/SVG/admin_user.svg"?></i> <p>Admin</p></li>
              <li onclick="liActive('sidebar',3)" class="sideLi3 li-inactive"><i><?php include "../Assets/SVG/group_student.svg"?></i> <p>Student</p></li>
              <li onclick="liActive('sidebar',4)" class="sideLi4 li-inactive"><i><?php include "../Assets/SVG/image.svg"?></i> <p>Gallery</p></li>
              <li onclick="liActive('sidebar',5)" class="sideLi5 li-inactive"><i><?php include "../Assets/SVG/newspaper.svg"?></i> <p>Testimonies</p></li>
            </ul>
          </div>
        </div>
        <div class="sidebar-bottom">
          <button>Logout</button>
          <div class="theme-div">
            <div class="mode-div">
              <?php include "../Assets/SVG/dark_mode.svg"?>
              <?php include "../Assets/SVG/light_mode.svg"?>
            </div>
          </div>
        </div>
      </div>
      <div class="admin-main">
        <div class="admin-content">
          <?php include "../Components/Admin-Dasboard.php"?>
          <!-- <?php include "../Components/Admin-Management.php"?>
          <?php include "../Components/Admin-Student.php"?>
          <?php include "../Components/Admin-Gallery.php"?>
          <?php include "../Components/Admin-Testimonies.php"?> -->
        </div>
      </div>

    </div>
  </div>

  <script>var AdminID = '<?= $encrypted_user_id ?>';</script>
</body>
</html>