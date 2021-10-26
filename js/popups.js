/*

EXAMPLE STRUCTURE

<div class="input-container posRel">
    <input class="input-dropdown-input" id="app-genre-input" type="text" name="test" title="App genre" placeholder="App Genre" maxlength="32" required />
    <div class="popup">
        <span class="popuptext">Invalid filter.</span>
     </div>
    <div class="search-container"></div>
</div>

use .clearer and float if positioning messed up!
*/


/**
 * @param {The element to popup on} thisElement 
 * @param {The number in the list of elements for the required popup NOTE: every odd number, due to :after pseudo-element} num 
 */
var runPopup = (thisElement, num) => {
    var popup = thisElement.parentElement.querySelector('.popup').childNodes[num]
    if (!popup.classList.contains("show")) {
        popup.classList.add("show")
        setTimeout(() => {
            popup.classList.remove("show")
        }, 3000)
    }
}