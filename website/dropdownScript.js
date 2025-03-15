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

// global leveltwos variable
let leveltwos = 0;

// for each dropdown button run this function
dropdowns.forEach((dropdown) => {
    // expanded = false
    let expanded = false;
    // add an onclick event listener to each dropdown button
    dropdown.addEventListener("click", (event) => {
        // Prevent event from bubbling up and affecting parent dropdowns
        event.stopPropagation();

        // get does this dropdown contain or is this dropdown a level2
        const l2 = dropdown.querySelector(".leveltwo");
        if (l2 != null) {
            // if level2 dropdowns found increase or decrease amount of them showing by checking is it expanded or not
            leveltwos += expanded ? -1 : 1;
            // change the parent dropdown height to accomodate for the extra height of the level2 dropdown
            l2.parentElement.parentElement.style.maxHeight = l2.scrollHeight * leveltwos + 'px';
        }

        // get the ul element of the currently clicked dropdown
        const ul = dropdown.querySelector("ul");

        // if it's not expanded, then expand it
        if (!expanded) {
            // get the non hidden uls inside the dropdown
            const elements = dropdown.querySelector("ul:not(.hidden *)");
            if (!elements) {
                return; // if null return, this prevents an error occurring when spam clicking level 2 dropdowns before the animation is finished
            }
            // get the total height of the elements and apply it as the ul maxheight
            ul.style.maxHeight = elements.scrollHeight + 'px';

            // wait for the animation to finish to prevent visual glitches
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
        dropdown.querySelector(".material-symbols-outlined").classList.toggle("arrow");
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