<?php
include("../functions.php");

// Set up defaults
$default_page_num = 1;
$default_per_page = 15;
$default_search = "Search all apps";
$default_view = "icon";

// Get passed data
if (isset($_GET["view"]) && $_GET["view"] != "") {
    $view = $_GET["view"];
} else {
    $view = $default_view;
}

if (isset($_GET["page_num"]) && $_GET["page_num"] != "") {
    $current_page_num = $_GET["page_num"];
} else {
    $current_page_num = $default_page_num;
}

if (isset($_GET["per_page"]) && $_GET["per_page"] != "") {
    $apps_per_page = $_GET["per_page"];
} else {
    $apps_per_page = $default_per_page;
}

if (isset($_GET['app_search']) && $_GET['app_search'] != "") {
    $search_param = trim($_GET['app_search']);

    $endpoint = "http://apickard01.lampt.eeecs.qub.ac.uk/API/api.php?app_search={$search_param}";
    $allapps = json_decode(file_get_contents($endpoint), true);

    if (is_countable($allapps)) {
        $numapps = count($allapps);

        $total_pages = ceil(($numapps / $apps_per_page));

        if ($current_page_num > $total_pages) {
            $current_page_num = $total_pages;
        } else if ($current_page_num < $default_page_num) {
            $current_page_num = $default_page_num;
        }
    } else {
        $numapps = 0;
        $total_pages = 1;
    }

    $current_position = ($apps_per_page * $current_page_num) - $apps_per_page;
} else {
    $search_param = $default_search;

    $numapps = (json_decode(file_get_contents("http://apickard01.lampt.eeecs.qub.ac.uk/API/api.php?count_apps"), true))['count'];

    $total_pages = ceil(($numapps / $apps_per_page));

    if ($current_page_num > $total_pages) {
        $current_page_num = $total_pages;
    } else if ($current_page_num < $default_page_num) {
        $current_page_num = $default_page_num;
    }

    $current_position = ($apps_per_page * $current_page_num) - $apps_per_page;

    $endpoint = "http://apickard01.lampt.eeecs.qub.ac.uk/API/api.php?app_data_num={$current_position},{$apps_per_page}";
    $allapps = json_decode(file_get_contents($endpoint), true);
}

/**
 * Fucntion to preserve other inputs when submitting a new one,
 * pass blank variable in to ignore that input.
 */
