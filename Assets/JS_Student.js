
$(document).ready(function () {
  console.log(StudentID);
});

function addNewAttendance(){
  document.querySelector(".addHidden-container").style.height = document.querySelector(".addHidden-container").style.height === "100%" ? "0px" : "100%";
  // document.querySelector(".btnSaveAttendance").style.display = document.querySelector(".btnSaveAttendance").style.display=== "flex" ? "none" : "flex";
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
  };
  $.ajax({
    url: "../Components/Function_Student.php",
    type: "post",
    data: data,
    success: function (response) {
      // console.log(response);
      $("#TotalWorked").html(response);
      $(".tBody-Attendance").load(location.href + " .tr-attendance");
      $(".span-TotalHours").load(location.href + " .h4-TotalHours");
    },
  });
}



function viewID(viewID) {
  var data = {
    viewID: viewID,
    StudentID: StudentID,
  };
  $.ajax({
    url: "../Components/Function_Student.php",
    type: "post",
    data: data,
    success: function (response) {
      console.log("++++++++");
      console.log(response);
    },
  });
}
