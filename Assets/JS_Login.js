

// ===================================================
// SHOW PASSWORD
const passwordInput = document.querySelector('.passwordInput');
const showPasswordCheckbox = document.getElementById('myCheckbox');
showPasswordCheckbox.addEventListener('change', () => {
  if (showPasswordCheckbox.checked) {
    passwordInput.setAttribute('type', 'text');
  } else {
    passwordInput.setAttribute('type', 'password');
  }
});





// ===================================================
// USERNAME VALIDATION
function userNameValidation(userName){
  const constInputText = document.getElementsByClassName('input-RegUsername')[0].value;
  const paragraphMessage = document.getElementById('error-p-message');
  const divErrorChild = document.getElementsByClassName('error-message-div-child')[0];
  $.ajax({
    url: '../Components/Function_Student.php',
    type: 'POST',
    data: { validateUsername: constInputText},
    dataType: 'json',
    success: function (response) {
      if (response.message === "Available") {
        divErrorChild.style.display = "flex";
        paragraphMessage.innerHTML  = "Username is ready for use.";
        $(".svg-check").css("display","flex") .siblings().css("display","none");
      } 
      else if(response.message === "Not Available"){
        divErrorChild.style.display = "flex";
        paragraphMessage.innerHTML  = "Username is already taken.";
        $(".svg-error").css("display","flex") .siblings().css("display","none");
      } 
      else {
        divErrorChild.style.display = "none";
        paragraphMessage.innerHTML  = "";
      }
    }
  });
}


function PromptDiv(){
  $(".prompt_root").css("display","flex");
  setTimeout(() => {
    $(".prompt_root").css("display","none");
  }, 5000);
}


// ===================================================
// STUDENT LOGIN
$(document).ready(function () {
  $('#login').on('click', function (e) {
    e.preventDefault();
    var username = $('#stdUsername').val();
    var password = $('#stdPassword').val();
    $.ajax({
      url: '../Components/Function_Student.php',
      type: 'POST',
      data: { usernameLogin: username, 
              passwordLogin: password,
            },
      dataType: 'json',
      success: function (response) {
        if (response.success) {
          window.location.href = '../Student/index.php';
        }
        else if(response.message == "Login Failed"){
          $("#prompt_message").html(response.message);
          PromptDiv();
        }
        else {
          $("#prompt_message").html(response.message);
          PromptDiv();
        }
      },
      error: function(xhr, status, error) {
        console.error("AJAX error: " + status + " - " + error);
        console.log("XHR Object:", xhr);
        console.log("Status Text:", xhr.statusText);
        console.log("HTTP Status Code:", xhr.status);
        console.log("Response Text:", xhr.responseText);
      }
    });
  });
});


// ===================================================
// STUDENT REGISTRATION
$(document).ready(function () {
  $('#register').on('click', function (e) {
    e.preventDefault();
    var username = $('#stdUsername').val();
    var password = $('#stdPassword').val();
    $.ajax({
      url: '../Components/Function_Student.php',
      type: 'POST',
      data: { username: username, 
              password: password,
              stdLastName: $('#stdLastName').val(),
              stdFirstName: $('#stdFirstName').val(),
              stdGender: $('#stdGender').val(),
              stdSchoolName: $('#stdSchoolName').val(),
              stdCourse: $('#stdCourse').val(),
              stdTrainingHours: $('#stdTrainingHours').val(),
            },
      dataType: 'json',
      success: function (response) {
        if (response.success) {
          window.location.href = '../Student/index.php';
        }
        else if (response.message == "All fields are required."){
          $(".prompt_root").css("display","flex");
          $("#prompt_message").html(response.message);
          
          setTimeout(() => {
            $(".prompt_root").css("display","none");
          }, 5000);
        }
        else {
          $(".prompt_root").css("display","flex");
          $("#prompt_message").html(response.message);
          
          setTimeout(() => {
            $(".prompt_root").css("display","none");
          }, 5000);
        }
      },
      error: function(xhr, status, error) {
        console.error("AJAX error: " + status + " - " + error);
        console.log("XHR Object:", xhr);
        console.log("Status Text:", xhr.statusText);
        console.log("HTTP Status Code:", xhr.status);
        console.log("Response Text:", xhr.responseText);
      }

      
    });
  });
});
