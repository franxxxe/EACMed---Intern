// ===================================================
// LOADING
window.addEventListener('load', () => {
  setTimeout(() => {
    const welcomeDiv = document.querySelector('.welcome-div');
    const welcomeDivChild = document.querySelector('.welcome-div-child');
    $(".welcome-div-child").addClass("hidden");
    welcomeDiv.style.height = '5vh'; 
    // welcomeDivChild.style.height = '0vh'; 
  }, 3000); 
});





// ===================================================
// HORIZONTAL SCROLL
const scrollContainer = document.querySelector('.scroll-container');
scrollContainer.addEventListener('wheel', (event) => {
  event.preventDefault();
  scrollContainer.scrollLeft += event.deltaY;
});




// ===================================================
// PREV AND NEXT BUTTON
document.addEventListener('DOMContentLoaded', () => {
  const scrollContainer = document.querySelector('.scroll-container');
  const boxCards = document.querySelectorAll('.box-card');
  const prevButton = document.getElementById('prev');
  const nextButton = document.getElementById('next');
  const cardWidth = boxCards[0].offsetWidth + parseInt(getComputedStyle(boxCards[0]).marginRight);
  let currentIndex = 0;
  function scrollToCard(index) {
      if (index < 0) index = 0;
      if (index >= boxCards.length) index = boxCards.length - 1;
      scrollContainer.scrollLeft = index * cardWidth;
      currentIndex = index;
  }
  nextButton.addEventListener('click', () => {
      if (currentIndex < boxCards.length - 1) {
          scrollToCard(currentIndex + 4);
      }
  });
  prevButton.addEventListener('click', () => {
      if (currentIndex > 0) {
          scrollToCard(currentIndex - 4);
      }
  });
  scrollToCard(currentIndex);
});




// ===================================================
// BOX-CARD HOVER EFFECT
document.querySelectorAll('.box-card').forEach(card => {
  card.addEventListener('mouseover', function() {
    let siblings = Array.from(this.parentElement.children);
    let index = siblings.indexOf(this);
    this.style.transform = 'scale(1.1)';
    this.style.borderRadius = '8px';
    this.style.filter = 'brightness(150%)';

    siblings.slice(index + 1).forEach(sibling => {
      sibling.style.transform = 'scale(95%)';
      sibling.style.opacity = '0.5';
    });

    siblings.slice(0, index).forEach(sibling => {
      sibling.style.transform = 'scale(95%)';
      sibling.style.opacity = '0.5';
    });
  });
  card.addEventListener('mouseout', function() {
    document.querySelectorAll('.box-card').forEach(sibling => {
      sibling.style.transform = 'scale(1)';
      sibling.style.opacity = '1';
      sibling.style.borderRadius = '';
      sibling.style.filter = 'brightness(80%)';
    });
  });
});


// ===================================================
// COUNT ANIMATION
document.addEventListener("DOMContentLoaded", () => {
  function animateCounter(element, targetValue, duration) {
    let startValue = 0;
    let startTime = null;
    
    const step = (timestamp) => {
      if (!startTime) startTime = timestamp;
      const progress = timestamp - startTime;
      const increment = Math.min(progress / duration, 3);
      element.textContent = Math.floor(startValue + increment * (targetValue - startValue));
      if (progress < duration) {
        requestAnimationFrame(step);
      } else {
        element.textContent = targetValue;
      }
    };
    requestAnimationFrame(step);
  }
  const totalInternElement = document.getElementById('totalIntern');
  const activeInternElement = document.getElementById('activeIntern');
  const totalInternValue = 89;
  const activeInternValue = 11;
  const animationDuration = 1000;
  animateCounter(totalInternElement, totalInternValue, animationDuration);
  animateCounter(activeInternElement, activeInternValue, animationDuration);
});



// ===================================================
// PUSH STATE AND POP STATE
function navigate(section) {
  document.querySelectorAll('.main-parent > div').forEach(div => div.style.display = 'none');
  document.querySelector('.main-child-' + section).style.display = 'block';
  history.pushState({ section: section }, '', `#${section}`);
}
window.onpopstate = function(event) {
  if (event.state) {
    navigate(event.state.section);
  } else {
    navigate('home');
  }
};
document.addEventListener('DOMContentLoaded', () => {
  const initialSection = location.hash ? location.hash.replace('#', '') : 'home';
  navigate(initialSection);
});
