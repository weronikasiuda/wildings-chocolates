// Add a class to the root element immediately to signify that JavaScript has
// loaded and has been parsed.
document.documentElement.classList.add('js');

// jQuery/Zepto
var $$;

if (typeof $ === 'function') {
    $$ = $;
} else if (typeof jQuery === 'function') {
    $$ = jQuery;
} else if (typeof Zepto === 'function') {
    $$ = Zepto;
}

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

// Bootstrap 5 carousel
// https://getbootstrap.com/docs/5.2/components/carousel/
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.carousel').forEach(function (carousel, carouselIndex) {
        let carouselId = carousel.getAttribute('id');
        let prevButton = carousel.querySelector('.carousel-control-prev');
        let nextButton = carousel.querySelector('.carousel-control-next');
        let indicators = carousel.querySelector('.carousel-indicators');

        // Make sure each carousel has a unique ID.
        if (!carouselId) {
            carouselId = 'carousel-' + carouselIndex;
            carousel.setAttribute('id', carouselId);
        }

        // Add the Bootstrap carousel animation class.
        carousel.classList.add('slide');

        // Make sure the carousel has previous and next controls.
        if (!prevButton) {
            prevButton = document.createElement('button');

            prevButton.setAttribute('class', 'carousel-control-prev');
            prevButton.setAttribute('type', 'button');
            prevButton.setAttribute('data-bs-target', '#' + carouselId);
            prevButton.setAttribute('data-bs-slide', 'prev');

            prevButton.innerHTML = '<span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="screen-reader-text">Previous</span>';

            carousel.appendChild(prevButton);
        }

        if (!nextButton) {
            nextButton = document.createElement('button');

            nextButton.setAttribute('class', 'carousel-control-next');
            nextButton.setAttribute('type', 'button');
            nextButton.setAttribute('data-bs-target', '#' + carouselId);
            nextButton.setAttribute('data-bs-slide', 'next');

            nextButton.innerHTML = '<span class="carousel-control-next-icon" aria-hidden="true"></span><span class="screen-reader-text">Next</span>';

            carousel.appendChild(nextButton);
        }

        // Make sure the carousel has indicator controls.
        if (!indicators) {
            indicators = document.createElement('div');
            indicators.setAttribute('class', 'carousel-indicators');

            carousel.querySelectorAll('.carousel-item').forEach(function (item, itemIndex) {
                let indicator = document.createElement('button');

                indicator.setAttribute('type', 'button');
                indicator.setAttribute('data-bs-target', '#' + carouselId);
                indicator.setAttribute('data-bs-slide-to', itemIndex);

                indicator.innerHTML = '<span class="screen-reader-text">Slide ' + (itemIndex + 1) + '</span>';

                indicators.appendChild(indicator);
            });

            indicators.firstChild.classList.add('active');
            carousel.appendChild(indicators);
        }

        // Initialize carousel.
        new bootstrap.Carousel(carousel, {
            interval: 8000,
            ride: 'carousel'
        });

        // Lightbox effect
        // https://dimsemenov.com/plugins/magnific-popup/
        if (typeof $$ === 'function' && typeof $$.fn.magnificPopup === 'function') {
            $$(carousel).magnificPopup({
                type: 'image',
                delegate: 'a',
                gallery: {
                    enabled: true
                }
            });
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    if (typeof $$ === 'function' && typeof $$.fn.magnificPopup === 'function') {
        $$('.display-watch__card-video-link').each(function (linkIndex, linkNode) {
            $$(linkNode).magnificPopup({
                type: 'iframe'
            });
        });
    }
});

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

// Image grid lightbox effect
// https://dimsemenov.com/plugins/magnific-popup/
document.addEventListener('DOMContentLoaded', function () {
    if (typeof $$ === 'function' && typeof $$.fn.magnificPopup === 'function') {
        $$('.image-grid').each(function (gridIndex, gridNode) {
            $$(gridNode).magnificPopup({
                type: 'image',
                delegate: 'a',
                gallery: {
                    enabled: true
                }
            });
        });
    }
});

// Open Street Map embed
// https://leafletjs.com/
document.addEventListener('DOMContentLoaded', function () {
    if (typeof L === 'undefined') {
        return;
    }

    document.querySelectorAll('.map-embed').forEach(function (container) {
        let title = container.dataset.title;
        let icon = container.dataset.icon;
        let zoom = parseInt(container.dataset.zoom, 10);
        let lat = parseFloat(container.dataset.lat);
        let lng = parseFloat(container.dataset.lng);
        let tileUrl = container.dataset.tileUrl;

        let map;

        if (isNaN(lat) || isNaN(lng)) {
            return;
        }

        if (isNaN(zoom)) {
            zoom = 15;
        }

        // Fall back to default tiles
        if (!tileUrl) {
            tileUrl = 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';
        }

        map = L.map(container).setView([lat, lng], zoom);

        L.tileLayer(tileUrl, {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        if (icon) {
            L.marker([lat, lng], {
                icon: L.icon({
                    iconUrl: icon,
                    iconSize: [40, 40],
                    iconAnchor: [20, 35],
                }),
                title: title
            }).addTo(map);
        }
    });
});

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

var swiper = new Swiper(".mySwiper", {
    slidesPerView: 2,
    spaceBetween: 20,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    breakpoints: {
      // when window width is >= 640px
      640: {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      // when window width is >= 768px
      768: {
        slidesPerView: 3,
        spaceBetween: 20,
      },
      // when window width is >= 1024px
      1024: {
        slidesPerView: 4,
        spaceBetween: 40,
      },
    },
  });

  // Function to initialize Swiper sliders
function initTaxonomySwipers() {
  // Find all elements that match the unique slider class pattern
  const swiperContainers = document.querySelectorAll('[class*="mySwiper-"]');

  swiperContainers.forEach((container) => {
    // Extract the unique index from the class name (e.g., '1' from 'mySwiper-1')
    const uniqueIndex = container.className.match(/mySwiper-(\d+)/)[1];

    // Initialize Swiper for the current container
    new Swiper(container, {
      slidesPerView: 2,
    spaceBetween: 20,
      navigation: {
        nextEl: `.swiper-button-next-${uniqueIndex}`,
        prevEl: `.swiper-button-prev-${uniqueIndex}`,
      },
      // You can add breakpoints here for responsiveness if needed
      breakpoints: {
        // when window width is >= 640px
        640: {
          slidesPerView: 3,
          spaceBetween: 20,
        },
        // when window width is >= 768px
        768: {
          slidesPerView: 3,
          spaceBetween: 20,
        },
        // when window width is >= 992px
        992: {
          slidesPerView: 4,
          spaceBetween: 30,
        },
      },
    });
  });
}

// Initialize sliders when the DOM is ready
document.addEventListener('DOMContentLoaded', initTaxonomySwipers);
// Product image lightbox
// https://dimsemenov.com/plugins/magnific-popup/
document.addEventListener('DOMContentLoaded', function () {
    if (typeof $$ === 'function' && typeof $$.fn.magnificPopup === 'function') {
        $$('.woocommerce-product-gallery').magnificPopup({
            type: 'image',
            delegate: 'a',
            gallery: {
                enabled: true
            }
        });
    }
});

//# sourceMappingURL=main.js.map
