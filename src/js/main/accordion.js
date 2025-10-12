// Bootstrap 5 accordion
// https://getbootstrap.com/docs/5.2/components/accordion/
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.accordion').forEach(function (accordion, accordionIndex) {
        let accordionId = accordion.getAttribute('id');
        let items = accordion.querySelectorAll('.accordion-item');

        if (!items) {
            return;
        }

        // Each accordion must have a unique ID.
        if (!accordionId) {
            accordionId = 'accordion-' + accordionIndex;
            accordion.setAttribute('id', accordionId);
        }

        items.forEach(function (item, itemIndex) {
            let heading = item.querySelector('.accordion-header');
            let button = item.querySelector('.accordion-button');
            let collapse = item.querySelector('.accordion-collapse');

            let headingId = heading.getAttribute('id');
            let collapseId = collapse.getAttribute('id');

            // Each heading and collapse must have a unique ID.
            if (!headingId) {
                headingId = accordionId + '-item-' + itemIndex + '-heading';
                heading.setAttribute('id', headingId);
            }

            if (!collapseId) {
                collapseId = accordionId + '-item-' + itemIndex + '-collapse';
                collapse.setAttribute('id', collapseId);
            }

            // Set required button attributes.
            button.setAttribute('aria-controls', collapseId);
            button.setAttribute('aria-expanded', 'false');
            button.setAttribute('data-bs-toggle', 'collapse');
            button.setAttribute('data-bs-target', '#' + collapseId);

            // Set required collapse attributes.
            collapse.setAttribute('aria-labelledby', headingId);
            collapse.setAttribute('data-bs-parent', '#' + accordionId);

            // Set initial collapsed state.
            button.classList.add('collapsed');
            collapse.classList.add('collapse');
        });
    });
});
