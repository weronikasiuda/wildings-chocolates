// Set active state on top level navigation links that are parents of active
// second level navigation links.
document.addEventListener('DOMContentLoaded', function () {
    const blockClass = 'header-nav';
    const dot = '.';

    const itemClass = blockClass + '__item';
    const linkClass = blockClass + '__link';
    const subLinkClass = blockClass + '__sub-link';

    const linkClassActive = linkClass + '--active';
    const subLinkClassActive = subLinkClass + '--active';

    document.querySelectorAll(dot + subLinkClassActive).forEach(function (subLink) {
        subLink.closest(dot + itemClass).querySelector(dot + linkClass).classList.add(linkClassActive);
    });
});
