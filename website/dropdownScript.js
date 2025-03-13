const uls = document.querySelectorAll(".dropdown > ul");
const dropdowns = document.querySelectorAll(".dropdown");

uls.forEach((ul) => {
    ul.style.maxHeight = '0px';
    ul.classList.toggle("hidden");
});
let leveltwos = 1;
const doubleSize = 182.4;

dropdowns.forEach((dropdown) => {
    let expanded = false;
    dropdown.addEventListener("click", (event) => {
        // Prevent event from bubbling up and affecting parent dropdowns
        event.stopPropagation();

        const li = dropdown.querySelectorAll("li");

        let totalHeight = 0;
        li.forEach((l) => {
            totalHeight = totalHeight + parseFloat(getComputedStyle(l).paddingTop) + (parseFloat(getComputedStyle(l).fontSize) * 1.6);
        });

        const mgm = dropdown.querySelector(".management");
        if (mgm != null) {
            totalHeight = totalHeight * 1.6;
        }

        const dd = dropdown.querySelector(".double");
        if (dd != null) {
            totalHeight = totalHeight / 3 * leveltwos;
        }

        const l2 = dropdown.querySelector(".leveltwo");
        if (l2 != null) {
            const parent = l2.parentElement.parentElement;
            if (!expanded) {
                leveltwos++;
            } else {
                leveltwos--;
            }
            parent.style.maxHeight = doubleSize * leveltwos + 'px';
        }

        const ul = dropdown.querySelector("ul");
        if (!expanded) {
            ul.style.maxHeight = totalHeight + 'px';
            ul.addEventListener("transitionend", () => {
                ul.classList.toggle("hidden");
            }, { once: true });
        } else {
            ul.style.maxHeight = '0px';
            ul.classList.toggle("hidden");
        }
        expanded = !expanded;

        const button = dropdown.querySelector(".material-symbols-outlined");
        button.classList.toggle("arrow");
    });
});

window.addEventListener("load", () => {
    const sidenav = document.querySelector(".sidenav");
    const anchors = sidenav.querySelectorAll("a");

    // loops through every anchor on the sidenav
    let i = 0;
    // checks if the href of the anchor is the same as the current page
    // continue looping if it's not
    while (i < anchors.length && (window.location.href !== anchors[i].href)) {
        i++
    }
    // if we got to the end of all the anchors, return because there is no matching href
    if (i >= anchors.length) return;

    // adds the active class
    anchors[i].classList.add("active");

    // continues to expand the dropdown for it
    const dropdown = anchors[i].parentElement.parentElement.parentElement;
    // checks if it is a dropdown
    if (dropdown.classList.contains("dropdown")) {
        // continues to expand the double dropdown for it
        const doubleDropdown = dropdown.parentElement.parentElement;
        // checks if it is a double dropdown
        if (doubleDropdown.classList.contains("dropdown")) {
            // expand the double dropdown
            doubleDropdown.click();
        }
        // expand the dropdown
        dropdown.click();
    }
});
