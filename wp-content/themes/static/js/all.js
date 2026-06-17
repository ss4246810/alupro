//// Best Nav Dropdown Starts
const mobileBtn = document.getElementById("mobile-menu-button");
const mobileMenu = document.getElementById("mobile-menu");

mobileBtn.addEventListener("click", () => {
  mobileMenu.classList.toggle("hidden");

  const icon = mobileBtn.querySelector("i");
  icon.classList.toggle("fa-bars");
  icon.classList.toggle("fa-xmark");

  if (mobileMenu.classList.contains("hidden")) {
    closeMobileDropdowns();
  }
});

function closeMobileDropdowns() {
  document.querySelectorAll("#mobile-menu .mobile-dropdown").forEach((item) => {
    item.classList.add("hidden");
  });

  document.querySelectorAll("#mobile-menu button i").forEach((item) => {
    item.classList.remove("rotate-180");
  });
}

function toggleMobileDropdown(btn) {
  const dropdown = btn.nextElementSibling;
  const icon = btn.querySelector("i");
  const isOpen = !dropdown.classList.contains("hidden");

  closeMobileDropdowns();

  if (!isOpen) {
    dropdown.classList.remove("hidden");
    icon.classList.add("rotate-180");
  }
}

const desktopDropdownGroups = document.querySelectorAll(
  ".desktop-dropdown-group",
);

function closeFocusedDesktopDropdowns(exceptGroup = null) {
  desktopDropdownGroups.forEach((group) => {
    if (group === exceptGroup) return;

    const focusedItem = group.querySelector(":focus");
    if (focusedItem) {
      focusedItem.blur();
    }
  });
}

desktopDropdownGroups.forEach((group) => {
  group.addEventListener("mouseenter", () =>
    closeFocusedDesktopDropdowns(group),
  );
  group.addEventListener("click", () => closeFocusedDesktopDropdowns(group));
});

document.addEventListener("click", (event) => {
  if (!event.target.closest(".desktop-dropdown-group")) {
    closeFocusedDesktopDropdowns();
  }
});

document.querySelectorAll("#mobile-menu a").forEach((link) => {
  link.addEventListener("click", () => {
    mobileMenu.classList.add("hidden");
    closeMobileDropdowns();

    const icon = mobileBtn.querySelector("i");
    icon.classList.add("fa-bars");
    icon.classList.remove("fa-xmark");
  });
});

window.addEventListener("scroll", () => {
  const navbar = document.getElementById("navbar");

  if (window.scrollY > 30) {
    navbar.classList.add("shadow-md");
  } else {
    navbar.classList.remove("shadow-md");
  }
});
//// Best Nav Dropdown Ends

//// Quote Modal Starts
const quoteModal = document.getElementById("quote-modal");
const quoteModalOpeners = document.querySelectorAll(".js-quote-modal-open");
const quoteModalClosers = document.querySelectorAll(".js-quote-modal-close");
let quoteLastFocusedElement = null;

function openQuoteModal() {
  if (!quoteModal) return;

  quoteLastFocusedElement = document.activeElement;
  quoteModal.classList.remove("hidden");
  quoteModal.classList.add("flex");
  document.body.classList.add("overflow-hidden");

  const firstField = quoteModal.querySelector("input, textarea, button");
  if (firstField) firstField.focus();
}

function closeQuoteModal() {
  if (!quoteModal) return;

  quoteModal.classList.add("hidden");
  quoteModal.classList.remove("flex");
  document.body.classList.remove("overflow-hidden");

  if (quoteLastFocusedElement) {
    quoteLastFocusedElement.focus();
  }
}

quoteModalOpeners.forEach((button) => {
  button.addEventListener("click", () => {
    if (mobileMenu && !mobileMenu.classList.contains("hidden")) {
      mobileMenu.classList.add("hidden");
      closeMobileDropdowns();
    }

    openQuoteModal();
  });
});

quoteModalClosers.forEach((button) => {
  button.addEventListener("click", closeQuoteModal);
});

document.addEventListener("keydown", (event) => {
  if (
    event.key === "Escape" &&
    quoteModal &&
    !quoteModal.classList.contains("hidden")
  ) {
    closeQuoteModal();
  }
});
//// Quote Modal Ends

