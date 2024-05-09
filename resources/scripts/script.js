document.addEventListener('DOMContentLoaded', function () {
    window.addEventListener('scroll', revealOnScroll);
});

function revealOnScroll() {
    var revealContainers = document.querySelectorAll('.reveal-container');

    revealContainers.forEach(function (container) {
        var revealPosition = container.offsetTop + container.offsetHeight / 2;
        var scrollPosition = window.scrollY + window.innerHeight;

        if (scrollPosition >= revealPosition) {
            container.querySelector('.text-container').classList.add('revealed');
        }
    });
}
