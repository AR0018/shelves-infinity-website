/*Numero degli slider presenti nella schermata home*/
let slideIndex = [0, 0, 0];
/*for(i = 0; i < slideIndex.length; i++) {
  showSlides(0, i);
}*/

/**
 * Function used to show the next/previous slide.
 * @param int 1 show the next slide, -1 the previous one
 * @param int index 
 */
function plusSlides(n, index) {
  showSlides(slideIndex[index] += n, index);
  
}

function showSlides(n, index) {
  let carousel = document.querySelector(`.container-slides${index}`);
  let slide = document.querySelector(`.slides${index}`);
  const slideWidth = slide.clientWidth + 12;
  carousel.scrollLeft = n == 1 ? carousel.scrollLeft + slideWidth : carousel.scrollLeft - slideWidth;
}