function preserve_inputs($apps_per_page, $current_page_num, $search_param, $view)
{
    // Get default values
    global $default_per_page, $default_page_num, $default_search, $default_view;

    // Preserve other inputs
    if ($apps_per_page != "" && $apps_per_page != $default_per_page) {
        echo "<input type='hidden' name='per_page' value='{$apps_per_page}'>";
    }

    if ($current_page_num != "" && $current_page_num != $default_page_num) {
        echo "<input type='hidden' name='page_num' value='{$current_page_num}'>";
    }

    if ($search_param != "" && $search_param != $default_search) {
        echo "<input type='hidden' name='app_search' value='{$search_param}'>";
    }

    if ($view != "" && $view != $default_view) {
        echo "<input type='hidden' name='view' value='{$view}'>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Play Stats - All Apps</title>
    <link rel="shortcut icon" type="image/x-icon" href="gplay.ico" />
    <link rel="stylesheet" href="dependencies/styles.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d43075deec.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="dependencies/scripts.js"></script>
</head>

<body>
    <!-- Navigation bar -->
    <nav class="navbar shadow1 unselectable">
        <div class="container-fullscreen">
            <div class="navleft">
                <div class="menuitem notme">
                    <a href="index.html" title="Home">
                        <div class="logoimage"></div>
                    </a>
                </div>
                <div class="menuitem" id="menu4">
                    <div class="dropbtn">APPS</div>
                    <div class="dropdown-content">
                        <a href="all_apps.php">All Apps</a>
                        <a href="ap_pitch.php">Pitch an App</a>
                        <a href="ap_pitch_review.php">Review a Pitch</a>
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
                        <a href="#">Popularity</a>
                        <a href="#">Profitability</a>
                        <a href="#">Sustainability</a>
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
                <div class="menuitem fa" id="menulogin" title="Log-In" onclick="window.open('login.html')"></div>
                <div class="menuitem fa" id="menudarkmode" title="Darkmode toggle" onclick="toggleDarkmode()"></div>
                <div class="andy-container-outer posRel">
                    <div class="menuitem fa" id="menumenu" title="Menu"></div>
                    <div class="dropdown">
                        <div class="spacer"></div>

                        <div class="menuitem fa" id="menulogin" title="Log-In" onclick="window.open('login.html')"></div>
                        <div class="menuitem fa" id="menudarkmode" title="Darkmode toggle" onclick="toggleDarkmode()"></div>

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
            <form id="app_search-form" action="" method="get">
                <?php
                preserve_inputs($apps_per_page, "", "", $view);
                ?>
                <input id='app-search' type='text' name='app_search' placeholder='<?php echo "{$search_param}" ?>'>
            </form>
            <button type="submit" form="app_search-form" title="Search" class="fa"></button>
            <?php
            if ($search_param != $default_search) {

                echo "<form id='clear_search-form' method='get'>";

                preserve_inputs($apps_per_page, "", "", $view);

                echo "<button type='submit' form='clear_search-form' id='clear-search' title='Clear Search' class='fa' name'app_search' value=''></button>";
                echo "</form>";
            }
            ?>

            <div class="posRel">
                <div class="btn" title="Items per page" id="pp-btn"><?php echo "{$apps_per_page}"; ?>
                    <div class="pp-dropdown-content">
                        <div class="spacer"></div>
                        <form id="per_page-form" action="" method="get">
                            <?php
                            preserve_inputs("", "", $search_param, $view)
                            ?>
                            <button class="pp-option" type="submit" name="per_page" form="per_page-form" value="10">10</button>
                            <button class="pp-option" type="submit">15</button>
                            <button class="pp-option" type="submit" name="per_page" form="per_page-form" value="25">25</button>
                            <button class="pp-option" type="submit" name="per_page" form="per_page-form" value="50">50</button>
                            <button class="pp-option" type="submit" name="per_page" form="per_page-form" value="100">100</button>
                        </form>
                    </div>
                </div>
            </div>

            <?php
            echo    "<form id='view-form' method='get'>";
            preserve_inputs($apps_per_page, $current_page_num, $search_param, "");
            if ($view == "list") {
                echo "<button title='Toggle view' id='toggle-app-view' class='fa' type='submit' name='view' form='view-form' value='icon'></button>";
            } else {
                echo "<button title='Toggle view' id='toggle-app-view' class='fa' type='submit' name='view' form='view-form' value='list'></button>";
            }
            echo    "</form>";
            ?>

        </div>

        <?php

        // Render icon / list depending on pref
        if ($view == "list") {

            // List View

            echo    "<div id='list-view-content'>
                    <div id='apps-table'>
                    <div class='row header'>
                    <div class='col-2-no'>No.</div>
                    <div class='col-4-no'>Name</div>
                    <div class='col-4-no'>Genre</div>
                    <div class='col-2-no'>Rating</div>
                    </div>";
            if ($numapps == 0) {
                echo "<div id='no-apps-found'>
                        <h4> No apps found for '{$search_param}'</h4>
                        <button type='submit' form='clear_search-form' id='clear-search' title='Clear Search' name'app_search' value=''>Clear Search</button>
                        </div>";
            } else {

                $appnum = $current_position;
                if ($search_param == $default_search) {
                    $loop = 0;
                    $condition = $apps_per_page;
                } else {
                    $loop = $current_position;
                    $condition = $apps_per_page + $current_position;
                }
                for (; $loop < $condition; $loop++) {

                    if ($appnum < $numapps) {
                        $appnum += 1;

                        $name = escapeString($allapps[$loop]["name"]);
                        $description = escapeString($allapps[$loop]["description"]);
                        echo "<a href='app_info.php?app_data_id={$allapps[$loop]["id"]}' title='{$allapps[$loop]["name"]}'>
                            <div class='row'>
                            <div class='col-2-no'>{$appnum}</div>
                        <div class='col-4-no'>{$allapps[$loop]["name"]}</div>
                        <div class='col-4-no'>{$allapps[$loop]["genre"]}</div>
                        <div class='col-2-no'>{$allapps[$loop]["rating"]}/5</div>
                        </div>
                        </a>";
                    }
                }
            }
            echo    "</div>
                    </div>";
        } else {

            // Icon View (default)

            echo    "<div id='icon-view'>
                    <div class='icon-view-container'>
                    <ul class='icon-view-content'>";
            if ($numapps == 0) {
                echo "<div id='no-apps-found'>
                    <h4> No apps found for '{$search_param}'</h4>
                    <button type='submit' form='clear_search-form' id='clear-search' title='Clear Search' name'app_search' value=''>Clear Search</button>
                    </div>";
            } else {
                $appnum = $current_position;
                if ($search_param == $default_search) {
                    $loop = 0;
                    $condition = $apps_per_page;
                } else {
                    $loop = $current_position;
                    $condition = $apps_per_page + $current_position;
                }
                for (; $loop < $condition; $loop++) {

                    if ($appnum < $numapps) {
                        $appnum += 1;

                        $name = escapeString($allapps[$loop]["name"]);
                        $description = escapeString($allapps[$loop]["description"]);

                        echo "<li class='icon-view-item'>
                            <a href='app_info.php?app_data_id={$allapps[$loop]["id"]}' title='{$name}'>
                            <div class='app-icon'>
                            <div class='app-header'>
                            <div>
                            <h3 class='app-number'>{$appnum}</h3>
                            <h3>{$name}</h3>
                            </div>
                            </div>
                            <div class='app-img'>
                            <img src='{$allapps[$loop]["img_url"]}' alt='App image'>
                            </div>
                            <div class='app-desc'>
                            <p><b>Developer:</b> {$allapps[$loop]["developer"]}</p>
                            <p><b>Rating:</b> {$allapps[$loop]["rating"]} / 5</p>
                            <p><b>Genre:</b> {$allapps[$loop]["genre"]}</p>
                            <p><b>Description:</b> {$description}</p>
                            </div>
                            <div class='app-footer'></div>
                            </div>
                            </a>
                            </li>";
                    }
                }
            }
            echo    "</ul>
                    </div>
                    </div>";
        }
        ?>

        <div class="app-bar">

            <?php
            if ($current_page_num > $default_page_num) {

                $previous_page = $current_page_num - 1;

                echo "<form id='previous_page-form' method='get'>";

                preserve_inputs($apps_per_page, "", $search_param, $view);

                echo "<button title='Previous page' id='allapps-arrleft' class='fa' type='submit' name='page_num' form='previous_page-form' value='{$previous_page}'></button>";
                echo "</form>";
            }
            ?>

            <form id="page_num-form" method="get">
                <?php
                preserve_inputs($apps_per_page, "", $search_param, $view);
                ?>
                <input id="page-num-in" type="text" name="page_num" placeholder='<?php echo "{$current_page_num} / {$total_pages}"; ?>'>
            </form>
            <button title="Go to page" id="page-num-submit" class="fa" type="submit" form="page_num-form"></button>

            <?php
            if ($current_page_num < $total_pages) {

                $next_page = $current_page_num + 1;

                echo "<form id='next_page-form' method='get'>";

                preserve_inputs($apps_per_page, "", $search_param, $view);

                echo "<button title='Next page' id='allapps-arrright' class='fa' type='submit' name='page_num' form='next_page-form' value='{$next_page}'></button>";
                echo "</form>";
            }
            ?>

        </div>
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
                    <a href="index.html" title="Home">
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