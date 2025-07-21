
  document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.querySelector('.carousel-caves');
    const slots = document.querySelectorAll('.cave-slot');
    const leftBtn = document.querySelector('.carousel-arrow.left');
    const rightBtn = document.querySelector('.carousel-arrow.right');

    const itemsPerPage = 4;
    const totalItems = slots.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    let currentPage = 0;

    function updateCarousel() {
      const slideWidth = carousel.offsetWidth;
      const offset = currentPage * slideWidth;
      carousel.style.transform = `translateX(-${offset}px)`;
    }

    rightBtn.addEventListener('click', () => {
      if (currentPage < totalPages - 1) {
        currentPage++;
        updateCarousel();
      }
    });

    leftBtn.addEventListener('click', () => {
      if (currentPage > 0) {
        currentPage--;
        updateCarousel();
      }
    });

    // Resize support (optional)
    window.addEventListener('resize', updateCarousel);
  });

