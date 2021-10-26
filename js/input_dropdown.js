/*
Example structure required + tags =>

<div class="input-container posRel">
    <input class="input-dropdown-input" id="SOME-ID-HERE">
    <div class="search-container" id="LIST-ID">
    
    <!-- EXAMPLE DROPDOWNS GENERATED (NUM = loop number)
        <div class="filter-search unselectable" id="filter-search-NUM" onmouseover="previewValue(this.id)" onmouseout="replaceValue(this.id)" onclick="setValue(this.id)">
            Some text in here
        </div>
    -->

    </div>
</div>

use .clearer and float if positioning messed up!
*/

// Globals
var holder

var searchDropDown = (inputId, targetFilterArray, col) => {
    var input = document.getElementById(inputId)
    var search = input.value.toUpperCase()
    var blacklist = new Array()
    targetFilterArray = targetFilterArray['data']
    // Clear previous dropdown
    clearOldSearch(inputId)

    if (targetFilterArray != null) {
        for (loop = 0; loop < 5; loop++) {
            for (innerLoop = 0; innerLoop < targetFilterArray.length; innerLoop++) {
                var name = targetFilterArray[innerLoop][col]
                if (name.toUpperCase().indexOf(search) == 0 && !blacklist.includes(name)) {
                    createElement(name, inputId, loop)
                    blacklist.push(name)
                    break
                }
            }
        }
    }
}

var clearOldSearch = inputId => {
    var input = document.getElementById(inputId)
    var oldSearch = document.getElementsByClassName("filter-search")
    var parent = input.parentElement
    var container = parent.querySelector('.search-container')
    while (oldSearch.length > 0) {
        container.removeChild(container.lastChild)
    }
}

var createElement = (appName, inputId, num) => {
    var input = document.getElementById(inputId)
    var parent = input.parentElement
    var container = parent.querySelector('.search-container')

    var element = document.createElement("div")
    element.classList.add("filter-search")
    element.classList.add("unselectable")
    element.setAttribute("id", "filter-search-" + num)
    element.setAttribute("onmouseover", "previewValue(this.id)")
    element.setAttribute("onmouseout", "replaceValue(this.id)")
    element.setAttribute("onclick", "setValue(this.id)")
    element.innerText = appName

    container.appendChild(element)
}

// Set value on click
var setValue = dropId => {
    var clickedElem = document.getElementById(dropId)
    var text = clickedElem.innerText
    var input = clickedElem.parentElement.parentElement.querySelector(".input-dropdown-input")
    input.value = text

    inputId = input.getAttribute("id")
    clearOldSearch(inputId)
}

// Preview the option on mouse-over
var previewValue = dropId => {
    var clickedElem = document.getElementById(dropId)
    var text = clickedElem.innerText
    var input = clickedElem.parentElement.parentElement.querySelector(".input-dropdown-input")

    holder = input.value
    input.value = text
}

// Replace typed value on mouse-out
var replaceValue = dropId => {
    var clickedElem = document.getElementById(dropId)
    var input = clickedElem.parentElement.parentElement.querySelector(".input-dropdown-input")

    input.value = holder
}