<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/inc/functions.php');
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Play Stats - App Trends</title>
    <link rel="shortcut icon" type="image/x-icon" href="/imgs/gplayIcon.ico" />
    <link rel="stylesheet" href="css/colours.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/app_trends.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d43075deec.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/hmac-md5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/enc-base64.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.2.1/dist/chart.min.js"></script>
    <script src="ajax/fetchers.js"></script>
    <script src="js/scripts.js"></script>

    <script>
        // Get the app info
        var appInfo, titleText, getParam
        var query = window.location.search

        if (query.includes("reviews")) {
            getParam = "reviews"
            titleText = "Number of app reviews (Past 12 months)"
        } else if (query.includes("revenue")) {
            getParam = "revenue"
            titleText = "App total sales revenue [$] (Past 12 months)"
        } else if (query.includes("installs")) {
            getParam = "installs"
            titleText = "Number of app installs (Past 12 months)"
        } else {
            // Default to rating
            getParam = "rating"
            titleText = "App rating [0-5] (Past 12 months)"
        }

        var getAppData = async () => {
            appInfo = await goGet("apps/year.php", getParam).then(response => {
                return response
            })
        }
    </script>


</head>

<body onload="getAppData()">
    <!-- Navigation bar -->
    <nav class="navbar shadow1 unselectable">
        <div class="container-fullscreen">
            <div class="navleft">
                <div class="menuitem notme">
                    <a href="http://apickard01.lampt.eeecs.qub.ac.uk/" title="Home">
                        <div class="logoimage"></div>
                    </a>
                </div>
                <div class="menuitem" id="menu4">
                    <div class="dropbtn">APPS</div>
                    <div class="dropdown-content">
                        <a href="all_apps.php">All Apps</a>
                        <a href="pitch.php">Pitch an App</a>
                        <a href="all_pitches.php">Review a Pitch</a>
                    </div>
                </div>
                <div class="menuitem" id="menu3">
                    <div class="dropbtn">STATS</div>
                    <div class="dropdown-content">
                        <a href="#">Stat 1</a>
                        <a href="#">Stat 2</a>
                        <a href="#">Stat 3</a>
                    </div>
                </div>
                <div class="menuitem" id="menu2">
                    <div class="dropbtn">TRENDS</div>
                    <div class="dropdown-content">
                        <a href="app_trends.php?installs">Downloads</a>
                        <a href="app_trends.php?reviews">Reviews</a>
                        <a href="app_trends.php?rating">Rating</a>
                        <a href="app_trends.php?revenue">Revenue</a>
                    </div>
                </div>
                <div class="menuitem" id="menu1">
                    <div class="dropbtn">ARTICLES</div>
                    <div class="dropdown-content">
                        <a href="#">Browse articles</a>
                        <a href="#">Become an author</a>
                    </div>
                </div>
            </div>
            <div class="navright">
                <div class="menuitem fa" id="menusearch" title="Search"></div>
                <?php
                if (@$_SESSION['loggedin'] === true) {
                    // Logged in
                    echo "<div class='menuitem fas' id='menulogin' title='Log-out / Account' onclick='location.href = `account.php`'></div>";
                } else {
                    // Not logged in
                    echo "<div class='menuitem far' id='menulogin' title='Log-in / Register' onclick='location.href = `login.php`'></div>";
                }
                ?>
                <div class="menuitem fa" id="menudarkmode" title="Darkmode toggle" onclick="toggleDarkmode()"></div>
                <div class="andy-container-outer posRel">
                    <div class="menuitem fa" id="menumenu" title="Menu"></div>
                    <div class="dropdown">
                        <div class="spacer"></div>

                        <?php
                        if (@$_SESSION['loggedin'] === true) {
                            // Logged in
                            echo "<div class='menuitem fas' id='menulogin' title='Log-out / Account' onclick='location.href = `account.php`'></div>";
                        } else {
                            // Not logged in
                            echo "<div class='menuitem far' id='menulogin' title='Log-in / Register' onclick='location.href = `login.php`'></div>";
                        }
                        ?>
                        <div class="menuitem fa" id="menudarkmode" title="Darkmode toggle" onclick="toggleDarkmode()">
                        </div>

                        <div class="andy-container">
                            <div class="hovermenu" id="hovermenu1">ARTICLES</div>
                            <div class="popout">
                                <a href="#">Browse articles</a>
                                <a href="#">Become an author</a>
                            </div>
                        </div>
                        <div class="andy-container">
                            <div class="hovermenu" id="hovermenu2">TRENDS</div>
                            <div class="popout">
                                <a href="#">Popularity</a>
                                <a href="#">Profitability</a>
                                <a href="#">Sustainability</a>
                            </div>
                        </div>
                        <div class="andy-container">
                            <div class="hovermenu" id="hovermenu3">STATS</div>
                            <div class="popout">
                                <a href="#">Stat 1</a>
                                <a href="#">Stat 2</a>
                                <a href="#">Stat 3</a>
                            </div>
                        </div>
                        <div class="andy-container">
                            <div class="hovermenu" id="hovermenu4">APPS</div>
                            <div class="popout">
                                <a href="all_apps.php">All Apps</a>
                                <a href="#">Pitch an App</a>
                                <a href="#">Review a Pitch</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fullscreen">
        <!-- START of page content -->

        <div id="stats-title">
            <h2 class="unselectable">
                Compare app trends
            </h2>
        </div>

        <div class="row">
            <div class="col-8 graph-container">
                <canvas id="appCompareLine" width="400" height="400"></canvas>
            </div>

            <div class="col-4">
                <div class="row" id="app-input-outer-container">
                    <div id="app-trends-spacer"></div>
                    <div class="app-input-container row">
                        <!-- Do an if set... post data for first app to compare from app info page 'Compare to other apps...' -->
                        <input class="search-input" id="first-app" type="text" placeholder="First app">
                        <button id="toggle-1" class="toggle-app fa" title="Toggle app on graph"></button>
                        <div class="popup">
                            <span class="popuptext">Invalid app name</span>
                        </div>
                        <div class="search-container"></div>
                    </div>
                    <div class="app-input-container row">
                        <input class="search-input" id="second-app" type="text" placeholder="Second app">
                        <button id="toggle-2" class="toggle-app fa" title="Toggle app on graph"></button>
                        <div class="popup">
                            <span class="popuptext">Invalid app name</span>
                        </div>
                        <div class="search-container"></div>
                    </div>
                    <div class="app-input-container hidden row">
                        <input class="search-input" id="third-app" type="text" placeholder="Third app">
                        <button id="toggle-3" class="toggle-app fa" title="Toggle app on graph"></button>
                        <div class="popup">
                            <span class="popuptext">Invalid app name</span>
                        </div>
                        <div class="search-container"></div>
                    </div>
                    <div class="app-input-container hidden row">
                        <input class="search-input" id="fourth-app" type="text" placeholder="Fourth app">
                        <button id="toggle-4" class="toggle-app fa" title="Toggle app on graph"></button>
                        <div class="popup">
                            <span class="popuptext">Invalid app name</span>
                        </div>
                        <div class="search-container"></div>
                    </div>
                    <div class="app-input-container hidden row">
                        <input class="search-input" id="fifth-app" type="text" placeholder="Fifth app">
                        <button id="toggle-5" class="toggle-app fa" title="Toggle app on graph"></button>
                        <div class="popup">
                            <span class="popuptext">Invalid app name</span>
                        </div>
                        <div class="search-container"></div>
                    </div>
                    <div class="row">
                        <button id="add-apps">Add app</button>
                        <button id="remove-apps">Remove app</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Global scope vars
            var holder
            var blacklist = new Array()

            // Set up event listeners for INPUT
            var searchInputs = document.getElementsByClassName("search-input")
            for (loop = 0; loop < searchInputs.length; loop++) {
                var thisInput = searchInputs[loop]

                thisInput.onblur = thisEvent => {
                    // on-blur, remove
                    clearOldSearch(thisEvent.srcElement.getAttribute("id"))
                }

                thisInput.onfocus = thisEvent => {
                    // on-focus, replace
                    searchDropDown(thisEvent.srcElement.getAttribute("id"))
                }

                thisInput.onkeyup = thisEvent => {
                    // Set up search drop-down
                    searchDropDown(thisEvent.srcElement.getAttribute("id"))
                }
            }
            var toggleButtons = document.getElementsByClassName("toggle-app")
            for (loop = 0; loop < toggleButtons.length; loop++) {
                var thisButton = toggleButtons[loop]

                thisButton.onclick = thisEvent => {
                    // Toggle the line on graph
                    toggleLine(thisEvent.srcElement.getAttribute("id"))
                }
            }
            var inputContainer = document.getElementsByClassName("app-input-container")
            document.getElementById("add-apps").onclick = thisEvent => {

                for (loop = 2; loop < inputContainer.length; loop++) {
                    // If is hidden, unhide then break
                    if (inputContainer[loop].classList.contains("hidden")) {
                        inputContainer[loop].classList.remove("hidden")
                        break
                    }
                }
            }
            document.getElementById("remove-apps").onclick = thisEvent => {

                for (loop = inputContainer.length - 1; loop > 1; loop--) {
                    // If is not hidden, unhide + toggle graph line then break
                    if (!inputContainer[loop].classList.contains("hidden")) {
                        inputContainer[loop].classList.add("hidden")
                        // Check if line active
                        var buttonId = inputContainer[loop].querySelector(".toggle-app").getAttribute("id")
                        var appNo = buttonId.replace("toggle-", "") - 1
                        if (blacklist.includes(appNo)) {
                            toggleLine(buttonId)
                        }
                        break
                    }
                }
            }

            var lineGraphData = Array()

            var toggleLine = buttonId => {
                var appNo = buttonId.replace("toggle-", "") - 1
                var button = document.getElementById(buttonId)
                if (!blacklist.includes(appNo)) {
                    var inputValue = button.parentElement.querySelector('.search-input').value
                    var isMatch = false
                    for (loop = 0; loop < appInfo['data'].length; loop++) {
                        thisAppInfo = appInfo['data'][loop]
                        if (thisAppInfo['name'] == inputValue) {

                            lineGraphData[appNo] = ({
                                label: thisAppInfo['name'].substring(0, 8),
                                data: [thisAppInfo['month_12'], thisAppInfo['month_11'], thisAppInfo['month_10'], thisAppInfo['month_09'], thisAppInfo['month_08'], thisAppInfo['month_07'],
                                    thisAppInfo['month_06'], thisAppInfo['month_05'], thisAppInfo['month_04'], thisAppInfo['month_03'], thisAppInfo['month_02'], thisAppInfo['month_01']
                                ],
                                borderColor: lineColours[appNo]
                            })

                            // Push new dataset to graph
                            appCompareLine.data.datasets.push(lineGraphData[appNo])
                            appCompareLine.update()
                            // Blacklist app
                            blacklist.push(appNo)
                            button.innerText = ""

                            isMatch = true
                            break
                        }
                    }

                    if (!isMatch) {
                        var popup = button.parentElement.querySelector('.popup').firstElementChild
                        if (!popup.classList.contains("show")) {
                            popup.classList.add("show")
                            setTimeout(() => {
                                popup.classList.remove("show")
                            }, 1800)
                        }

                    }

                    /**
                     * Add some way to toggle between the different metrics
                     * -> all in 1 page, or separate pages?
                     */


                } else {
                    // Remove from graph
                    index = appCompareLine.data.datasets.indexOf(lineGraphData[appNo])
                    appCompareLine.data.datasets.splice(index, 1)
                    appCompareLine.update()

                    // Remove from blacklist
                    index = blacklist.indexOf(appNo)
                    blacklist.splice(index, 1)

                    button.innerText = ""
                }
            }

            var searchDropDown = inputId => {
                var input = document.getElementById(inputId)
                var search = input.value.toUpperCase()
                var blacklist = new Array()

                // Clear previous dropdown
                clearOldSearch(inputId)

                if (search != "") {
                    for (loop = 0; loop < 5; loop++) {
                        for (innerLoop = 0; innerLoop < appInfo['data'].length; innerLoop++) {
                            name = appInfo['data'][innerLoop]['name']
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
                var oldSearch = document.getElementsByClassName("app-search")
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
                element.classList.add("app-search")
                element.classList.add("unselectable")
                element.setAttribute("id", "app-search-" + num)
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
                var parent = clickedElem.parentElement
                var parent2 = parent.parentElement
                var input = parent2.querySelector(".search-input")
                input.value = text

                inputId = input.getAttribute("id")
                clearOldSearch(inputId)
            }

            // Preview the option on mouse-over
            var previewValue = dropId => {
                clickedElem = document.getElementById(dropId)
                var text = clickedElem.innerText
                var parent = clickedElem.parentElement
                var parent2 = parent.parentElement
                var input = parent2.querySelector(".search-input")

                holder = input.value
                input.value = text
            }

            // Replace typed value on mouse-out
            var replaceValue = dropId => {
                clickedElem = document.getElementById(dropId)
                var text = clickedElem.innerText
                var parent = clickedElem.parentElement
                var parent2 = parent.parentElement
                var input = parent2.querySelector(".search-input")

                input.value = holder
            }
        </script>

        <script>
            var currentDate = new Date();
            months = new Array();
            for (loop = 0; loop < 12; loop++) {
                var date = getDate(currentDate, 0, -loop, 0)
                var month = date.toLocaleDateString(undefined, {
                    month: 'long',
                    year: 'numeric'
                });

                months[loop] = month;
            }

            Chart.defaults.borderColor = ['rgba(100, 100, 100, .3)'];
            Chart.defaults.color = ['rgb(100, 100, 100)'];
            Chart.defaults.font.size = 12;

            var lineColours = [
                "rgb(241, 91, 108)", // Red
                "rgb(40, 179, 234)", // Blue
                "rgb(82, 232, 149)", // Green
                "rgb(255, 217, 0)", // Yellow
                "rgb(252, 224, 162)" // Cream 
            ]

            var context = document.getElementById('appCompareLine').getContext('2d');
            var appCompareLine = new Chart(context, {
                type: 'line',
                data: {
                    labels: [months[11], months[10], months[9], months[8], months[7], months[6], months[5], months[4], months[3], months[2], months[1], months[0]],
                    datasets: []
                },
                options: {
                    plugins: {
                        title: {
                            text: titleText,
                            display: true
                        }
                    },
                    datasets: {
                        line: {
                            tension: 0.3
                        }
                    },
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>


        <!-- END of page content -->
    </div>

    <div id="footer">
        <div class="container-fullscreen">
            <button style="display: inline-block" title="Toggle Description" class="fas unselectable" id="footer-toggle" onclick="elementToggle(this.id)"></button>
            <div class="row toggle-target">
                <div class="col-3">
                    <h2 class="unselectable">Mad about apps</h2>
                </div>
                <div class="col-1"></div>
                <div class="col-2">
                    <h3 class="unselectable">Company</h3>
                </div>
                <div class="col-1"></div>
                <div class="col-2">
                    <h3 class="unselectable">Resources</h3>
                </div>
                <div class="col-1"></div>
                <div class="col-2">
                    <h3 class="unselectable">Policies</h3>
                </div>
            </div>
            <div class="row toggle-target" style="display: none;">
                <div class="col-3">
                    <h2 class="unselectable">Mad about apps</h2>
                    <a href="index.php" title="Home">
                        <div class="logoimage"></div>
                    </a>
                    <p class="unselectable" style="font-size: 24px;">Please consider donating
                        to support us!<br></p>
                    <a class="fab unselectable" href="" style="font-size: 48px;"></a>
                </div>
                <div class="col-1"></div>
                <div class="col-2">
                    <h3 class="unselectable">Company</h3>
                    <a href="aboutus.html">About</a>
                    <a href="">Jobs</a>
                    <a href="">Branding</a>
                    <a href="">News</a>
                    <a href="">Volunteer</a>
                </div>
                <div class="col-1"></div>
                <div class="col-2">
                    <h3 class="unselectable">Resources</h3>
                    <a href="">Git</a>
                    <a href="">StackOverflow</a>
                </div>
                <div class="col-1"></div>
                <div class="col-2">
                    <h3 class="unselectable">Policies</h3>
                    <a href="terms.html">Terms</a>
                    <a href="">Privacy</a>
                    <a href="">Licenses</a>
                </div>
            </div>
            <div class="seperator toggle-target" style="display: none;"></div>
            <p class="toggle-target" style="display: none;"><i> "Insert cheesy quote here" </i></p>
        </div>
    </div>
</body>

</html>