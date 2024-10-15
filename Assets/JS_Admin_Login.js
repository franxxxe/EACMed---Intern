
// ===================================================
// ADMIN LOGIN
function loginStudent(login){
  $(document).ready(function () {
    // $('#login').on('click', function (e) {
    //   e.preventDefault();
      var username = $('#AdminUsername').val();
      var password = $('#AdminPassword').val();
      $.ajax({
        url: '../Components/Function_Admin.php',
        type: 'POST',
        data: { usernameLogin: username, 
                passwordLogin: password,
              },
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            window.location.href = '../Admin Panel';
            // console.log("alfelor");
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
    // });
  });
}


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


