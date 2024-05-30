let isMenuOpen = false;
function toggleMenu() {
    let nav = document.getElementById('nav-links');
    isMenuOpen = !isMenuOpen;

    if (isMenuOpen) {
        nav.style.display = 'flex';
    } else {
        nav.style.display = 'none';
    }
}