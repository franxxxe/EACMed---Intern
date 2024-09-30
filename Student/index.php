<?php
  session_start();
  include "../Config/Configure.php";
  if (isset($_SESSION['StudentSessionID'])) {
    $user_id = $_SESSION['StudentSessionID'];
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

    // FETCH STUDENT
    $FetchStudent = "SELECT * FROM student_tb WHERE student_eac_id = '$decrypted_user_id' ";
    $FetchStudent = mysqli_query($connMysqli, $FetchStudent);
    if ($FetchStudent->num_rows > 0) {
      while ($rowTotal = $FetchStudent->fetch_assoc()) {
        $TrainingHours = $rowTotal['student_training_hrs'];
      }
    };
  }else{
    header('Location: ../Student Login');
    exit();
  }


  // FETCH RENDERED HOURS
  $FetchTotalHours = "SELECT * FROM attendance_tb WHERE attendance_student_id = '$decrypted_user_id' AND attendance_status = 'Approved'";
  $FetchTotalHours = mysqli_query($connMysqli, $FetchTotalHours);
  $dataArray = [];
  $TotalRenderedDuration = "0hrs 0min";
  if ($FetchTotalHours->num_rows > 0) {
    while ($rowTotal = $FetchTotalHours->fetch_assoc()) {
      $dataArray[] = $rowTotal['attendance_rendered'];
      $totalMinutes = 0;

      foreach ($dataArray as $duration) {
        preg_match('/(\d+)hrs (\d+)min/', $duration, $matches);
        $hours = (int)$matches[1];
        $minutes = (int)$matches[2];
        $totalMinutes += ($hours * 60) + $minutes;
      }
      $totalHours = floor($totalMinutes / 60);
      $remainingMinutes = $totalMinutes % 60;
    }
    $TotalRenderedDuration = $totalHours . "hrs " . $remainingMinutes . "min";
  };


  // FETCH PENDING HOURS
  $FetchPendingHours = "SELECT * FROM attendance_tb WHERE attendance_student_id = '$decrypted_user_id' AND attendance_status = 'Pending'";
  $FetchPendingHours = mysqli_query($connMysqli, $FetchPendingHours);
  $pendingArray = [];
  $TotalPendingDuration = "0hrs 0min";
  $PendingHrs = "0hrs 0min";
  if ($FetchPendingHours->num_rows > 0) {
    while ($rowTotal = $FetchPendingHours->fetch_assoc()) {
      $pendingArray[] = $rowTotal['attendance_total'];
      $totalMinutes = 0;

      foreach ($pendingArray as $duration) {
        preg_match('/(\d+)hrs (\d+)min/', $duration, $matches);
        $hours = (int)$matches[1];
        $minutes = (int)$matches[2];
        $totalMinutes += ($hours * 60) + $minutes;
      }
      $totalHours = floor($totalMinutes / 60);
      $remainingMinutes = $totalMinutes % 60;
    }
    $TotalPendingDuration = $totalHours . "hrs " . $remainingMinutes . "min";
    $PendingHrs = $totalHours . "hrs " . $remainingMinutes . "min";
  };


  // FETCH TENTATIVE HOURS
  $FetchTentativeHours = "SELECT * FROM attendance_tb WHERE attendance_student_id = '$decrypted_user_id' ";
  $FetchTentativeHours = mysqli_query($connMysqli, $FetchTentativeHours);
  $tentativeArray = [];
  $TotalTentativeDuration = "0hrs 0min";
  if($TotalPendingDuration == "0hrs 0min"){
    $TotalTentativeDuration = "0hrs 0min";
  }
  else{
    if ($FetchTentativeHours->num_rows > 0) {
      while ($rowTotal = $FetchTentativeHours->fetch_assoc()) {
        $tentativeArray[] = $rowTotal['attendance_total'];
        $totalMinutes = 0;
  
        foreach ($tentativeArray as $duration) {
          preg_match('/(\d+)hrs (\d+)min/', $duration, $matches);
          $hours = (int)$matches[1];
          $minutes = (int)$matches[2];
          $totalMinutes += ($hours * 60) + $minutes;
        }
        $totalHours = floor($totalMinutes / 60);
        $remainingMinutes = $totalMinutes % 60;
      }
      $TotalTentativeDuration = $totalHours . "hrs " . $remainingMinutes . "min";
    };
  }


  // CALCULATE REMAINING HOURS
  function convertToMinutes($time) {
    preg_match('/(\d+)hrs\s*(\d+)min/', $time, $matches);
    return $matches[1] * 60 + $matches[2];
  }

  function formatDuration($totalMinutes) {
    $hours = floor($totalMinutes / 60);
    $minutes = $totalMinutes % 60;
    return "{$hours}hrs {$minutes}min";
  }

  $TrainingHoursConverted = $TrainingHours . "hrs 0min";
  $TrainingHoursInMinutes = convertToMinutes($TrainingHoursConverted);
  $TrainingHoursInMinutes1 = convertToMinutes($TrainingHoursConverted);
  $PendingHrsInMinutes = convertToMinutes($TotalPendingDuration);
  $TentativeHrsInMinutes = convertToMinutes($TotalTentativeDuration);
  $RenderedHrsInMinutes = convertToMinutes($TotalRenderedDuration);

  $CalcPending = $TrainingHoursInMinutes1 - $PendingHrsInMinutes;
  $CalcTentative = $TrainingHoursInMinutes1 - $TentativeHrsInMinutes;
  $CalcRendered = $TrainingHoursInMinutes - $RenderedHrsInMinutes;
  $CalcRendered2 = $PendingHrsInMinutes - 480 ;

  $RemainingHrsPending = formatDuration($CalcPending);
  $RemainingHrsTentative = formatDuration($CalcTentative);
  $RemainingHrsRendered = formatDuration($CalcRendered);

  // CALCULATE REMAINING DAYS
  $PendingRemainingDays = ceil(($CalcPending / 60) / 8) . "Day/s";
  $TentativeRemainingDays = ceil(($CalcTentative / 60) /8) . "Day/s";
  $RenderedRemainingDays = ceil(($CalcRendered / 60) / 8) . "Day/s";

  // COUNT DAYS TENTATIVE
  $CountDayTentative = mysqli_query($connMysqli, "SELECT * FROM attendance_tb WHERE attendance_student_id = '$decrypted_user_id' ");
  $CountDayTentative = mysqli_num_rows($CountDayTentative);

  // COUNT DAYS RENDERED
  $CountDayRendered = mysqli_query($connMysqli, "SELECT * FROM attendance_tb WHERE attendance_student_id = '$decrypted_user_id' AND attendance_status = 'Approved' ");
  $CountDayRendered = mysqli_num_rows($CountDayRendered);

  // COUNT DAYS PENDING
  $CountDayPending = mysqli_query($connMysqli, "SELECT * FROM attendance_tb WHERE attendance_student_id = '$decrypted_user_id' AND attendance_status = 'Pending' ");
  $CountDayPending = mysqli_num_rows($CountDayPending);

  // COUNT LATE
  $CountDayLate = mysqli_query($connMysqli, "SELECT * FROM attendance_tb WHERE attendance_student_id = '$decrypted_user_id' AND attendance_status = 'Pending' ");
  $CountDayLate = mysqli_num_rows($CountDayLate);

  if($PendingHrsInMinutes == 0){
    $TrainingHoursInMinutes1 = 0;
    $TentativeHrsInMinutes = 0;
    $CountDayTentative = 0;
    $RemainingHrsPending = "0hrs 0min";
    $RemainingHrsTentative = "0hrs 0min";
    $PendingRemainingDays = "0Day/s";
    $TentativeRemainingDays = "0Day/s";
  }

  if($PendingHrsInMinutes > $CalcRendered2 && $PendingHrsInMinutes < $CalcRendered){
    $PendingRemainingDays = "Last Day";
    $TentativeRemainingDays = "Last Day";
    $RemainingHrsPending = "Last Day";
    $RemainingHrsTentative = "Last Day";
    // if($PendingRemainingDays != "-0"){
    //   $PendingRemainingDays = "Completed";
    //   $TentativeRemainingDays = "Completed";
    //   $RemainingHrsPending = "Completed";
    //   $RemainingHrsTentative = "Completed";
    // }
  }
  // echo $CalcRendered . " - " . $CalcRendered2 . " - ";
  // echo $PendingHrsInMinutes;

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script defer type="text/javascript" src="../Assets/JS_Public.js?ver=<?php echo time(); ?>"></script>
  <script defer type="text/javascript" src="../Assets/JS_Student.js?ver=<?php echo time(); ?>"></script>
  <link href = "../Assets/Images/EACMC_LOGO1.png" rel="icon" type="image/png">
  <link rel="stylesheet" href="../Assets/CSS_Public.css">
  <link rel="stylesheet" href="../Assets/CSS_Student.css">
  <title>EACMed - Student Page</title>
