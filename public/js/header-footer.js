(function () {
    var header = document.getElementById("dashHeader");
    var userMenu = document.getElementById("dashUser");
    var userBtn = document.getElementById("dashUserTrigger");
    var toggle = document.getElementById("dashNavToggle");
    var themeBtn = document.getElementById("dashThemeToggle");

    window.addEventListener(
        "scroll",
        function () {
            header.classList.toggle("is-scrolled", window.scrollY > 4);
        },
        { passive: true },
    );

    userBtn.addEventListener("click", function () {
        var open = userMenu.classList.toggle("is-open");
        userBtn.setAttribute("aria-expanded", open);
    });

    document.addEventListener("click", function (e) {
        if (!userMenu.contains(e.target)) {
            userMenu.classList.remove("is-open");
            userBtn.setAttribute("aria-expanded", "false");
        }
    });

    toggle.addEventListener("click", function () {
        var open = header.classList.toggle("nav-open");
        toggle.classList.toggle("is-open", open);
        toggle.setAttribute("aria-expanded", open);
    });

    var MOON_SVG =
        '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>';
    var SUN_SVG =
        '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>';

    var isLight = localStorage.getItem("dash-theme") === "light";

    function applyTheme(light, animate) {
        if (animate) {
            document.documentElement.classList.add("theme-transitioning");
            setTimeout(function () {
                document.documentElement.classList.remove(
                    "theme-transitioning",
                );
            }, 350);
        }
        document.documentElement.classList.toggle("light-mode", light);
        themeBtn.innerHTML = light ? MOON_SVG : SUN_SVG;
        themeBtn.setAttribute(
            "aria-label",
            light ? "Switch to dark mode" : "Switch to light mode",
        );
        themeBtn.setAttribute(
            "title",
            light ? "Switch to dark mode" : "Switch to light mode",
        );
    }

    applyTheme(isLight, false);

    themeBtn.addEventListener("click", function () {
        isLight = !isLight;
        localStorage.setItem("dash-theme", isLight ? "light" : "dark");
        applyTheme(isLight, true);
    });
})();
