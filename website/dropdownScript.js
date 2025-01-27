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
            totalHeight = totalHeight + parseFloat(getComputedStyle(l).paddingTop) + (parseFloat(getComputedStyle(l).fontSize)*1.6);
        });

        const mgm = dropdown.querySelector(".management");
        if (mgm != null) {
            totalHeight = totalHeight*1.6;
        }

        const dd = dropdown.querySelector(".double");
        if (dd != null) {
            totalHeight = totalHeight/3*leveltwos;
        }

        const l2 = dropdown.querySelector(".leveltwo");
        if (l2 != null) {
            const parent = l2.parentElement.parentElement;
            if (!expanded) {
                leveltwos++;
            } else {
                leveltwos--;
            }
            parent.style.maxHeight = doubleSize*leveltwos+'px';
        }

        const ul = dropdown.querySelector("ul");
        if (!expanded) {
            ul.style.maxHeight = totalHeight+'px';
            ul.addEventListener("transitionend", () => {
                ul.classList.toggle("hidden");
            }, {once: true});
        } else {
            ul.style.maxHeight = '0px';
            ul.classList.toggle("hidden");
        }
        expanded = !expanded;

        const button = dropdown.querySelector(".material-symbols-outlined");
        button.classList.toggle("arrow");
    });
});