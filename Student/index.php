<?php
  session_start();
  include "../Config/Configure.php";
  if (isset($_SESSION['username'])) {
    // echo "Success";
  }else{
    // echo "Failed";
    header('Location: ../Student Login');
    exit();
  }

  $FetchTotalHours = "SELECT * FROM attendance_tb ";
  $FetchTotalHours = mysqli_query($connMysqli, $FetchTotalHours);
  $dataArray = [];
  $TotalDuration = "0hrs";
  if ($FetchTotalHours->num_rows > 0) {
    while ($rowTotal = $FetchTotalHours->fetch_assoc()) {
      $dataArray[] = $rowTotal['attendance_total'];
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
    $TotalDuration = $totalHours . "hrs " . $remainingMinutes . "min";
    // echo "Total time: " . $totalHours . "hrs " . $remainingMinutes . "min";
  };

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
        <div class="">
          <h2><?php echo $_SESSION['username']; ?></h2>
          <h4>Alfelor, France Joshua</h4>
          <h4>BS - Information Technology</h4>
          <h4>National College of Science and Technology</h4>
        </div>
        <div class="">
          <button class="logout-link">Logout</button>

          
          <div class="theme-div">
            <div class="mode-div">
              <?php include "../Assets/SVG/dark_mode.svg"?>
              <?php include "../Assets/SVG/light_mode.svg"?>
            </div>
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
                <input type="text" placeholder="Search">
              </div>
              <div class="ul-navigation">
                <ul>
                  <li onclick="tableTab(1)" class="nav-li1 active-li">Attendance (24)</li>
                  <li onclick="tableTab(2)" class="nav-li2 inactive-li">Pending (12)</li>
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
                      <th>Total Hours</th>
                      <th>Late</th>
                      <th>Overtime</th>
                      <th>Remarks</th>
                    </tr>
                  </thead>
                  <tbody class="tBody-Attendance">
                    <?php
                      $FetchAttendance = "SELECT * FROM attendance_tb ";
                      $FetchAttendance = mysqli_query($connMysqli, $FetchAttendance);
                      while ($row = mysqli_fetch_assoc($FetchAttendance)) {
                        $timeInObj = new DateTime($row['attendance_timein']);
                        $timeIn12 = $timeInObj->format('h:i A');
                        $timeOutObj = new DateTime($row['attendance_timeout']);
                        $timeOut12 = $timeOutObj->format('h:i A');
                        $sample = "Sample";
                        echo "
                          <tr class='tr-attendance'>
                            <td ><div class='td-flex-parent'><div class='td-flex-child'><p>" . $row['attendance_date'] . "</p> <i>" . $row['attendance_day'] . "</i></div> </div></td>
                            <td>" . $timeIn12 . "</td>
                            <td>" . $timeOut12 . "</td>
                            <td>" . $row['attendance_total'] . "</td>
                            <td></td>
                            <td></td>
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
                        <th>Total Hours</th>
                        <th>Late</th>
                        <th>Overtime</th>
                        <th>Remarks</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>September 18, 2024</td>
                        <td>07:00:00 AM</td>
                        <td>05:00:00 PM</td>
                        <td>8:00:00</td>
                        <td>0</td>
                        <td>0</td>
                        <td><button>View</button></td>
                      </tr>
                      <tr>
                        <td>September 18, 2024</td>
                        <td>07:00:00 AM</td>
                        <td>05:00:00 PM</td>
                        <td>8:00:00</td>
                        <td>0</td>
                        <td>0</td>
                        <td><button>View</button></td>
                      </tr>
                    </tbody>
                  </table>
                </div>


                <div class="table-2-stats">
                  <p>stats</p>
                </div>
              </div>
            </div>
          </div>
          <div class="main-child-2">
            <div class="stats-div">
              <ul>
                <li><i>Total Hours:</i> <span class="span-TotalHours"><h4 class="h4-TotalHours"><?php echo $TotalDuration?>  / 486hrs</h4></span></li>
                <li><i>Remaining Hours:</i> <h4>240hrs</h4></li>
                <li><i>Total Days:</i> <h4>34 / 60</h4></li>
                <li><i>Total Late:</i> <h4>2</h4></li>
                <li><i>Total Over Time:</i> <h4>5</h4></li>
                <li><i>Total Under time:</i> <h4>2</h4></li>
              </ul>
            </div>
            <div class="add-attendance-container">
              <div class="overlay-div">
                <img src="../Assets/Images/EACMC_LOGO1.png" alt="">
              </div>
              <div class="button-div">  
                <button onclick="addNewAttendance()" class="btnAddAttendance">Add Attendance</button>
                <button onclick="submit('insert')" class="">Submit</button>
              </div>
              <div class="addHidden-container">
                <ul>
                  <li><i>Date:</i><input type="date" name="" id="stdDate"></li>
                  <li><i>Time In:</i><input type="time" onchange="submit('record')" name="pick-time" id="stdTimeIn"></li>
                  <li><i>Time Out:</i><input type="time" onchange="submit('record')" name="pick-time" id="stdTimeOut"></li>
                  <li><i></i><p>Total: <span id="TotalWorked"> 0hrs 0min</span> | Status: Late</p> </li>
                </ul>

                <div class="remarks-container">
                  <i>Notes:</i>
                  <div class="remarks-div">
                    <textarea name="" id="" placeholder="Type here"></textarea>
                  </div>
                </div>
              </div>
            </div>

       
          </div>
        </div>
     </div>
    <!-- END -->
  </div>
</body>
</html>