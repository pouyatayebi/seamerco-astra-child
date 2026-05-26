    document.addEventListener("DOMContentLoaded", function () {
      var section = document.querySelector(".seamerco-process-section");
      if (!section) return;

      var map = section.querySelector(".seamerco-process-map");
      var image = section.querySelector(".seamerco-process-image");
      var hotspotsLayer = section.querySelector(".seamerco-hotspots");

      var hotspots = section.querySelectorAll(".seamerco-hotspot");
      var accordionItems = section.querySelectorAll(".seamerco-process-accordion .wp-block-accordion-item");

      function closeHotspots() {
        hotspots.forEach(function (item) {
          item.classList.remove("is-active");
        });
      }

      function closeOtherAccordions(activeIndex) {
        accordionItems.forEach(function (item, index) {
          if (index === activeIndex) return;

          var button = item.querySelector(".wp-block-accordion-heading__toggle");
          if (!button) return;

          var isOpen =
            item.classList.contains("is-open") ||
            button.getAttribute("aria-expanded") === "true";

          if (isOpen) {
            button.click();
          }
        });
      }

      function activateHotspot(index) {
        closeHotspots();

        if (hotspots[index]) {
          hotspots[index].classList.add("is-active");
        }
      }

      hotspots.forEach(function (hotspot, index) {
        var button = hotspot.querySelector("a, button, .uagb-buttons-repeater");

        if (!button) return;

        button.addEventListener("click", function (event) {
          event.preventDefault();
          event.stopPropagation();

          activateHotspot(index);
          closeOtherAccordions(index);

          var accordion = accordionItems[index];
          if (!accordion) return;

          var accordionButton = accordion.querySelector(".wp-block-accordion-heading__toggle");
          if (!accordionButton) return;

          var isOpen =
            accordion.classList.contains("is-open") ||
            accordionButton.getAttribute("aria-expanded") === "true";

          if (!isOpen) {
            accordionButton.click();
          }
        });
      });

      accordionItems.forEach(function (accordion, index) {
        var accordionButton = accordion.querySelector(".wp-block-accordion-heading__toggle");

        if (!accordionButton) return;

        accordionButton.addEventListener("click", function () {
          setTimeout(function () {
            var isOpen =
              accordion.classList.contains("is-open") ||
              accordionButton.getAttribute("aria-expanded") === "true";

            if (isOpen) {
              closeOtherAccordions(index);
              activateHotspot(index);
            } else if (hotspots[index]) {
              hotspots[index].classList.remove("is-active");
            }
          }, 150);
        });
      });

      section.querySelectorAll(".seamerco-hotspot-close").forEach(function (closeButton) {
        closeButton.addEventListener("click", function (event) {
          event.preventDefault();
          event.stopPropagation();
          closeHotspots();
        });
      });

      document.addEventListener("click", function (event) {
        var isInsideHotspot = event.target.closest(".seamerco-hotspot");
        var isInsideAccordion = event.target.closest(".seamerco-process-accordion");
        var isZoomButton = event.target.closest(".seamerco-zoom-controls");

        if (!isInsideHotspot && !isInsideAccordion && !isZoomButton) {
          closeHotspots();
        }
      });

      if (map && image) {
        var zoomControls = document.createElement("div");
        zoomControls.className = "seamerco-zoom-controls";
        zoomControls.innerHTML =
          '<button type="button" class="seamerco-zoom-btn" data-zoom="in" aria-label="Zoom in">+</button>' +
          '<button type="button" class="seamerco-zoom-btn" data-zoom="out" aria-label="Zoom out">−</button>';

        map.appendChild(zoomControls);

        var scale = 1;
        var posX = 0;
        var posY = 0;
        var isDragging = false;
        var startX = 0;
        var startY = 0;

        function applyTransform() {
          var transform = "translate(" + posX + "px, " + posY + "px) scale(" + scale + ")";

          image.style.transform = transform;

          if (hotspotsLayer) {
            hotspotsLayer.style.transform = transform;
            hotspotsLayer.style.transformOrigin = "center center";
          }
        }

        function setScale(nextScale) {
          scale = Math.min(Math.max(nextScale, 1), 2.5);

          if (scale === 1) {
            posX = 0;
            posY = 0;
          }

          applyTransform();
        }

        zoomControls.addEventListener("click", function (event) {
          var btn = event.target.closest(".seamerco-zoom-btn");
          if (!btn) return;

          event.preventDefault();
          event.stopPropagation();

          if (btn.getAttribute("data-zoom") === "in") {
            setScale(scale + 0.2);
          } else {
            setScale(scale - 0.2);
          }
        });

        map.addEventListener("wheel", function (event) {
          event.preventDefault();

          var delta = event.deltaY > 0 ? -0.1 : 0.1;
          setScale(scale + delta);
        }, { passive: false });

        map.addEventListener("mousedown", function (event) {
          if (scale <= 1) return;
          if (event.target.closest(".seamerco-hotspot-card")) return;
          if (event.target.closest(".seamerco-zoom-controls")) return;

          isDragging = true;
          map.classList.add("is-dragging");

          startX = event.clientX - posX;
          startY = event.clientY - posY;
        });

        window.addEventListener("mousemove", function (event) {
          if (!isDragging) return;

          posX = event.clientX - startX;
          posY = event.clientY - startY;

          applyTransform();
        });

        window.addEventListener("mouseup", function () {
          isDragging = false;
          map.classList.remove("is-dragging");
        });
      }
    });