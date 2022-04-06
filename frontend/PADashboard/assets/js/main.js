function toggleMobileMenu() {
    document.getElementById('aside-mobile').classList.toggle('hidden')
    document.getElementById('aside-mobile-backdrop').classList.toggle('hidden')
}

document.getElementById('burger-btn').addEventListener('click', toggleMobileMenu)
document.getElementById('aside-mobile-backdrop').addEventListener('click', toggleMobileMenu)

