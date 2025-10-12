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
