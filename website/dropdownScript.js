// Authors: group work (Brandon Jaroszczak and Darian Byrne)
// First half entirely done by Brandon Jaroszczak (refactored and improved from original non-working code by Kyle Purcell)
// Second half entirely done by Darian Byrne
// Purpose: javascript for the dropdown menu animations and related functions


// This section done by Brandon Jaroszczak with help from Kyle Purcell
// Gets all uls and dropdowns
const uls = document.querySelectorAll(".dropdown > ul");
const dropdowns = document.querySelectorAll(".dropdown");

// For each ul make it hidden
uls.forEach((ul) => {
    ul.style.maxHeight = '0px';
    ul.classList.toggle("hidden");
});
// level2 variable
let leveltwos = 1;
// doublesize constant for animation height
const doubleSize = 182.4;

// for each dropdown button run this function
dropdowns.forEach((dropdown) => {
    // expanded = false
    let expanded = false;
    // add an onclick event listener to each dropdown button
    dropdown.addEventListener("click", (event) => {
        // Prevent event from bubbling up and affecting parent dropdowns
        event.stopPropagation();

        // get all lis in a dropdown
        const li = dropdown.querySelectorAll("li");

        // totalheight variable for each li increase the total height to get the height of all li inside a dropdown
        let totalHeight = 0;
        li.forEach((l) => {
            totalHeight = totalHeight + parseFloat(getComputedStyle(l).paddingTop) + (parseFloat(getComputedStyle(l).fontSize) * 1.6);
        });

        // if the dropdown is management make the height taller as some elements are 2 lines long
        const mgm = dropdown.querySelector(".management");
        if (mgm != null) {
            totalHeight = totalHeight * 1.6;
        }

        // if the dropdown is a double dropdown divide by 3 and multiply by the amount of selected level2s to get just one of the 3 dropdowns inside the double dropdown
        const dd = dropdown.querySelector(".double");
        if (dd != null) {
            totalHeight = totalHeight / 3 * leveltwos;
        }

        // get all level2 dropdowns inside this dropdown
        const l2 = dropdown.querySelector(".leveltwo");
        if (l2 != null) {
            // if there are any increase or decrease the amount of shown level2 dropdowns
            const parent = l2.parentElement.parentElement;
            if (!expanded) {
                leveltwos++;
            } else {
                leveltwos--;
            }
            // change the parent dropdown's height to accomodate for the increase in level2 dropdowns being shown
            parent.style.maxHeight = doubleSize * leveltwos + 'px';
        }

        // get the ul element of the currently clicked dropdown
        const ul = dropdown.querySelector("ul");
        if (!expanded) {
            // if it's not expanded, then expand it and wait for the animation to finish to prevent visual glitches
            ul.style.maxHeight = totalHeight + 'px';
            ul.addEventListener("transitionend", () => {
                ul.classList.toggle("hidden");
            }, { once: true });
        } else {
            // if it's expanded, then hide it
            ul.style.maxHeight = '0px';
            ul.classList.toggle("hidden");
        }
        // toggle the expanded variable
        expanded = !expanded;

        // get the button arrow and toggle it up or down facing
        const button = dropdown.querySelector(".material-symbols-outlined");
        button.classList.toggle("arrow");
    });
});

// This section done by Darian Byrne
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
