document.addEventListener("DOMContentLoaded", function () {
  const mobileQuery = window.matchMedia("(max-width: 781px)");

  function initMobileMenu() {
    const items = document.querySelectorAll(
      ".seamerco-main-menu .wp-block-navigation-item.has-child"
    );

    items.forEach((item) => {
      const submenu = item.querySelector(
        ":scope > .wp-block-navigation__submenu-container"
      );

      if (!submenu) return;

      let toggle = item.querySelector(":scope > .seamerco-mobile-toggle");

      if (!toggle) {
        toggle = document.createElement("button");

        toggle.type = "button";
        toggle.className = "seamerco-mobile-toggle";
        toggle.setAttribute("aria-label", "باز و بسته کردن زیرمنو");

        item.appendChild(toggle);
      }

      if (toggle.dataset.ready === "true") return;

      toggle.dataset.ready = "true";

      toggle.addEventListener("click", function (event) {
        if (!mobileQuery.matches) return;

        event.preventDefault();
        event.stopPropagation();

        item.classList.toggle("seamerco-mobile-open");
      });
    });
  }

  initMobileMenu();

  document.addEventListener("click", function (event) {
    if (
      event.target.closest(
        ".wp-block-navigation__responsive-container-open"
      )
    ) {
      setTimeout(initMobileMenu, 200);
    }
  });
});