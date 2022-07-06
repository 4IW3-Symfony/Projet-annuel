const header = document.getElementById('header');


window.addEventListener('scroll', scrolling);
function scrolling() {
    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
}
