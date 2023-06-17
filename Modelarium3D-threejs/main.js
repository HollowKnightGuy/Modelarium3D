import Experience from './Classes/Experience/Experience';

// We call the main class to initialize the 3D Room
const experience = new Experience(document.querySelector('.experience-canvas'), "User")

// An event that make the interactive cursor to follow the real cursor
document.onmousemove = e => {
  document.getElementById('cursor').style.cssText = `top: ${e.clientY}px; left: ${e.clientX}px`;
}



$('.loader').fadeIn(300);

const loaderAnimation = [
    { filter: "grayscale(1)"},
    { filter: "grayscale(0)"},
]

// The PerformanceTiming interface represents timing-related performance information for the given page.
let perfData = window.performance.timing;
let EstimatedTime = -(perfData.loadEventEnd - perfData.navigationStart);
let time = parseInt((EstimatedTime/1000)%60)*100;


// Loadbar Animation
$(".loadercolor").animate(loaderAnimation, {duration: time, iterations:100});


// Percentage Increment Animation
let PercentageID = $("#percentage");
let start = 0;
let end = 100;
let duration = time;
animateValue(PercentageID, start, end, duration);
    

/**
 * Update the size of the renderer
 * @param  {Number} id The id of the percentage number
 * @param  {Number} start 0
 * @param  {Number} end 100
 * @param  {Number} duration Estimated page load time
 * @return  {}
 */
function animateValue(id, start, end, duration) {  
  let range = end - start;
  let current = start;
  let increment = end > start? 1 : -1;
  let stepTime = Math.abs(Math.floor(duration / range));
  let obj = $(id);
    
  let timer = setInterval(function() {
    current += increment;
    $(obj).text(current + "%");
      //obj.innerHTML = current;
    if (current == end) {
      clearInterval(timer);
    }
  }, stepTime);
}

// Fading Out Loadbar on Finised
setTimeout(function(){
  $('.loader').fadeOut(300);
}, time);



