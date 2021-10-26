// Placeholder on-click function
var imClicked = () => console.log("Welldone, you clicked the button!")

// Load after DOM
$(function () {

    // Vars
    var storedTheme = localStorage.getItem("Colour preference")
    var preferedTheme = window.matchMedia("(prefers-color-scheme: dark)")

    // Set to users prefered theme
    if (preferedTheme.matches) {
        document.body.classList.add("darkmode")
        document.body.classList.add("darkmode")
    } else {
        document.body.classList.remove("darkmode")
    }

    // Set to stored theme
    if (storedTheme == "(prefers-color-scheme: light)") {
        document.body.classList.remove("darkmode")
    } else {
        document.body.classList.add("darkmode")
    }

    // Set up search bar
    var searchButton = document.querySelector("#menusearch");
    var navBar = document.querySelector(".navbar");
    const div = document.createElement("div");
    var logoElem = document.querySelector(".navleft .menuitem");

    /**
     * insertAfter function
     **/
    function insertAfter(referenceNode, newNode) {
        referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
    }

    searchButton.addEventListener("click", function () {
        if (!searchButton.classList.contains("search")) {
            insertAfter(logoElem, div);
            $(searchButton).addClass("search");
            $(navBar).addClass("navsearch");
            div.className = "menuitem notme";
            div.id = "searchdiv";
            div.innerHTML = "<input type='text' placeholder='Search'>";

        } else {
            $(searchButton).removeClass("search");
            $(navBar).removeClass("navsearch");
            div.remove();
        }
    });
});

// On-click event for darkmode toggle + store user pref
function toggleDarkmode() {
    document.body.classList.toggle("darkmode");

    if (document.body.classList.contains("darkmode")) {
        setTheme = "(prefers-color-scheme: dark)";
    } else {
        setTheme = "(prefers-color-scheme: light)";
    }
    localStorage.setItem("Colour preference", setTheme);
}

// Animated jump back to top
var toTop = () => $('html, body').animate({ scrollTop: 0 }, 'fast')

/**
 * @param {The element (id) that has been clicked} clickedID 
 */
function elementToggle(clickedID) {

    var togglebButton = document.getElementById(clickedID);
    var downArrow = "";
    var upArrow = "";

    if (togglebButton.innerHTML == upArrow) {
        togglebButton.innerHTML = downArrow;

    } else {
        togglebButton.innerHTML = upArrow;
    }

    var toggleTargets = getMatchingSiblings(togglebButton, ".toggle-target");

    for (var loop = 0; loop < toggleTargets.length; loop++) {
        if (toggleTargets[loop].getAttribute('style') == 'display: none;') {
            toggleTargets[loop].setAttribute('style', null);
        } else {
            toggleTargets[loop].setAttribute('style', 'display: none;');
        }
    }

}

/**
 * Function to find all sibling elements of a given class
 * 
 * @param {The base element id} id 
 * @param {The selector (class / id) of the target element} selector 
 * @returns {An array of elements}
 */
function getMatchingSiblings(id, selector) {

    var array = new Array();
    // Get the next sibling element
    var sibling = id.nextElementSibling;

    // If no selector, return the first sibling
    if (!selector) {
        array.push(sibling);
    } else {
        // If the sibling matches selector, add to array
        // If not, jump to the next sibling and continue the loop
        while (sibling) {
            if (sibling.matches(selector)) {
                array.push(sibling);
            }
            sibling = sibling.nextElementSibling;
        }
    }

    return array;

};

function dropDown() {
    var dropdown = document.querySelector(".dropdown");
    if (dropdown.style.display != "none") {
        dropdown.style.display = "none";
    } else {
        dropdown.style.display = "block";
    }
}

Object.size = function (obj) {
    var size = 0,
        key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

/**
* FROM: https://stackoverflow.com/questions/37002681/subtract-days-months-years-from-a-date-in-javascript
*/
function getDate(inputDate, days, months, years) {
    return new Date(
        inputDate.getFullYear() + years,
        inputDate.getMonth() + months,
        Math.min(
            inputDate.getDate() + days,
            new Date(inputDate.getFullYear() + years, inputDate.getMonth() + months + 1, 0).getDate()
        )
    )
}


/**
 * 
 * FROM: https://stackoverflow.com/questions/46155/how-to-validate-an-email-address-in-javascript
 */
function validateEmailFormat(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function validatePasswordFormat(password) {
    // Bcrypt MAX length is 72 chars
    if (password.length >= 7 && password.length <= 72) {
        var re = /(?=.*\d)/;
        return re.test(password);
    } else {
        return false
    }

}

function validateDisplayNameFormat(name) {
    if (name.length >= 4 && name.length <= 18) {
        var re = /^[A-Za-z]+$/;
        return re.test(name);
    } else {
        return false
    }

}

/**
 * Checks password (plain text password) against hash (hashed password)
 * 
 * Uses node.js and this package ->
 * https://github.com/dcodeIO/bcrypt.js
 * (npm install bcryptjs)
 */
function checkHashedPassword(password, hash) {
    var bcrypt = require('bcryptjs');
    return bcrypt.compareSync(password, hash);
}