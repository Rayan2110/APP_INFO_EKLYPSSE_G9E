/* image slider */

var slideIndex = 1;
showSlides(slideIndex);

function plusSlide(n){
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("custom-slider");
    var dots = document.getElementsByClassName("dot");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
}


/* caroussel */

function setupCarousel(carouselId) {
    const carousel = document.querySelector(`.${carouselId}`);
    // const arrowBtns = document.querySelectorAll(".content-fest i");
    const arrowLeft = document.getElementById(`left-${carouselId}`);
    const arrowRight = document.getElementById(`right-${carouselId}`);
    const firstCardWidth = carousel.querySelector(".card").offsetWidth;
    const carouselChildrens = [...carousel.children];

    let isDragging = false, startX, startScrollLeft;

    let cardPerView = Math.round(carousel.offsetWidth / firstCardWidth);

    carouselChildrens.slice(-cardPerView).reverse().forEach(card => {
        carousel.insertAdjacentHTML("afterbegin", card.outerHTML);
    });
    carouselChildrens.slice(0, cardPerView).forEach(card => {
        carousel.insertAdjacentHTML("beforeend", card.outerHTML);
    });

    // arrowBtns.forEach(btn => {
    //     btn.addEventListener("click", () => {
    //         carousel.scrollLeft += btn.id === "left" ? -firstCardWidth : firstCardWidth;
    //     })
    // })

    arrowLeft.addEventListener("click", () => {
        carousel.scrollLeft -= firstCardWidth;
      });
    
      arrowRight.addEventListener("click", () => {
        carousel.scrollLeft += firstCardWidth;
      });

    const dragStart = (e) => {
        isDragging = true;
        carousel.classList.add("dragging");
        startX = e.pageX;
        startScrollLeft = carousel.scrollLeft;
    }

    const dragging = (e) => {
        if(!isDragging) return;
        carousel.scrollLeft = startScrollLeft - (e.pageX - startX); 
    }

    const dragStop = () => {
        isDragging = false;
        carousel.classList.remove("dragging");
    }

    const infiniteScroll = () => {
        if(carousel.scrollLeft === 0) {
            carousel.classList.add("no-tansition");
            carousel.scrollLeft = carousel.scrollWidth - ( 2 * carousel.offsetWidth);
            carousel.classList.remove("no-tansition");
        }
        else if(Math.ceil(carousel.scrollLeft) === carousel.scrollWidth - carousel.offsetWidth) {
            carousel.classList.add("no-tansition");
            carousel.scrollLeft = carousel.offsetWidth;
            carousel.classList.remove("no-tansition");
        }
    }
    carousel.addEventListener("mousedown", dragStart);
    carousel.addEventListener("mousemove", dragging);
    document.addEventListener("mouseup", dragStop);
    carousel.addEventListener("scroll", infiniteScroll);
}

setupCarousel("carousel1");
setupCarousel("carousel2");
setupCarousel("carousel3");