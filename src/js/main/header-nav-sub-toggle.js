// Toggle main navigation secondary menu visibility.
document.addEventListener('DOMContentLoaded', function () {
    const blockClass = 'header-nav';
    const dot = '.';

    const linkClass = blockClass + '__link';
    const buttonClass = blockClass + '__sub-toggle';
    const subListClass = blockClass + '__sub-list';

    const buttonClassVisible = buttonClass + '--visible';
    const subListClassVisible = subListClass + '--visible';
    const subListClassOverflow = subListClass + '--overflow';

    let subLists = document.querySelectorAll(dot + subListClass);
    let buttons;
    let timer;

    if (!subLists) {
        return;
    }

    // If a secondary list is visible and it overflows the right edge of the
    // viewport, add the "overflow" class to force it inside the viewport.
    function toggleOverflowClass(expand) {
        subLists.forEach(function (subList) {
            if (typeof expand === 'undefined') {
                expand = false;
            }

            if (
                subList.classList.contains(subListClassVisible) &&
                subList.getBoundingClientRect().right > document.documentElement.clientWidth
            ) {
                subList.classList.add(subListClassOverflow);
                return;
            }

            if (expand) {
                subList.classList.remove(subListClassOverflow)
            }
        });
    }

    subLists.forEach(function (subList) {
        let item = subList.parentElement;
        let link = item.querySelector(dot + linkClass);
        let button = item.querySelector(dot + buttonClass);

        // If the relevant toggle button does not exist, create it.
        if (!button) {
            button = document.createElement('button');
            button.setAttribute('class', buttonClass);
            button.setAttribute('type', 'button');
            button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" aria-hidden="true"><path d="M7,10L12,15L17,10H7Z" /></svg> <span class="screen-reader-text">show/hide links</span>';
            item.insertBefore(button, subList);
        }

        // Toggle the current secondary list and hide all the other secondary
        // lists when the button is clicked.
        button.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            subList.classList.toggle(subListClassVisible);
            button.classList.toggle(buttonClassVisible);

            subLists.forEach(function (targetSubList) {
                if (subList !== targetSubList) {
                    targetSubList.classList.remove(subListClassVisible);
                }
            });

            buttons.forEach(function (targetButton) {
                if (button !== targetButton) {
                    targetButton.classList.remove(buttonClassVisible);
                }
            });

            // Re-check for overflow issues.
            toggleOverflowClass(true);
        });
    });

    // Assemble a list of all the toggle buttons after each secondary list has
    // been checked and any missing buttons have been created.
    buttons = document.querySelectorAll(dot + buttonClass);

    // Hide all the secondary lists when clicking elsewhere on the page.
    document.documentElement.addEventListener('click', function () {
        subLists.forEach(function (subList) {
            subList.classList.remove(subListClassVisible);
        });

        buttons.forEach(function (button) {
            button.classList.remove(buttonClassVisible);
        });
    });

    // Re-check for overflow issues on window resize.
    window.addEventListener('resize', function () {
        window.clearTimeout(timer);
        timer = window.setTimeout(toggleOverflowClass, 50);
    });
});
