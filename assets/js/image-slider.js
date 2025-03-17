
let currentIndex = 0;
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;

// Function to show the current slide
function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.classList.remove('active');
        if (i === index) {
            slide.classList.add('active');
        }
    });
}

// Function to move to the next slide
function nextSlide() {
    currentIndex = (currentIndex + 1) % totalSlides; // Loop back to first slide
    showSlide(currentIndex);
}

// Create navigation buttons
const navigation = document.querySelector('.navigation');
for (let i = 0; i < totalSlides; i++) {
    const navBtn = document.createElement('div');
    navBtn.classList.add('slide-nav-btn');
    navBtn.addEventListener('click', () => {
        currentIndex = i;
        showSlide(currentIndex);
        updateNavButtons();
    });
    navigation.appendChild(navBtn);
}

// Function to update navigation buttons
function updateNavButtons() {
    const navButtons = document.querySelectorAll('.slide-nav-btn');
    navButtons.forEach((btn, i) => {
        btn.classList.remove('active');
        if (i === currentIndex) {
            btn.classList.add('active');
        }
    });
}

// Automatically move to the next slide every 5 seconds
setInterval(nextSlide, 5000);

// Initial display
showSlide(currentIndex);
updateNavButtons();