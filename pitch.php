<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/inc/functions.php');
session_start();

if (isset($_GET['pitch']) && $_GET['pitch'] != "") {
    $pitch_id = $_GET['pitch'];
    $endpoint = "http://apickard01.lampt.eeecs.qub.ac.uk/API/apps/pitch.php?pitch={$pitch_id}";
    $pitch_info = json_decode(file_get_contents($endpoint), true)['data'][0];

    $user_id = $pitch_info['user_id'];
    $endpoint = "http://apickard01.lampt.eeecs.qub.ac.uk/API/apps/users.php?user_id={$user_id}";
    $author_info = json_decode(file_get_contents($endpoint), true)['data'][0];
} else {
    // Send to all pitches page
    header("Location: http://apickard01.lampt.eeecs.qub.ac.uk/all_pitches.php");
    exit();
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
    <link rel="stylesheet" href="css/pitch.css">
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

        <div class="pitch-container">
            <div class="pitch-title">
                <h2><?= $pitch_info['pitch_title'] ?></h2>
                <p><b>By:</b> <?= $author_info['display_name'] ?></p>
            </div>

            <div class="row MT-10">
                <div class="col-6 pitch-panel"><b>Genre:</b> <?= $pitch_info['genre'] ?></div>
                <div class="col-6 pitch-panel"><b>Name:</b> <?= $pitch_info['name'] ?></div>
            </div>
            <div class="row MT-10">
                <div class="col-12 pitch-panel"><?= $pitch_info['description'] ?></div>
            </div>

            <div class="row MT-10">
                <div class="col-12 pitch-panel"><?= $pitch_info['motive'] ?></div>
            </div>

            <div class="row MT-10">
                <div class="col-12 pitch-panel"><?= $pitch_info['audience'] ?></div>
            </div>
            <div class="row MT-10">
                <div class="col-6 pitch-panel"><b>Rating:</b> <?= round($pitch_info['rating'], 1, PHP_ROUND_HALF_UP) ?></div>
                <div class="col-6 pitch-panel"><b>Votes:</b> <?= $pitch_info['votes'] ?></div>
            </div>

            <?php
            $star_inputs = array();
            // STAR RATING HTML FROM: https://codepen.io/neilpomerleau/pen/wzxzQr PHP by me though!
            if (@$_SESSION['loggedin'] && @array_key_exists($pitch_id, $_SESSION['voted_on'])) {
                // Lock inputs if already voted / only vote if logged in
                for ($loop = 0; $loop < 5; $loop++) {
                    $num = $loop + 1;
                    if ($num == $_SESSION['voted_on'][$pitch_id]) {
                        $star_inputs[$loop] = "<input type='radio' name='rating' value='{$num}' readonly checked/>";
                    } else {
                        $star_inputs[$loop] = "<input type='radio' name='rating' value='{$num}' readonly/>";
                    }
                }
                echo "<form method='POST' action='vote_pitch.php' id='vote-form' class='rating' style='pointer-events: none;'>
                    <div class='rating'>
                <label>
                    {$star_inputs[0]}
                    <span class='icon'>★</span>
                </label>
                <label>
                    {$star_inputs[1]}
                    <span class='icon'>★</span>
                    <span class='icon'>★</span>
                </label>
                <label>
                    {$star_inputs[2]}
                    <span class='icon'>★</span>
                    <span class='icon'>★</span>
                    <span class='icon'>★</span>
                </label>
                <label>
                    {$star_inputs[3]}
                    <span class='icon'>★</span>
                    <span class='icon'>★</span>
                    <span class='icon'>★</span>
                    <span class='icon'>★</span>
                </label>
                <label>
                    {$star_inputs[4]}
                    <span class='icon'>★</span>
                    <span class='icon'>★</span>
                    <span class='icon'>★</span>
                    <span class='icon'>★</span>
                    <span class='icon'>★</span>
                </label>
                </div>
                <input type='hidden' name='pitch_id' value='{$pitch_id}'>
                </form>";
            } else if (@$_SESSION['loggedin']) {
                echo "<h4>How would you rate this idea?</h4>";
                for ($loop = 0; $loop < 5; $loop++) {
                    $num = $loop + 1;
                    $star_inputs[$loop] = "<input type='radio' name='rating' value='{$num}' />";
                }
                echo "<form method='POST' action='vote_pitch.php' id='vote-form'>
                <div class='rating'>
                <label>
                    {$star_inputs[0]}
                    <span class='icon'>★</span>
                </label>
                <label>
                    {$star_inputs[1]}
                    <span class='icon'>★</span>
                    <span class='icon'>★</span>
                </label>
                <label>
                    {$star_inputs[2]}
                    <span class='icon'>★</span>
                    <span class='icon'>★</span>
                    <span class='icon'>★</span>
                </label>
                <label>
                    {$star_inputs[3]}
                    <span class='icon'>★</span>
                    <span class='icon'>★</span>
                    <span class='icon'>★</span>
                    <span class='icon'>★</span>
                </label>
                <label>
                    {$star_inputs[4]}
                    <span class='icon'>★</span>
                    <span class='icon'>★</span>
                    <span class='icon'>★</span>
                    <span class='icon'>★</span>
                    <span class='icon'>★</span>
                </label>
                </div>
                <input type='hidden' name='pitch_id' value='{$pitch_id}'>
            </form>";
            }

            if (@!array_key_exists($pitch_id, $_SESSION['voted_on']) && @$_SESSION['loggedin']) {
                // Can submit - only if havn't done before (Only stored in session, so will time out eventually / can be manually manipulated, but prevents spam resubmiting!)
                echo '<button type="submit" form="vote-form" id="rating-submit-button">Submit rating!</button>';
            }
            ?>
        </div>



        <script>
            /*  
                individual pitch page, check if pitch owner == signed in user (sessions id) and make editable, otherwise ive acces to vote system, only allow 1 vote per person, some how?
            */
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