<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/inc/functions.php');
session_start();

if (isset($_GET["view"]) && $_GET["view"] == "list") {
    $view = $_GET["view"];
    $viewIcon = "";
} else {
    $view = "icon";
    $viewIcon = "";
}

if (isset($_GET["search"]) && $_GET["search"] != "") {
    $search_placeholder = $_GET["search"];
} else {
    $search_placeholder = "Search apps";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Play Stats - All Apps</title>
    <link rel="shortcut icon" type="image/x-icon" href="/imgs/gplayIcon.ico" />
    <link rel="stylesheet" href="css/colours.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/all_apps.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d43075deec.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/hmac-md5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/enc-base64.min.js"></script>
    <script src="ajax/fetchers.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/popups.js"></script>
    <script src="js/input_dropdown.js"></script>
    <script src="js/all_apps.js"></script>
</head>

<body onload="getAppData(); loadMoreApps(params)">
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
                        <a href="new_pitch.php">Pitch an App</a>
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
        <div class="app-bar">
            <div id="normal-search-panel">
                <form id="app-search-form" action="" method="GET">
                    <input id='app-search' type='text' name='search' placeholder='<?= $search_placeholder ?>'>

                    <input id="view-input" type="hidden" name="view" value="">

                    <input id="order-hidden-input" type="hidden" dissabled>
                    <input id="key-hidden-input" type="hidden" dissabled>
                    <input id="value-hidden-input" type="hidden" dissabled>

                    <button class="fa" id='app-search-button' title="Search" type="button"></button>
                    <?php
                    if ($search_placeholder != "Search apps" || isset($_GET['order'])) {
                        echo "<button class='fa' id='clear-search-button' title='Clear Search' type='button' onclick='clearSearch()'></button>";
                    }
                    ?>
                    <button class='fa' id='app-filter' title='Advanced search' type="button"></button>
                    <button class='fa' id='toggle-app-view' title='Toggle view' type="button"><?= $viewIcon ?></button>
                </form>
            </div>

            <div class="hidden posRel" id="advanced-search-panel">
                <div id="filter-input-container">
                    <input class="input-dropdown-input" id="filter-input" type="text" placeholder="Filter by..." value="">
                    <div class="popup">
                        <span class="popuptext">Invalid filter.</span>
                    </div>
                    <div class="search-container"></div>
                </div>

                <div id="filter-dropdown-container">
                    <button id="filter-button">NONE</button>
                    <div id="filter-dropdown-content">
                        <div class="filter-dropdown-item" id="filter-none">NONE</div>
                        <div class="filter-dropdown-item" id="filter-genre">GENRE</div>
                        <div class="filter-dropdown-item" id="filter-installs">INSTALLS</div>
                        <div class="filter-dropdown-item" id="filter-rating">Age Rating</div>
                        <div class="filter-dropdown-item" id="filter-devs">Developers</div>
                    </div>
                </div>

                <div id="radio-buttons">
                    <label class="radio-container">Name
                        <input id="sort-name" type="radio" name="order" value="name" checked>
                        <span class="checkmark"></span>
                    </label>

                    <label class="radio-container">Rating
                        <input id="sort-rating" type="radio" name="order" value="rating">
                        <span class="checkmark"></span>
                    </label>

                    <label class="radio-container">Reviews
                        <input id="sort-reviews" type="radio" name="order" value="reviews">
                        <span class="checkmark"></span>
                    </label>

                    <label class="radio-container">Price
                        <input id="sort-price" type="radio" name="order" value="price">
                        <span class="checkmark"></span>
                    </label>

                    <label class="radio-container">Last updated
                        <input id="sort-date" type="radio" name="order" value="updated">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </div>
        </div>

        <button id="jumpToTop" onclick="toTop()" class="fa" style="display:none" title="Back to top"></button>

        <div class='hidden' id='no-apps-found'>
            <h4> No apps found for </h4>
            <button type='submit' form='clear_search-form' title='Clear Search' name='search' value=''>Clear Search</button>
        </div>

        <?php
        $appnum = 0;
        // Render icon / list containers depending on pref
        if ($view === "list") {
            // List View
            echo "<div id='list-view-content'>
            <div id='apps-table'>
                <div class='row header'>
                    <div class='col-2-no'>No.</div>
                    <div class='col-4-no'>Name</div>
                    <div class='col-4-no'>Genre</div>
                    <div class='col-2-no'>Rating</div>
                </div>
            </div>
        </div>";
        } else {
            // Icon View (default)
            echo "<div id='icon-view'>
            <div class='icon-view-container'>
                <ul id='icon-view-content'>
                </ul>
            </div>
        </div>";
        }

        ?>

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