// Toggle main navigation menu visibility.
document.addEventListener('DOMContentLoaded', function () {
    let nav = document.querySelector('.header__nav');
    let button = document.querySelector('.header__mobile-nav-button .header__mobile-nav-link');

    let navClassHidden = 'header__nav--hidden';

    if (!nav || !button) {
        return;
    }

    // Toggle nav on button click
    button.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        nav.classList.toggle(navClassHidden);
    });

    // Hide nav on click elsewhere
    document.documentElement.addEventListener('click', function () {
        nav.classList.add(navClassHidden);
    });

    // Hide nav on page load
    nav.classList.add(navClassHidden);

    document.querySelector('.header__mobile-nav-link').addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector('.hamburger').classList.toggle('active');
      });
      
      
});
