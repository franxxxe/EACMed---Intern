


function liActive(liType , liId){
  console.log(liType , liId);
  if(liType == "sidebar"){
    $(".sideLi" + liId).addClass("li-active").removeClass("li-inactive") .siblings().addClass("li-inactive").removeClass("li-active");

    
    var data = {
      submitAttendanceType: submitType,
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
}




// ===================================================
// PUSH STATE AND POP STATE
// function navigate(section) {
//   document.querySelectorAll('.main-parent > div').forEach(div => div.style.display = 'none');
//   document.querySelector('.main-child-' + section).style.display = 'block';
//   history.pushState({ section: section }, '', `#${section}`);
// }
// window.onpopstate = function(event) {
//   if (event.state) {
//     navigate(event.state.section);
//   } else {
//     navigate('home');
//   }
// };
// document.addEventListener('DOMContentLoaded', () => {
//   const initialSection = location.hash ? location.hash.replace('#', '') : 'home';
//   navigate(initialSection);
// });





// $(document).ready(function() {
//   $('.nav-link').click(function(e) {
//       e.preventDefault(); // Prevent default anchor behavior
//       const page = $(this).data('page');

//       $.ajax({
//           url: 'index.php?page=' + page,
//           method: 'GET',
//           success: function(data) {
//               $('#content').html(data); // Update content div
//           },
//           error: function() {
//               $('#content').html('<p>An error occurred</p>');
//           }
//       });
//   });
// });