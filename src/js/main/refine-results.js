document.addEventListener('DOMContentLoaded', function () {
    let form = document.querySelector('#form');
    let results = document.querySelector('#results-list');

    let button;
    let observer;

    let buttonClass;
    let buttonClassHidden;

    if (!form || !results) {
        return;
    }

    buttonClass = 'refine-results-button';
    buttonClassHidden = buttonClass + '--hidden';

    // Create button
    button = document.createElement('button');
    button.innerHTML = 'Refine Your Search';
    button.classList.add(buttonClass, buttonClassHidden);
    button.setAttribute('type', 'button');

    button.addEventListener('click', function () {
        form.scrollIntoView({ behaviour: 'smooth' });
        form.querySelector('a, button, input').focus({ preventScroll: true });
    });

    results.after(button);

    // Show and hide button based on form visibility and scroll position
    observer = new IntersectionObserver(function (entries) {
        button.classList.toggle(buttonClassHidden, entries[0].isIntersecting || entries[0].boundingClientRect.top > 0);
    });

    observer.observe(form);
});
