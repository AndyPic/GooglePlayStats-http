// Globals
var holder, col, contentRating, developers, genres, numberOfInstalls, view, currentPage, pp, pos, params
var blacklist = new Array()
var targetFilterArray = new Array()
var wait = false;
var finished = false;
var queryString = window.location.search.substring(1);

// Set up view
if (queryString.includes("list")) {
    view = "list"
    currentPage = 1
    pp = 30
    pos = 0
} else {
    view = "icon"
    currentPage = 1
    pp = 20
    pos = 0
}

// Set up initial params for fetch
if (queryString == "") {
    params = "data&page=" + currentPage + "&pp=" + pp
} else {
    params = queryString + "&page=" + currentPage + "&pp=" + pp
}

// Load after DOM
$(function () {
    // After-dom globals
    var filterButton = document.getElementById("filter-button")
    var filterInput = document.getElementById("filter-input")


    // Search button
    document.getElementById("app-search-button").onclick = () => {
        var advancedSearch = document.getElementById("advanced-search-panel")
        var searchForm = document.getElementById("app-search-form")

        document.getElementById("view-input").value = view
        if (advancedSearch.classList.contains("hidden")) {
            // Normal search
            searchForm.submit()
        } else {
            // Advanced search
            var filterInput = document.getElementById("filter-input")
            var filterKey = filterInput.getAttribute("name")
            var filterValue = filterInput.value

            // Filter on
            if (filterInput.getAttribute("placeholder") !== "Filter by...") {

                var hiddenKey = document.getElementById("key-hidden-input")
                var hiddenValue = document.getElementById("value-hidden-input")

                hiddenKey.value = filterKey
                hiddenKey.setAttribute("name", "filter_key")

                hiddenValue.setAttribute("name", "filter_value")

                for (loop = 0; loop < targetFilterArray['data'].length; loop++) {
                    if (targetFilterArray['data'][loop][col] == filterValue) {
                        hiddenValue.value = targetFilterArray['data'][loop]['id']
                        break
                    }
                }

                if (hiddenValue.value == "") {
                    runPopup(filterInput, 1)
                    return
                }

            }

            // Get order
            var hiddenOrder = document.getElementById("order-hidden-input")

            var radioOrderValue = document.querySelector("input[name=order]:checked").value
            hiddenOrder.value = radioOrderValue
            hiddenOrder.setAttribute("name", "order")

            searchForm.submit()
        }
    }

    // View button
    document.getElementById("toggle-app-view").onclick = thisEvent => {
        var advancedSearch = document.getElementById("advanced-search-panel")
        var searchForm = document.getElementById("app-search-form")
        var viewInput = document.getElementById("view-input")
        var searchInput = document.getElementById("app-search")

        if (advancedSearch.classList.contains("hidden")) {
            if (view == "icon") {
                viewInput.value = "list"
                thisEvent.target.innerText = ""
            } else {
                viewInput.value = "icon"
                thisEvent.target.innerText = ""
            }
            searchForm.submit()
        } else {

        }

    }

    // Set up event listeners for INPUT
    filterInput.onblur = thisEvent => {
        // on-blur, remove
        clearOldSearch(thisEvent.target.getAttribute("id"))
    }

    filterInput.onfocus = thisEvent => {
        // on-focus, replace
        searchDropDown(thisEvent.target.getAttribute("id"), targetFilterArray, col)
    }

    filterInput.onkeyup = thisEvent => {
        // Set up search drop-down
        searchDropDown(thisEvent.target.getAttribute("id"), targetFilterArray, col)
    }

    document.getElementById("filter-none").onclick = () => {
        filterInput.setAttribute("placeholder", "Filter by...")
        filterInput.removeAttribute("name")
        filterInput.removeAttribute("value")
        filterButton.innerText = "NONE"
        targetFilterArray = null
    }

    document.getElementById("filter-genre").onclick = () => {
        filterInput.setAttribute("placeholder", "Genre")
        filterInput.setAttribute("name", "genre")
        filterInput.value = ""
        filterButton.innerText = "GENRE"

        targetFilterArray = genres
        col = 'genre'
    }

    document.getElementById("filter-installs").onclick = () => {
        filterInput.setAttribute("placeholder", "Installs")
        filterInput.setAttribute("name", "installs")
        filterInput.value = ""
        filterButton.innerText = "INSTALL"

        targetFilterArray = numberOfInstalls
        col = 'number'
    }

    document.getElementById("filter-rating").onclick = () => {
        filterInput.setAttribute("placeholder", "Age Rating")
        filterInput.setAttribute("name", "content_rating")
        filterInput.value = ""
        filterButton.innerText = "AGE"

        targetFilterArray = contentRating
        col = 'rating'
    }

    document.getElementById("filter-devs").onclick = () => {
        filterInput.setAttribute("placeholder", "Developers")
        filterInput.setAttribute("name", "developer")
        filterInput.value = ""
        filterButton.innerText = "DEV"

        targetFilterArray = developers
        col = 'developer'
    }

    document.getElementById("app-filter").onclick = () => {
        document.getElementById("advanced-search-panel").classList.toggle("hidden")
        document.querySelector(".app-bar").classList.toggle("advanced-search")

        document.getElementById("order-hidden-input").toggleAttribute("dissabled")
        document.getElementById("order-hidden-input").toggleAttribute("name")
        document.getElementById("order-hidden-input").toggleAttribute("value")

        document.getElementById("key-hidden-input").toggleAttribute("dissabled")
        document.getElementById("key-hidden-input").toggleAttribute("name")
        document.getElementById("key-hidden-input").toggleAttribute("value")

        document.getElementById("value-hidden-input").toggleAttribute("dissabled")
        document.getElementById("value-hidden-input").toggleAttribute("name")
        document.getElementById("value-hidden-input").toggleAttribute("value")
    }

})

