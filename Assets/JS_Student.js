
$(document).ready(function () {
  // console.log(StudentID);
});


function addNewAttendance(){
  document.querySelector(".addHidden-container").style.height = document.querySelector(".addHidden-container").style.height === "100%" ? "0px" : "100%";
  document.querySelector(".btnAddAttendance").innerHTML = document.querySelector(".btnAddAttendance").innerHTML === "Add Attendance" ? "Hide" : "Add Attendance";
  document.querySelector(".btnSaveAttendance").style.display = document.querySelector(".btnSaveAttendance").style.display=== "flex" ? "none" : "flex";
}


function tableTab(tableID){
  $(".nav-li" + tableID).addClass("active-li").removeClass("inactive-li") .siblings().addClass("inactive-li") .removeClass("active-li");
  $(".table-" + tableID).css({"display":"flex"}).siblings().css({"display":"none"});
}



function submit(submitType) {
  var data = {
    submitAttendanceType: submitType,
    submitTimeIn: $("#stdTimeIn").val(),
    submitTimeOut: $("#stdTimeOut").val(),
    submitDate: $("#stdDate").val(),
    stdNote: $("#stdNote").val(),
    StudentID: StudentID,
  };
  $.ajax({
    url: "../Components/Function_Student.php",
    type: "post",
    data: data,
    success: function (response) {
        const jsonResponse = JSON.parse(response);
        // console.log(jsonResponse.success); 
        // console.log(jsonResponse.message); 
        if(jsonResponse.message2 === "1"){
          $("#stdNote").val("");
        }
        $("#TotalWorked").html(jsonResponse.message);
        $(".tBody-attendancePending").load(location.href + " .tr-attendancePending");
        $(".span-TotalHours").load(location.href + " .h4-TotalHours");
        $(".table-2-statsDiv").load(location.href + " .table-2-container");
        $(".nav-li1").load(location.href + " .NavAttendance");
        $(".nav-li2").load(location.href + " .NavPending"); 
    },
    error: function (xhr, status, error) {
        console.error('AJAX Error:', error);
    }
  });
}


function functionCLick(FunctionType) {
  if(FunctionType == "Gallery"){
    $(".modal-container").css("display", "flex");
  }
}



function countLate() {
  const rows = document.querySelectorAll('.tr-attendance');
  let lateCount = 0;
  rows.forEach(row => {
      const cells = row.querySelectorAll('td');
      cells.forEach(cell => {
          if (cell.textContent.trim() === 'Late' || cell.textContent.trim() === 'Late, Under Time' || cell.textContent.trim() === 'Late, Over Time') {
            lateCount++;
          }
      });
  });
  return lateCount;
}

function countOT() {
  const rows = document.querySelectorAll('.tr-attendance');
  let OTCount = 0;
  rows.forEach(row => {
      const cells = row.querySelectorAll('td');
      cells.forEach(cell => {
          if (cell.textContent.trim() === 'Over Time' || cell.textContent.trim() === 'Late, Over Time') {
            OTCount++;
          }
      });
  });
  return OTCount;
}

function countUT() {
  const rows = document.querySelectorAll('.tr-attendance');
  let UTCount = 0;
  rows.forEach(row => {
      const cells = row.querySelectorAll('td');
      cells.forEach(cell => {
          if (cell.textContent.trim() === 'Under Time' || cell.textContent.trim() === 'Late, Under Time') {
            UTCount++;
          }
      });
  });
  return UTCount;
}

const lateCount = countLate();
const OTCount = countOT();
const UTCount = countUT();
$("#count-late").html(`${lateCount}`);
$("#count-ot").html(`${OTCount}`);
$("#count-ut").html(`${UTCount}`);


function HideModal(){
  $(".modal-container").css("display","none");
}
