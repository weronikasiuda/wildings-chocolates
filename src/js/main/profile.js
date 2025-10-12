// Show/hide profile details with Bootstrap 5 collapse effect
// https://getbootstrap.com/docs/5.2/components/collapse/
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.profile').forEach(function (profile, profileIndex) {
        let content = profile.querySelector('.profile__content');
        let button = profile.querySelector('button');

        let show = profile.dataset.showText;
        let hide = profile.dataset.hideText;

        let collapse;
        let collapseId;

        // No content? Do not add show/hide effect.
        if (!content) {
            return;
        }

        // If the content is not in a Bootstrap "collapse" element, wrap it in
        // an element with the correct class.
        collapse = content.parentElement;

        if (!collapse.classList.contains('collapse')) {
            collapse = document.createElement('div');
            collapse.setAttribute('class', 'collapse');
            content.before(collapse);
            collapse.prepend(content);
        }

        // Make sure the collapse element has a unique ID.
        collapseId = collapse.getAttribute('id');

        if (!collapseId) {
            collapseId = 'profile-' + profileIndex + '-collapse';
            collapse.setAttribute('id', collapseId);
        }

        // Create the toggle button if it does not already exist.
        if (!button) {
            button = document.createElement('button');
            button.setAttribute('class', 'btn btn-primary');
            collapse.after(button);
        }

        // Set required button attributes.
        button.setAttribute('data-bs-toggle', 'collapse');
        button.setAttribute('data-bs-target', '#' + collapseId);
        button.setAttribute('aria-expanded', 'false');
        button.setAttribute('aria-controls', collapseId);

        // Set button labels.
        if (!show) {
            show = 'Show details';
        }

        if (!hide) {
            hide = 'Hide details';
        }

        button.innerHTML = show;

        collapse.addEventListener('hidden.bs.collapse', function () {
            button.innerHTML = show;
        });

        collapse.addEventListener('shown.bs.collapse', function () {
            button.innerHTML = hide;
        });
    });
});
