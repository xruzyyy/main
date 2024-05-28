// Function to check if an element is in viewport
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}
// Function to handle scrolling
function handleScroll() {
    const textContainer = document.querySelector('.text-container');
    if (isInViewport(textContainer)) {
        textContainer.classList.add('show');
        window.removeEventListener('scroll', handleScroll); // Remove event listener once animation is triggered
    }
}
// Add event listener for scrolling
window.addEventListener('scroll', handleScroll);
// JavaScript
document.addEventListener("DOMContentLoaded", function () {
    var cards = document.querySelectorAll('.animate-on-scroll');

    function checkScroll() {
        cards.forEach(function (card) {
            var cardTop = card.getBoundingClientRect().top;
            var cardBottom = card.getBoundingClientRect().bottom;
            var windowHeight = window.innerHeight;

            if (cardTop < windowHeight && cardBottom >= 0) {
                card.classList.add('visible');
            } else {
                card.classList.remove('visible');
            }
        });
    }

    window.addEventListener('scroll', checkScroll);
    checkScroll(); // Check on initial load
});
