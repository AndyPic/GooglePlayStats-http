<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/inc/functions.php');
session_start();

if (isset($_GET['data']) && $_GET['data'] != '') {
    $data = $_GET['data'];
    $endpoint = "http://apickard01.lampt.eeecs.qub.ac.uk/API/apps/data.php?data={$data}";
    $appinfo = json_decode(file_get_contents($endpoint), true)['data'][0];
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
    <link rel="stylesheet" href="css/app_info.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d43075deec.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/hmac-md5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/enc-base64.min.js"></script>
    <script src="ajax/fetchers.js"></script>
    <script src="js/scripts.js"></script>
</head>

<body>
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

        <div class="row">
            <div class="col-1"></div>
            <div class="col-8">
                <h2> <?= $appinfo['name']; ?> </h2>
                <p>From: <?= $appinfo['developer']; ?> </p>
                <p>Genre: <?= $appinfo['genre']; ?> </p>
            </div>
            <a title="View Google Play page" target="_blank" href="<?= $appinfo['google_app_url']; ?>">
                <div class="col-2 shadow1" id="app-info-img-container">
                    <img id="app-info-img" src="<?= $appinfo['img_url']; ?>" alt="app image">
                </div>
            </a>
            <div class="col-1"></div>
        </div>

        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <div class="row">
                    <div class="col-4-no padR5 taL">
                        <h4>
                            Rating
                        </h4>
                        <p>
                            <?= $appinfo['rating']; ?> / 5
                        </p>
                    </div>
                    <div class="col-4-no padR5 taC">
                        <h4>
                            Installs
                        </h4>
                        <p>
                            <?= $appinfo['number_of_installs']; ?>
                        </p>
                    </div>
                    <div class="col-4-no padR5 taR">
                        <h4>
                            Price
                        </h4>
                        <p>
                            <?php
                            if ($appinfo['price'] > 0) {
                                echo $appinfo['price'];
                            } else {
                                echo "Free";
                            }
                            ?>
                        </p>
                    </div>
                </div>
                <div>
                    <h3 style="display: inline-block">App Description</h3>
                    <button style="display: inline-block" title="Toggle Description" class="fas unselectable" id="desc-toggle" onclick="elementToggle(this.id)"></button>
                    <p class="toggle-target padT10" style="display: none;"> <?= $appinfo['description']; ?> </p>
                </div>
                <div>
                    <h3 style="display: inline-block">User Reviews</h3>
                    <button style="display: inline-block" title="Toggle Description" class="fas unselectable" id="review-toggle" onClick="elementToggle(this.id)"></button>
                    <?php

                    $endpoint = "http://apickard01.lampt.eeecs.qub.ac.uk/API/apps/review.php?review={$data}";
                    $dataset = file_get_contents($endpoint);
                    $appreviews = json_decode($dataset, true);

                    if ($appreviews['data'] != null) {
                        foreach ($appreviews as $item) {
                            echo "<p class='toggle-target padT10' style='display: none;'>{$item['review']}</p>";
                        }
                    } else {
                        echo "<p class='toggle-target padT10' style='display: none;'>No reviews available for this app.</p>";
                    }

                    ?>
                </div>

                <div class="row">
                    <div class="col-4-no padR5 taL">
                        <h4>
                            Reviews
                        </h4>
                        <p>
                            <?= $appinfo['number_of_reviews']; ?>
                        </p>
                    </div>
                    <div class="col-4-no padR5 taC">
                        <h4>
                            Size
                        </h4>
                        <p>
                            <?= $appinfo['size']; ?>
                        </p>
                    </div>
                    <div class="col-4-no padR5 taR">
                        <h4>
                            Age Rating
                        </h4>
                        <p>
                            <?= $appinfo['content_rating']; ?>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4-no padR5 taL">
                        <h4>
                            Last Update
                        </h4>
                        <p>
                            <?= $appinfo['date_updated']; ?>
                        </p>
                    </div>
                    <div class="col-4-no padR5 taC">
                        <h4>
                            Version
                        </h4>
                        <p>
                            <?= $appinfo['current_version']; ?>
                        </p>
                    </div>
                    <div class="col-4-no padR5 taR">
                        <h4>
                            Android OS
                        </h4>
                        <p>
                            <?= $appinfo['android_os_support']; ?>
                        </p>
                    </div>
                </div>

                <div class="col-1"></div>
            </div>

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