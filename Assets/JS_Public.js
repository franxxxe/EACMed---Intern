// ===================================================
// CONSOLE URL
// Log the full URL of the current page
// console.log(window.location.href);

// Log just the pathname (e.g., "/about.html")
// console.log(window.location.pathname);

// Log the hostname (e.g., "www.example.com")
// console.log(window.location.hostname);



// ===================================================
// FUNCTION
function tableNav(navID){
  if(navID){
    $(".active-table" + navID).css("display", "flex") .siblings().css("display", "none");
    $(".nav-active" + navID).addClass("nav-add-class1") .siblings().removeClass("nav-add-class1");
    $(".nav-active" + navID).removeClass("nav-add-class2") .siblings().addClass("nav-add-class2");
  }
}



// INPUT PLACEHOLDER ANIMATION
function inputText(classTextName) {
  const constInputText = document.getElementsByClassName('input-' + classTextName)[0];
  if (constInputText && constInputText.value === "") {
    $(".label-" + classTextName).css({"top": "4px", "opacity": "1", "left": "35px", "scale": "100%"});
    $(".label-" + classTextName).children("span").css({"visibility": "hidden"});
  } else {
    $(".label-" + classTextName).css({"top": "-22px", "opacity": "0.5", "left": "22px", "scale": "80%"});
    $(".label-" + classTextName).children("span").css({"visibility": "visible"});
  }
}

function inputText2(classTextName2) {
  const constInputText = document.getElementsByClassName('input-' + classTextName2)[0];
  if (constInputText && constInputText.value === "") {
    $(".label2-" + classTextName2).css({"top": "4px", "opacity": "1", "left": "5px", "scale": "100%"});
  } else {
    $(".label2-" + classTextName2).css({"top": "-22px", "opacity": "0.5", "left": "-10px", "scale": "80%"});
  }
}





// ===================================================
// LINKS
$(".StudentSignIn-Link").click(function(){
  location.href = "./Student Login";
})

$(".sign-up-link").click(function(){
  location.href = "../Student Register";
})

$(".sign-in-link").click(function(){
  location.href = "../Student Login";
})

$(".login-link").click(function(){
  location.href = "../Student";
})

$(".register-link").click(function(){
  location.href = "../Student";
})

$(".logout-link").click(function(){
  location.href = "../Components/logout_student.php";
})

$(".home-link").click(function(){
  location.href = "../";
})

$(".admin-link").click(function(){
  location.href = "./Admin Panel";
})


// ===================================================



// ===================================================
// PROMPT MESSAGE
function PromptDiv(){
  $(".prompt_root").css("display","flex");
  setTimeout(() => {
    $(".prompt_root").css("display","none");
  }, 5000);
}





// ===================================================
// THEME
function changeThemeMode(Mode) {
  localStorage.setItem('my_variable', Mode );
  loadThemeMode(Mode);
}
function loadStoredValue() {
  let storeMode = localStorage.getItem('my_variable');
  if (storeMode) {
    loadThemeMode(storeMode);
  }
}
function loadThemeMode(ThemeMode){
  if(ThemeMode === "Dark"){
    $(':root').css('--BGColor1', '#343131');
    $(':root').css('--BGColor2', '#151515');
    $(':root').css('--Border1', '1px solid #31849930');
    $(':root').css('--FontColor10', '#eeeeee');
    $(':root').css('--Overlay1', '#000000dd');
    $(':root').css('--BGButton1', '#70987C');
    $(".light-mode").css("display","none");
    $(".dark-mode").css("display","flex");
    $(".mode-div").css("right", "1px")
    $(".mode-div svg").css("fill","#eeeeee");
  }
  else{
    $(':root').css('--BGColor1', '#ffffff');
    $(':root').css('--BGColor2', '#eeeeee');
    $(':root').css('--Border1', '1px solid #00000036');
    $(':root').css('--FontColor10', '#318499b8');
    $(':root').css('--Overlay1', '#0000009c');
    $(':root').css('--BGButton1', '#318499');
    $(".light-mode").css("display","flex");
    $(".dark-mode").css("display","none");
    $(".mode-div").css("right", "19px")
    $(".mode-div svg").css("fill","#00000036");
  }
}
$(document).ready(function() {
  // LOAD THEME
  loadStoredValue();
  $(".theme-div").click(function(){
    let StoreMode2 = localStorage.getItem('my_variable');
    if(StoreMode2 == "Dark"){
      loadThemeMode("Light");
      changeThemeMode("Light");
      // console.log("Light");
    }
    else{
      loadThemeMode("Dark");
      changeThemeMode("Dark");
      // console.log("Dark");
    }
  })


  $(".prompt_exit").click(function(){
    $(".prompt_root").css("display","none");
  })
});









