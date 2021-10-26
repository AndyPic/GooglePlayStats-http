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
    <title>Google Play Stats - All Apps</title>
    <link rel="shortcut icon" type="image/x-icon" href="/imgs/gplayIcon.ico" />
    <link rel="stylesheet" href="css/colours.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/index.css">
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
    <!-- START of page content -->

    <div id="page-body">
        <div id="landing">
            <div class="container-fullscreen">
                <div class="row">
                    <div class="col-12">
                        <h2>Welcome To</h2>
                        <h1>GOOGLE PLAY STATS</h1>
                        <?php
                        if (@$_SESSION['loggedin'] === true) {
                            echo "<h2>" . $_SESSION['display_name'] . "</h2>";
                        }
                        ?>
                    </div>
                </div>

                <div class="slideshow unselectable">
                    <!--  Update slide indicators to match how many images there are  -->
                    <img class="slides" src="https://placeimg.com/1280/520/tech" alt="tech image" style="display: block;">
                    <img class="slides" src="https://placeimg.com/1280/519/tech" alt="tech image" style="display: none;">
                    <img class="slides" src="https://placeimg.com/1279/520/tech" alt="tech image" style="display: none;">
                    <div id="slidenav">
                        <div class="fas" id="slidealt-left" onclick="moveSlide('--')"></div>
                        <div class="slide-indicator" id="slide-indicator-on" onclick="jumpTo(0)"></div>
                        <div class="slide-indicator" onclick="jumpTo(1)"></div>
                        <div class="slide-indicator" onclick="jumpTo(2)"></div>
                        <div class="fas" id="slidealt-right" onclick="moveSlide('++')"></div>
                    </div>
                </div>

                <script>
                    var slides = document.getElementsByClassName("slides");
                    var slideIndicator = document.getElementsByClassName("slide-indicator");

                    function getCurrent() {
                        for (loop = 0; loop < slides.length; loop++) {
                            if (slides[loop].style.display == "block") {
                                return loop;
                            }
                        }
                    }
                    var currentSlide = getCurrent();

                    function moveSlide(input) {
                        currentSlide = getCurrent();
                        // Turn old slide off
                        slides[currentSlide].style.display = "none";
                        slideIndicator[currentSlide].removeAttribute("id");
                        // Increase / decrease depending on whcih button clicked
                        if (input == "++") {
                            currentSlide++;
                        } else if (input == "--") {
                            currentSlide--;
                        } else {
                            console.log("Invalid move input")
                            currentSlide = 0;
                        }
                        // Loop count back around
                        if (currentSlide >= slides.length) {
                            currentSlide = 0;
                        } else if (currentSlide < 0) {
                            currentSlide = (slides.length - 1);
                        }
                        // Turn new slide on
                        slides[currentSlide].style.display = "block";
                        slideIndicator[currentSlide].id = "slide-indicator-on";
                    }
                    var currentIndicator = document.getElementById("slide-indicator-on");

                    function jumpTo(number) {
                        currentSlide = getCurrent();

                        slides[currentSlide].style.display = "none";
                        slides[number].style.display = "block";

                        slideIndicator[currentSlide].removeAttribute("id");
                        slideIndicator[number].id = "slide-indicator-on";



                    }
                </script>

                <div>
                    <h1>
                        SOCIALS
                    </h1>
                </div>

                <div class="row" id="socials1">
                    <div class="col-4">
                        <a href="https://www.facebook.com/GoogleUK" target="_blank" rel="noopener noreferrer" class="fab socialicon" id="fb"></a>
                        <div class="social-text">
                            <h3>Facebook</h3>
                            <p>Find us on Facebook</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <a href="https://www.instagram.com/google/" target="_blank" rel="noopener noreferrer" class="fab socialicon" id="ig"></a>
                        <div class="social-text">
                            <h3>Instagram</h3>
                            <p>Find loads of awesome user created content on our Instagram page</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <a href="https://twitter.com/Google" target="_blank" rel="noopener noreferrer" class="fab socialicon" id="twi"></a>
                        <div class="social-text">
                            <h3>Twitter</h3>
                            <p>Follow our Twitter for the latest updates on all things app!</p>
                        </div>
                    </div>
                </div>

                <div class="row" id="socials2">
                    <div class="col-2"></div>
                    <div class="col-4">
                        <a href="https://www.linkedin.com/company/google/" target="_blank" rel="noopener noreferrer" class="fab socialicon" id="linkd"></a>
                        <div class="social-text">
                            <h3>Linkedin</h3>
                            <p>Developer? Link with us on Linked-In for some great industry contacts</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <a href="https://discord.com/" target="_blank" rel="noopener noreferrer" class="fab socialicon" id="disc"></a>
                        <div class="social-text">
                            <h3>Discord</h3>
                            <p>Visit our discord server to chat with others about apps</p>
                        </div>
                    </div>
                    <div class="col-2"></div>
                </div>

            </div>

            <div id="landing-bar">
                <h2>
                    We're always 'appy' to see you!
                </h2>
            </div>
        </div>

        <div>
            <div class="para"></div>
        </div>

        <?php
        if (@$_SESSION['loggedin'] !== true) {
            echo "<div id='afterpara'>";
            echo "<div class='container-fullscreen'>";
            echo "<div class='row'>";
            echo "<div class='col-4 app-img-div'>";
            echo "<img class='unselectable' id='white-phone' src='/imgs/white_phn.png' alt='Phone pic'>";
            echo "</div>";
            echo "<div class='col-8'>";
            echo "<h2>Sign up for a free account now!</h2>";
            echo "<p>Create an account to start weighing in on other users' app ideas!<br>
                            Maybe you have an awesome idea for an app yourself? Once you have an account you can put your ideas out there, and maybe find a developer to make it!</p>";
            echo "<h2>Are you an app developer?</h2>";
            echo "<p>Sign up for a developer account and start taking on projects that you like the sound of.</p>";
            echo "</div>";
            echo "</div>";
            echo "<div class='row' id='bottom-para'>";
            echo "<div class='col-8'>";
            echo "<h2>Sign up for a free account now!</h2>";
            echo "<p>Create an account to start weighing in on other users' app ideas!<br>
                            Maybe you have an awesome idea for an app yourself? Once you have an account you can put your ideas out there, and maybe find a developer to make it!</p>";
            echo "<h2>Are you an app developer?</h2>";
            echo "<p>Sign up for a developer account and start taking on projects that you like the sound of.</p>";
            echo "</div>";
            echo "<div class='col-4 app-img-div'>";
            echo "<img class='unselectable' id='blue-phone' src='/imgs/blue_phn.png' alt='Phone pic'>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "<div id='afterpara-loged'></div>";
        }
        ?>

    </div>

    </div>

    <!-- END of page content -->
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
            <p class="toggle-target" style="display: none;"><i> Moar Apps! </i></p>
        </div>
    </div>
</body>

</html>