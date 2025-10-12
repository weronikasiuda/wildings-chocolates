// Add toggle buttons to subnav items with secondary lists of links.
document.addEventListener('DOMContentLoaded', function () {
    const blockClass = 'subnav';
    const dot = '.';

    const buttonClass = blockClass + '__toggle-button';

    const levels = [
        {
            subListClass: blockClass + '__sub-list',
            itemClass: blockClass + '__item'
        },
        {
            subListClass: blockClass + '__sub-sub-list',
            itemClass: blockClass + '__sub-item'
        }
    ];

    levels.forEach(function (level) {
        let itemClassActive = level.itemClass + '--active';
        let itemClassCollapsed = level.itemClass + '--collapsed';

        document.querySelectorAll(dot + level.subListClass).forEach(function (subList) {
            let item = subList.parentElement;
            let button = item.querySelector(dot + buttonClass);

            // If the button does not exist, create it.
            if (!button) {
                button = document.createElement('button');

                button.setAttribute('class', buttonClass);
                button.setAttribute('type', 'button');

                button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 10l5 5 5-5H7z"/></svg> <span class="screen-reader-text">show/hide links</span>';
                item.insertBefore(button, subList);
            }

            // Toggle the current item when the button is clicked.
            button.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                item.classList.toggle(itemClassCollapsed);
            });

            // Hide all except the active item on page load.
            if (!item.classList.contains(itemClassActive)) {
                item.classList.add(itemClassCollapsed);
            }
        });
    });
});