//// Product Carousels Starts
function setupProductCarousel(carouselId, prevId, nextId, slideSelector) {
  const carousel = document.getElementById(carouselId);
  const prev = document.getElementById(prevId);
  const next = document.getElementById(nextId);

  if (!carousel || !prev || !next) return;

  function getStep() {
    const slide = carousel.querySelector(slideSelector);
    if (!slide) return carousel.clientWidth;

    const gap = parseFloat(getComputedStyle(carousel).columnGap) || 0;
    return Math.round(slide.getBoundingClientRect().width + gap);
  }

  function updateControls() {
    const maxScroll = carousel.scrollWidth - carousel.clientWidth - 2;
    const hasOverflow = maxScroll > 2;
    const controlsContainer = prev.parentElement;

    controlsContainer.style.display = hasOverflow ? "" : "none";

    if (!hasOverflow) return;

    prev.disabled = carousel.scrollLeft <= 2;
    next.disabled = carousel.scrollLeft >= maxScroll;

    [prev, next].forEach((button) => {
      button.classList.toggle("opacity-40", button.disabled);
      button.classList.toggle("cursor-not-allowed", button.disabled);
    });
  }

  prev.addEventListener("click", () => {
    carousel.scrollBy({
      left: -getStep(),
      behavior: "smooth",
    });
  });

  next.addEventListener("click", () => {
    carousel.scrollBy({
      left: getStep(),
      behavior: "smooth",
    });
  });

  carousel.addEventListener("scroll", updateControls);
  window.addEventListener("resize", updateControls);
  window.addEventListener("resize", () => {
    carousel.scrollTo({
      left: Math.round(carousel.scrollLeft / getStep()) * getStep(),
      behavior: "auto",
    });
  });
  updateControls();
}

setupProductCarousel(
  "materials-carousel",
  "materials-prev",
  "materials-next",
  ".materials-slide",
);
setupProductCarousel(
  "specialty-carousel",
  "specialty-prev",
  "specialty-next",
  ".specialty-slide",
);
setupProductCarousel(
  "structural-carousel",
  "structural-prev",
  "structural-next",
  ".structural-slide",
);
setupProductCarousel(
  "aerospace-carousel",
  "aerospace-prev",
  "aerospace-next",
  ".aerospace-slide",
);
setupProductCarousel(
  "extrusions-carousel",
  "extrusions-prev",
  "extrusions-next",
  ".extrusions-slide",
);
//// Product Carousels Ends


  //// Infinate Logos Scroll Starts
  const marquee = document.getElementById("marquee");
  const container = document.getElementById("marquee-container");

  if (marquee && container) {
    let pos = 0;
    let paused = false;
    let dragging = false;
    let holdTimer = null;
    let startX = 0;
    let startPos = 0;
    const HOLD_DELAY = 150;
    document.querySelectorAll("#marquee img").forEach(img => {
      img.setAttribute("draggable", "false");
    });

    function updateCursor() {
      container.style.cursor = dragging ? "grabbing" : paused ? "grab" : "default";
    }
    container.addEventListener("mouseenter", () => { paused = true; updateCursor(); });
    container.addEventListener("mouseleave", () => { paused = false; updateCursor(); });

    function startHold(x) {
      paused = true;
      startX = x;
      startPos = pos;
      updateCursor();
      holdTimer = setTimeout(() => { dragging = true; updateCursor(); }, HOLD_DELAY);
    }
    function dragMove(x) {
      if (!dragging) return;
      pos = startPos + (x - startX);
      marquee.style.transform = `translateX(${pos}px)`;
    }
    function endDrag() {
      clearTimeout(holdTimer);
      dragging = false;
      updateCursor();
    }

    container.addEventListener("mousedown", e => startHold(e.clientX));
    window.addEventListener("mousemove", e => dragMove(e.clientX));
    window.addEventListener("mouseup", endDrag);
    container.addEventListener("touchstart", e => startHold(e.touches[0].clientX));
    container.addEventListener("touchmove", e => dragMove(e.touches[0].clientX));
    container.addEventListener("touchend", endDrag);

    function setupMarquee() {
      marquee.querySelectorAll(".cloned").forEach(el => el.remove());
      const originals = Array.from(marquee.children);
      while (marquee.scrollWidth < container.offsetWidth * 2) {
        originals.forEach(el => {
          const clone = el.cloneNode(true);
          clone.classList.add("cloned");
          marquee.appendChild(clone);
        });
      }
      pos = 0;
    }
    window.addEventListener("resize", setupMarquee);

    function animate() {
      if (!paused && !dragging) {
        pos -= 0.5;
        if (Math.abs(pos) >= marquee.scrollWidth / 2) pos = 0;
        marquee.style.transform = `translateX(${pos}px)`;
      }
      requestAnimationFrame(animate);
    }
    setupMarquee();
    animate();
  }
  //// Infinate Logos Scroll Ends



  //// Scroll Top Custom Starts
  const scrollBtn = document.getElementById("scrollToTopBtn");

  if (scrollBtn) {
    const waBtn = document.getElementById("whatsappBtn");
    function checkScrollBtn() {
      var y = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
      var show = y > 200;
      scrollBtn.style.display = show ? "flex" : "none";
      if (waBtn) waBtn.style.bottom = show ? "4.4rem" : "1rem";
    }
    window.addEventListener("scroll", checkScrollBtn, { passive: true });
    setInterval(checkScrollBtn, 300);

    scrollBtn.addEventListener("click", () => {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }
  //// Scroll Top Custom Ends





  //// FAQ Starts
  document.querySelectorAll("#faq-accordion details").forEach((item) => {
    item.addEventListener("toggle", () => {
      if (!item.open) return;

      document.querySelectorAll("#faq-accordion details").forEach((faq) => {
        if (faq !== item) {
          faq.removeAttribute("open");
        }
      });
    });
  });
  //// FAQ Ends








































