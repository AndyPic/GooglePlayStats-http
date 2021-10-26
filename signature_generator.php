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
    <title>Google Play Stats - Sig Gen</title>
    <link rel="shortcut icon" type="image/x-icon" href="/imgs/gplayIcon.ico" />
    <link rel="stylesheet" href="css/colours.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d43075deec.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/hmac-md5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/enc-base64.min.js"></script>
    <script src="ajax/fetchers.js"></script>
    <script src="js/scripts.js"></script>
    <script src="ajax/sig_gen.js"></script>
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
                        <a href="ap_pitch.php">Pitch an App</a>
                        <a href="ap_pitch_review.php">Review a Pitch</a>
                        <a href="all_apps.php">Random App!</a>
                        <a href="all_apps.php">Random Pitch!</a>
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

    <style>
        .container input,
        .container button {
            float: left;
            display: block;
            cursor: pointer;
            border-radius: 0px;
            border: 2px solid black;
            outline: none;
            width: 48%;
            height: 50px;
            font-size: 16px;
            font-weight: bold;
            margin: 8px auto;
            background: var(--clr-offWhite);
            color: black !important;
        }

        .container input {
            cursor: text;
        }
    </style>

    <div class="container-fullscreen container">
        <!-- START of page content -->

        <input id="api-key" type="text" name="api_key" placeholder="api key here!" value="p2Y4t9usn7">
        <input class="input" type="text" placeholder="key=value">
        <input class="input" type="text" placeholder="key=value">
        <input class="input" type="text" placeholder="key=value">
        <input class="input" type="text" placeholder="key=value">
        <input class="input" type="text" placeholder="key=value">
        <input class="input" type="text" placeholder="key=value">
        <input class="input" type="text" placeholder="key=value">
        <input class="input" type="text" placeholder="key=value">
        <input class="input" type="text" placeholder="key=value">
        <input class="input" type="text" placeholder="key=value">
        <input class="input" type="text" placeholder="key=value">
        <input class="input" type="text" placeholder="key=value">
        <input class="input" type="text" placeholder="key=value">
        <input class="input" type="text" placeholder="key=value">
        <input class="input" type="text" placeholder="key=value">

        <button id="button">BUTTON</button>

        <input id="sig" type="text" placeholder="Sig will be here!">

        <!-- END of page content -->
    </div>

    <script>
        document.getElementById("button").onclick = () => {
            messages = []
            inputs = document.getElementsByClassName("input")
            for (loop = 0; loop < inputs.length; loop++) {
                if (inputs[loop].value != "") {
                    messages.push(inputs[loop].value)
                }
            }
            apiKey = document.getElementById("api-key").value
            var sig = generateSignature(messages, apiKey)
            document.getElementById("sig").value = sig
            console.log(sig)
        }
    </script>

</body>

</html>