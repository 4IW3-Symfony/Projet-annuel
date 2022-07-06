const header = document.getElementById('header');


document.addEventListener('DOMContentLoaded', defineScrolledHeader);

window.addEventListener('scroll', defineScrolledHeader);
function defineScrolledHeader() {
    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
}
