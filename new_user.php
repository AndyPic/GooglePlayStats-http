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
    <title>Google Play Stats - New User</title>
    <link rel="shortcut icon" type="image/x-icon" href="/imgs/gplayIcon.ico" />
    <link rel="stylesheet" href="css/colours.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/new_user.css">
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

        <div class="create-account-container shadow2">
            <div id="create-account-title">
                <div class="logoimage-transparent"></div>
                <h1>CREATE ACCOUNT</h1>
            </div>
            <form id="create-account-form" method="POST" action="create_account.php">

                <div class="input-container clearer">
                    <input id="email-input" placeholder="Email Address" type="text" name="email" required>
                    <div class="popup">
                        <span class="popuptext">Invalid email entered.</span>
                        <span class="popuptext">That email address is already in use.</span>
                    </div>
                </div>

                <div class="input-container clearer">
                    <input class="" id="password-input" placeholder="Password" type="hidden" name="password" required>
                    <input class="toggle hidden" id="view-password" type="checkbox" title="View password">
                    <div class="popup">
                        <span class="popuptext">Invalid password entered. <br> Letters + Numbers, 7-72 long.</span>
                    </div>
                </div>

                <div class="input-container clearer">
                    <input id="name-input" placeholder="Display Name" type="hidden" name="display_name" required>
                    <div class="popup">
                        <span class="popuptext">Invalid name. <br> Letters 4-18 long.</span>
                    </div>
                </div>

                <label class="radio-container">Normal account
                    <input id="user" type="radio" name="level" value="4" checked>
                    <span class="checkmark"></span>
                </label>

                <label class="radio-container">Developer account
                    <input id="developer" type="radio" name="level" value="3">
                    <span class="checkmark"></span>
                </label>

                <button id="next-button" type="button">NEXT</button>
                <button class="hidden" id="create-button" type="button">CREATE ACCOUNT</button>
            </form>

            <p id="terms-p">Interested in <a id="terms-link" href="terms.html">T&Cs?</a></p>

        </div>
    </div>

    <script>
        document.getElementById("view-password").onclick = () => {
            var input = document.getElementById("password-input")
            if (input.getAttribute("type") == "password") {
                input.setAttribute("type", "text")
            } else {
                input.setAttribute("type", "password")
            }
        }

        document.getElementById("next-button").onclick = thisEvent => {
            var thisButton = thisEvent.srcElement
            var emailInput = document.getElementById("email-input")
            var pwInput = document.getElementById("password-input")
            var nameInput = document.getElementById("name-input")

            if (pwInput.getAttribute("type") == "hidden") {
                // Simple email check
                if (validateEmailFormat(emailInput.value)) {
                    // Display PW input on good email
                    pwInput.setAttribute("type", "password")
                    document.getElementById("view-password").classList.remove("hidden")
                } else {
                    runPopup(emailInput, 1)
                }

            } else if (nameInput.getAttribute("type") == "hidden") {
                // PW check
                if (validatePasswordFormat(pwInput.value)) {
                    // Display display name input on good email + create account button
                    nameInput.setAttribute("type", "text")
                    document.getElementById('next-button').classList.add("hidden")
                    document.getElementById('create-button').classList.remove("hidden")
                } else {
                    runPopup(pwInput, 1)
                }
            }
        }

        document.getElementById("create-button").onclick = async thisEvent => {
            var emailInput = document.getElementById("email-input")
            var emailResponse = await checkEmail(emailInput.value)
            var pwInput = document.getElementById("password-input")
            var nameInput = document.getElementById("name-input")

            // Guard clauses for validity checks
            if (!emailResponse) {
                runPopup(emailInput, 3)
                return
            }

            if (!validateEmailFormat(emailInput.value)) {
                runPopup(emailInput, 1)
            }

            if (!validatePasswordFormat(pwInput.value)) {
                runPopup(pwInput, 1)
                return
            }

            if (!validateDisplayNameFormat(nameInput.value)) {
                runPopup(pwInput, 1)
                return
            }

            document.getElementById("create-account-form").submit()
        }

        var checkEmail = async email => {
            // Check if email already in use
            params = "validate_email=" + email
            var resp = await goGet("apps/users.php", params).then(response => {
                if (response.data == "invalid") {
                    return true
                } else {
                    return false
                }
            })

            if (resp === true) {
                return true
            } else {
                return false
            }
        }
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