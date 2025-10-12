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