</head>
<body>
  <div class="student-root">
    <!-- HEADER -->
      <div class="header-root">
        <div class="header-overlay">
          <div class="header-div1">
            <div class="">
              <img class="header-profile-img" src="../Uploaded/gallery_10.png" alt="">
            </div>
            <div class="student-details">
              <h2>Alfelor, France Joshua</h2>
              <h4>BS - Information Technology</h4>
              <p>National College of Science and Technology</p>
            </div>
          </div>
          <div class="header-div2">
            <div class="theme-div">
              <div class="mode-div">
                <?php include "../Assets/SVG/dark_mode.svg"?>
                <?php include "../Assets/SVG/light_mode.svg"?>
              </div>
            </div>
            <ul>
              <li class="" onclick="functionCLick('Gallery')"> <p>Gallery</p></li>
              <li class="" onclick="functionCLick('Testimonies')"> <p>Testimonies</p></li>
              <li class="home-link"> <p>Home</p></li>
              <li class="logout-link"> <p>Logout</p></li>
            </ul>
            
          </div>
        </div>
        
      </div>
    <!-- END -->
    <!-- MAIN -->
      <div class="main-root"> 
        <div class="main-root-flex">
          <div class="main-child-1">
            <div class="tables-navigation">
              <div class="tables-navigation-left">
                <div class="search-div">
                  <input type="text" placeholder="Search">
                  <div class="search-icon"><?php include "../Assets/SVG/search.svg"?></div>
                </div>
              </div>
              <div class="ul-navigation">
                <ul>
                  <li onclick="tableTab(1)" class="nav-li1 active-li"> <p class="NavAttendance">Attendance (<?php echo $CountDayRendered?>)</p></li>
                  <li onclick="tableTab(2)" class="nav-li2 inactive-li"><p class="NavPending">Pending (<?php echo $CountDayPending?>)</p></li>
                </ul>
              </div>
            </div>
            <div class="table-container">
              <div class="table-1">
                <table>
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Time In</th>
                      <th>Time Out</th>
                      <!-- <th>Total Hours</th> -->
                      <th>Hour/s Rendered</th>
                      <th>Status</th>
                      <th>Remarks</th>
                    </tr>
                  </thead>
                  <tbody class="tBody-Attendance">
                    <?php
                      $FetchAttendance = "SELECT * FROM attendance_tb WHERE attendance_student_id = '$decrypted_user_id' AND attendance_status = 'Approved' ORDER BY attendance_id  DESC";
                      $FetchAttendance = mysqli_query($connMysqli, $FetchAttendance);
                      while ($row = mysqli_fetch_assoc($FetchAttendance)) {
                        $timeInObj = new DateTime($row['attendance_timein']);
                        $timeIn12 = $timeInObj->format('h:i A');
                        $timeOutObj = new DateTime($row['attendance_timeout']);
                        $timeOut12 = $timeOutObj->format('h:i A');
                        $totalHrs = $row['attendance_total'];

                        preg_match('/(\d+)hrs (\d+)min/', $totalHrs, $matches);
                        $hours = (int)$matches[1];
                        $minutes = (int)$matches[2];
                        // $hours -= 1;
                        $isLate = "{$hours}hrs {$minutes}min";
                        $rendered = "{$hours}hrs ";

                        $checkTimeIn = new DateTime($timeIn12); 
                        $checkTimeOut = new DateTime($timeOut12); 
                        $thresholdTimeIn = new DateTime("8:00 AM");
                        $thresholdTimeOut = new DateTime("5:00 PM");
                        $thresholdOverTime = new DateTime("5:59 PM");
                        if($checkTimeIn > $thresholdTimeIn && $checkTimeOut < $thresholdTimeOut) {
                          $result = $isLate; // Assuming $isLate is defined
                          $status = "Late, Under Time";
                        } 
                        else if($checkTimeOut < $thresholdTimeOut){
                          $result = $isLate; 
                          $status = "Under Time";
                        }
                        else if($checkTimeIn > $thresholdTimeIn){
                          $result = $isLate; 
                          $status = "Late";
                        }
                        else if($checkTimeOut > $thresholdOverTime){
                          $result = $rendered; 
                          $status = "Over Time";
                        }
                        else{
                          $result = $rendered; 
                          $status = "On Time";
                        }
                        


                        echo "
                          <tr class='tr-attendance'>
                            <td ><div class='td-flex-parent'><div class='td-flex-child'><p>" . $row['attendance_date'] . "</p> <i>" . file_get_contents('../Assets/SVG/calendar.svg') . " " .  $row['attendance_day'] . "</i></div> </div></td>
                            <td>" . $timeIn12 . "</td>
                            <td>" . $timeOut12 . "</td>
                            <td>
                              <div class='td-flex-parent'>
                                <div class='td-flex-child'>
                
                                    <li><i>Rendered: </i> " . $result . "</li>
                                    <li><i>Total Hrs: </i> " . $totalHrs . "</li>
                                </div> 
                              </div>
                            </td>
                            <td>" . $status . "</td>
                            <td><button>View</button></td>
                          </tr>
                        ";
                      }

                    ;?>


                  </tbody>
                </table>
              </div>
              <div class="table-2">
                <div class="table-2-div">

                  <table>
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <!-- <th>Total Hours</th> -->
                        <th>Hour/s Rendered</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody class="tBody-attendancePending">
                      <?php
                        $FetchAttendance = "SELECT * FROM attendance_tb WHERE attendance_student_id = '$decrypted_user_id' AND attendance_status = 'Pending' ORDER BY attendance_id  DESC";
                        $FetchAttendance = mysqli_query($connMysqli, $FetchAttendance);
                        while ($row = mysqli_fetch_assoc($FetchAttendance)) {
                          $timeInObj = new DateTime($row['attendance_timein']);
                          $timeIn12 = $timeInObj->format('h:i A');
                          $timeOutObj = new DateTime($row['attendance_timeout']);
                          $timeOut12 = $timeOutObj->format('h:i A');
                          $totalHrs = $row['attendance_total'];

                          preg_match('/(\d+)hrs (\d+)min/', $totalHrs, $matches);
                          $hours = (int)$matches[1];
                          $minutes = (int)$matches[2];
                          // $hours -= 1;
                          $isLate = "{$hours}hrs {$minutes}min";
                          $rendered = "{$hours}hrs ";




                          $checkTimeIn = new DateTime($timeIn12); 
                          $checkTimeOut = new DateTime($timeOut12); 
                          $thresholdTimeIn = new DateTime("8:00 AM");
                          $thresholdTimeOut = new DateTime("5:00 PM");
                          $thresholdOverTime = new DateTime("6:00 PM");
                          $thresholdOverTime2 = new DateTime("5:59 PM");
                          if($checkTimeIn > $thresholdTimeIn && $checkTimeOut < $thresholdTimeOut) {
                            $result = $isLate; // Assuming $isLate is defined
                            $status = "Late, Under Time";
                          } 

                          else if($checkTimeIn > $thresholdTimeIn && $checkTimeOut < $thresholdOverTime){
                            $result = $isLate; 
                            $status = "Late";
                          }
                          else if($checkTimeIn > $thresholdTimeIn && $checkTimeOut > $thresholdOverTime2){
                            $result = $isLate; 
                            $status = "Late, Over Time";
                          }
                          
                          // else if($checkTimeIn > $thresholdTimeIn && $checkTimeOut > $thresholdTimeOut){
                          //   $result = $isLate; 
                          //   if($checkTimeOut < $thresholdOverTime){
                          //     $status = "Late";
                          //   }
                          //   else{
                          //     $status = "Late, Over Time";
                          //   }
                          // }


                          else if($checkTimeOut < $thresholdTimeOut){
                            $result = $isLate; 
                            $status = "Under Time";
                          }
                          else if($checkTimeOut > $thresholdOverTime){
                            $result = $rendered; 
                            $status = "Over Time";
                          }
                          else{
                            $result = $rendered; 
                            $status = "On Time";
                          }


                          echo "
                            <tr class='tr-attendance tr-attendancePending'>
                              <td ><div class='td-flex-parent'><div class='td-flex-child'><p>" . $row['attendance_date'] . "</p> <i>" . file_get_contents('../Assets/SVG/calendar.svg') . " " .  $row['attendance_day'] . "</i></div> </div></td>
                              <td>" . $timeIn12 . "</td>
                              <td>" . $timeOut12 . "</td>
                              <td>
                                <div class='td-flex-parent'>
                                  <div class='td-flex-child'>
                                      <li><i>Rendered: </i> " . $result . "</li>
                                      <li><i>Total Hrs: </i> " . $totalHrs . "</li>
                                  </div> 
                                </div>
                              </td>
                              <td>" . $status . "</td>
                              <td>
                                <button>" . file_get_contents('../Assets/SVG/description.svg') . "</button>
                                <button>" . file_get_contents('../Assets/SVG/delete.svg') . "</button>
                              </td>
                            </tr>
                          ";
                        }

                      ;?>



                    </tbody>
                  </table>
                </div>
                
                <div class="table-2-stats">
                  <h4>Tentative Calculation</h4>
                  <div class="table-2-statsDiv">

                    <table class="table-2-container">
                      <thead class="thead-2-stats">
                        <tr>
                          <td></td>
                          <td>Pending</td>
                          <td>Tentative</td>
                          <td>Rendered</td>
                        </tr>
                      </thead>
                      <tbody class="tbody-2-stats">

                        <tr>
                          <th>Total Hours:</th>
                          <td><?php echo $TotalPendingDuration?></td>
                          <td><?php echo $TotalTentativeDuration?></td>
                          <td><?php echo $TotalRenderedDuration?></td>
                        </tr>
                        <tr>
                          <th>Remaining Hours:</th>
                          <td><?php echo $RemainingHrsPending?></td>
                          <td><?php echo $RemainingHrsTentative?></td>
                          <td><?php echo $RemainingHrsRendered?></td>
                        </tr>
                        <tr>
                          <th>Day/s Worked:</th>
                          <td><?php echo $CountDayPending?> Day/s</td>
                          <td><?php echo $CountDayTentative?> Day/s</td>
                          <td><?php echo $CountDayRendered?> Day/s</td>
                        </tr>
                        <tr>
                          <th>Remaining Days:</th>
                          <td><?php echo $PendingRemainingDays?></td>
                          <td><?php echo $TentativeRemainingDays?></td>
                          <td><?php echo $RenderedRemainingDays?></td>
                        </tr>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="main-child-2">
            <div class="stats-div">
              <ul>
                <li><i>Total Hours:</i> <span class="span-TotalHours"><h4 class="h4-TotalHours"><?php echo $TotalRenderedDuration?> / <?php echo $TrainingHours?> </h4></span></li>
                <li><i>Remaining Hours:</i> <h4><?php echo $RemainingHrsRendered?></h4></li>
                <li><i>Total Days:</i> <h4><?php echo $CountDayRendered?> Day/s</h4></li>
                <li><i>Total Late:</i> <h4 id="count-late">2</h4></li>
                <li><i>Total Over Time:</i> <h4 id="count-ot">5</h4></li>
                <li><i>Total Under time:</i> <h4 id="count-ut">2</h4></li>
              </ul>
            </div>
            <div class="add-attendance-container">
              <div class="overlay-div">
                <img src="../Assets/Images/EACMC_LOGO1.png" alt="">
              </div>
              <div class="button-div">  
                <button onclick="addNewAttendance()" class="btnAddAttendance">Add Attendance</button>
                <button onclick="submit('insert')" class="btnSaveAttendance">Submit Attendance</button>
              </div>
              <div class="addHidden-container">
                <ul>
                  <li><i>Date:</i><input type="date" name="" id="stdDate"></li>
                  <li><i>Time In:</i><input type="time" onchange="submit('record')" name="pick-time" id="stdTimeIn"></li>
                  <li><i>Time Out:</i><input type="time" onchange="submit('record')" name="pick-time" id="stdTimeOut"></li>
                  <li><i></i><p><span id="TotalWorked">Total: 0hrs 0min</span> </p> </li>
                </ul>

                <div class="remarks-container">
                  <i>Notes: (Optional)</i>
                  <div class="remarks-div">
                    <textarea name="" id="stdNote" placeholder="Type here"></textarea>
                  </div>
                </div>
              </div>
            </div>

       
          </div>
        </div>
     </div>
    <!-- END -->
    
    <div class="modal-container">
      <div class="modal-content">
        <div class="content-header">
        </div>
        <div class="content-container">
          <div class="hide-modal" onclick="HideModal()"><?php include "../Assets/SVG/close.svg"?></div>
          <h2>GALLERY</h2>
        </div>

      </div>
    </div>

  </div>
  <script>var StudentID = '<?= $encrypted_user_id ?>';</script>
</body>
</html>