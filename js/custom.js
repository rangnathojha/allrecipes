jQuery(document).ready(function($) {
      $('select:not(.ignore)').niceSelect();   
	  
	  $('.owl-brands').owlCarousel({
		loop:true,
		margin:0,
		dots:true,
		responsiveClass:true,
		autoplay:true,
		autoplayTimeout:5000,
		autoplayHoverPause:false,
		responsive:{
			0:{
				items:2,
				dots:true,
				nav:false
			},
			600:{
				items:3,
				dots:true,
				nav:false
			},
			900:{
				items:4,
				dots:true,
				nav:false,
				loop:true
			}
		}
	});
});  

let mainNavLinks = document.querySelectorAll(".rws-bsaleftpanel nav ul li a");
let mainSections = document.querySelectorAll(".rws-bsarightpanel .rws-listitembsa");

let lastId;
let cur = [];

// This should probably be throttled.
// Especially because it triggers during smooth scrolling.
// https://lodash.com/docs/4.17.10#throttle
// You could do like...
// window.addEventListener("scroll", () => {
//    _.throttle(doThatStuff, 100);
// });
// Only not doing it here to keep this Pen dependency-free.

window.addEventListener("scroll", event => {
  let fromTop = window.scrollY;

  mainNavLinks.forEach(link => {
    let section = document.querySelector(link.hash);

    if (
      section.offsetTop <= fromTop &&
      section.offsetTop + section.offsetHeight > fromTop
    ) {
      link.classList.add("current");
    } else {
      link.classList.remove("current");
    }
  });
});