$(window).on("scroll", function () {
    const scrollHeight = $(document).height()
    const scrollPos = Math.floor($(window).height() + $(window).scrollTop())
    const vh = window.innerHeight
    const isBottom = scrollHeight - vh < scrollPos

    // Load more apps when at bottom
    if (isBottom && !wait && !finished) {
        wait = true

        if (queryString == "") {
            params = "data&page=" + currentPage + "&pp=" + pp
        } else {
            params = queryString + "&page=" + currentPage + "&pp=" + pp
        }

        loadMoreApps(params)
    }

    // Display jump to top button when .5 vh away from top
    if (scrollPos > (vh + (0.5 * vh))) {
        document.getElementById("jumpToTop").setAttribute("style", "display:block")
    } else {
        document.getElementById("jumpToTop").setAttribute("style", "display:none")
    }

})

async function loadMoreApps(params) {

    await goGet("apps/data.php", params).then(response => {

        if (response.count == 0) {
            if (view === "list") {
                target = document.getElementById("apps-table")

                htmls = `<h2> No results found for this search </h2>`

                target.innerHTML += htmls

            } else {
                target = document.getElementById("icon-view-content")

                htmls = `<h2> No results found for this search </h2>`

                target.innerHTML += htmls
            }
        }


        if (view === "list") {
            // Load more list items
            target = document.getElementById("apps-table")
            htmls = ""

            response.data.forEach(data => {
                pos += 1
                html = `<a href='app_info.php?data=${data.id}' title='${data.name}'>
                                <div class='row'>
                                <div class='col-2-no'>${pos}</div>
                                <div class='col-4-no'>${data.name}</div>
                                <div class='col-4-no'>${data.genre}</div>
                                <div class='col-2-no'>${data.rating}/5</div>
                                </div>
                                </a>`
                htmls += html
            })
            target.innerHTML += htmls
            wait = false;
        } else {
            // Load more icon items
            target = document.getElementById("icon-view-content")
            htmls = ""

            response.data.forEach(data => {
                pos += 1
                html = `<li class='icon-view-item'>
                                <a href='app_info.php?data=${data.id}' title='${data.name}'>
                                <div class='app-icon'>
                                <div class='app-header'>
                                <p><b>${data.name}</b></p>
                                </div>
                                <div class='app-img'>
                                <img src='${data.img_url}' alt='App image'>
                                </div>
                                <div class='app-desc'>
                                <p><b>Developer:</b> ${data.developer}</p>
                                <p><b>Rating:</b> ${data.rating} / 5</p>
                                <p><b>Genre:</b> ${data.genre}</p>
                                <p><b>Description:</b> ${data.description}</p>
                                </div>
                                <div class='app-footer'></div>
                                </div>
                                </a>
                                </li>`
                htmls += html
            })
            target.innerHTML += htmls
        }
        currentPage += 1;
        wait = false;
        if (pos == response.count) {
            finished = true;
        }
    })
}

// Set up service data
var getAppData = async () => {
    contentRating = await goGet("apps/service.php", "content_rating").then(response => {
        return response
    })

    developers = await goGet("apps/service.php", "developers").then(response => {
        return response
    })

    genres = await goGet("apps/service.php", "genre").then(response => {
        return response
    })

    numberOfInstalls = await goGet("apps/service.php", "installs").then(response => {
        return response
    })
}

var clearSearch = () => {
    // get all inputs, set val to 0, submit
    var searchForm = document.getElementById("app-search-form")

    var searchInput = document.getElementById("app-search")
    searchInput.value = ""
    var viewInput = document.getElementById("view-input")
    viewInput.value = view

    var orderInput = document.getElementById("order-hidden-input")
    orderInput.value = ""
    var keyInput = document.getElementById("key-hidden-input")
    keyInput.value = ""
    var valueInput = document.getElementById("value-hidden-input")
    valueInput.value = ""

    searchForm.submit()
}