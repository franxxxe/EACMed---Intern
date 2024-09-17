

// ===================================================
// SHOW PASSWORD
const passwordInput = document.getElementById('passwordInput');
const showPasswordCheckbox = document.getElementById('myCheckbox');

showPasswordCheckbox.addEventListener('change', () => {
  // Toggle the type attribute of the password input
  if (showPasswordCheckbox.checked) {
    passwordInput.setAttribute('type', 'text');
  } else {
    passwordInput.setAttribute('type', 'password');
  }
});