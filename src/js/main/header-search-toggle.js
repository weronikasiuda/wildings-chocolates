// Toggle header search form visibility.
document.addEventListener('DOMContentLoaded', function () {
    let searchSection = document.querySelector('.header__search');
    let searchInput = document.querySelector('#header-search-term');
    let searchButton = document.querySelector('.header__actions-item--search .header__actions-link');
    let navButton = document.querySelector('.header__actions-item--nav .header__actions-link');
    let collapse;

    if (!searchSection || !searchButton) {
        return;
    }

    // Create Bootstrap collapse
    searchSection.setAttribute('id', 'header-search');
    searchSection.classList.add('collapse');

    searchButton.setAttribute('href', '#header-search');
    searchButton.setAttribute('data-bs-toggle', 'collapse');
    searchButton.setAttribute('role', 'button');
    searchButton.setAttribute('aria-expanded', 'false');
    searchButton.setAttribute('aria-controls', 'header-search');

    // Get Bootstrap collapse instance
    collapse = bootstrap.Collapse.getInstance(searchSection);

    if (collapse === null) {
        collapse = new bootstrap.Collapse(searchSection, {
            toggle: false
        });
    }

    // Focus search input when search section is opened
    searchSection.addEventListener('shown.bs.collapse', function () {
        searchInput.focus();
    });

    // Do not hide search section when clicking inside section
    searchSection.addEventListener('click', function (e) {
        e.stopPropagation();
    });

    // Hide search section on click elsewhere
    document.documentElement.addEventListener('click', function () {
        collapse.hide();
    });

    // Hide search section on nav button click (necessary because nav button
    // uses stopPropagation on click event).
    navButton.addEventListener('click', function () {
        collapse.hide();
    });
});
