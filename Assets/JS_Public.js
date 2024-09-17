// ===================================================
// CONSOLE URL
// Log the full URL of the current page
console.log(window.location.href);

// Log just the pathname (e.g., "/about.html")
console.log(window.location.pathname);

// Log the hostname (e.g., "www.example.com")
console.log(window.location.hostname);



// ===================================================
// FUNCTION
function tableNav(navID){
  if(navID){
    $(".active-table" + navID).css("display", "flex") .siblings().css("display", "none");
    $(".nav-active" + navID).addClass("nav-add-class1") .siblings().removeClass("nav-add-class1");
    $(".nav-active" + navID).removeClass("nav-add-class2") .siblings().addClass("nav-add-class2");
  }
}



// ===================================================
// LINKS
$(".StudentSignIn-Link").click(function(){
  location.href = "./Student Login";
})




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
    console.log("Store Mode: ", storeMode);
  }
}
function loadThemeMode(ThemeMode){
  if(ThemeMode === "Dark"){
    $(':root').css('--BGColor1', '#343131');
    $(':root').css('--BGColor2', '#151515');
    $(':root').css('--Border1', '1px solid #31849930');
    $(':root').css('--FontColor10', '#eeeeee');
    $(".theme-div").css("justify-content", "start")
    $(".light-mode").css("display","none");
    $(".dark-mode").css("display","flex");
    $(".mode-div svg").css("fill","#eeeeee");
  }
  else{
    $(':root').css('--BGColor1', '#ffffff');
    $(':root').css('--BGColor2', '#eeeeee');
    $(':root').css('--Border1', '1px solid #00000036');
    $(':root').css('--FontColor10', '#318499b8');
    $(".theme-div").css("justify-content", "end")
    $(".light-mode").css("display","flex");
    $(".dark-mode").css("display","none");
    $(".mode-div svg").css("fill","#00000036");
  }
}
$(document).ready(function() {
  loadStoredValue();
  $(".theme-div").click(function(){
    let StoreMode2 = localStorage.getItem('my_variable');
    if(StoreMode2 == "Dark"){
      loadThemeMode("Light");
      changeThemeMode("Light");
      console.log("Light");
    }
    else{
      loadThemeMode("Dark");
      changeThemeMode("Dark");
      console.log("Dark");
    }
  })
});









