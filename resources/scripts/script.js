window.addEventListener('scroll', function() {
    var exploreWords = document.querySelectorAll('.intro .hidden-from-left');
    var screenHeight = window.innerHeight;
    var delay = 300; // Adjust the delay between each word in milliseconds

    exploreWords.forEach(function(word, index) {
        var wordPosition = word.getBoundingClientRect().top;

        if (wordPosition < screenHeight / 1.5) {
            setTimeout(function() {
                word.classList.add('show-from-left');
            }, delay * index);
        } else {
            word.classList.remove('show-from-left');
        }
    });
});




window.addEventListener('scroll', function() {
    var aboutWords = document.querySelectorAll('.aboutUs .hidden-from-right');
    var screenHeight = window.innerHeight;
    var delay = 1000; // Adjust the delay between each word in milliseconds

    aboutWords.forEach(function(word, index) {
        var wordPosition = word.getBoundingClientRect().top;

        if (wordPosition < screenHeight / 1.5) {
            setTimeout(function() {
                word.classList.add('show');
            }, delay * index);
        } else {
            word.classList.remove('show');
        }
    });
});
