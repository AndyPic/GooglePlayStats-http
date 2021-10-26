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
    <title>Google Play Stats - About us</title>
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

    <div class="container-fullscreen">
        <!-- START of page content -->


        <h1>About Us</h1>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
            labore
            et
            dolore magna aliqua. Amet mauris commodo quis imperdiet. Sed ullamcorper morbi tincidunt ornare
            massa
            eget egestas purus viverra. Faucibus et molestie ac feugiat sed lectus vestibulum mattis
            ullamcorper.
            Commodo elit at imperdiet dui. Consectetur purus ut faucibus pulvinar elementum integer enim.
            Proin
            nibh
            nisl condimentum id venenatis. Amet dictum sit amet justo donec. Amet dictum sit amet justo
            donec
            enim
            diam vulputate ut. Felis bibendum ut tristique et egestas quis. Interdum varius sit amet mattis.
            Euismod
            quis viverra nibh cras pulvinar mattis. Nec feugiat nisl pretium fusce id velit ut. Id aliquet
            risus
            feugiat in ante metus dictum at tempor. Sed tempus urna et pharetra pharetra massa massa
            ultricies.
            At
            urna condimentum mattis pellentesque id nibh tortor id. Velit egestas dui id ornare arcu odio.
            Ut
            diam
            quam nulla porttitor massa id. Dui sapien eget mi proin sed. Diam quam nulla porttitor massa id
            neque.<br><br>

            Phasellus vestibulum lorem sed risus ultricies tristique. Pharetra pharetra massa massa
            ultricies mi
            quis hendrerit dolor magna. Sem fringilla ut morbi tincidunt augue interdum velit euismod. Lacus
            laoreet
            non curabitur gravida arcu ac. Sagittis orci a scelerisque purus semper eget duis. Amet tellus
            cras
            adipiscing enim eu turpis egestas pretium. Suspendisse in est ante in nibh. Sit amet porttitor
            eget
            dolor morbi non arcu risus quis. Quis enim lobortis scelerisque fermentum dui. Ac tortor vitae
            purus
            faucibus ornare suspendisse sed nisi. Libero nunc consequat interdum varius sit. Arcu dui
            vivamus
            arcu
            felis. Amet nulla facilisi morbi tempus iaculis urna id volutpat. Amet massa vitae tortor
            condimentum
            lacinia quis vel eros. Vitae et leo duis ut. Sed egestas egestas fringilla phasellus faucibus
            scelerisque eleifend donec pretium. Libero justo laoreet sit amet cursus sit amet. Turpis cursus
            in
            hac
            habitasse platea. Quis lectus nulla at volutpat diam ut venenatis tellus.<br><br>

            Vitae elementum curabitur vitae nunc sed velit. Justo laoreet sit amet cursus sit amet. Placerat
            in
            egestas erat imperdiet sed euismod nisi porta lorem. Id venenatis a condimentum vitae sapien.
            Lorem
            donec massa sapien faucibus et molestie ac feugiat sed. Eget gravida cum sociis natoque
            penatibus.
            In
            est ante in nibh mauris cursus. Sit amet massa vitae tortor condimentum lacinia quis vel eros.
            Porta
            non
            pulvinar neque laoreet suspendisse. Eget lorem dolor sed viverra ipsum nunc. Eget est lorem
            ipsum
            dolor.
            Nunc sed augue lacus viverra vitae congue eu consequat ac. Auctor neque vitae tempus quam
            pellentesque
            nec nam aliquam. Fermentum odio eu feugiat pretium nibh. Accumsan tortor posuere ac ut consequat
            semper
            viverra nam. Sit amet aliquam id diam maecenas ultricies mi. Aliquet porttitor lacus luctus
            accumsan
            tortor posuere ac ut consequat. Lectus vestibulum mattis ullamcorper velit sed ullamcorper morbi
            tincidunt. Nisl purus in mollis nunc sed id semper risus. Tortor pretium viverra suspendisse
            potenti
            nullam ac tortor.<br><br>

            Placerat in egestas erat imperdiet sed euismod nisi porta lorem. Sed euismod nisi porta lorem
            mollis
            aliquam ut porttitor leo. Nunc faucibus a pellentesque sit amet porttitor eget dolor. Nullam
            vehicula
            ipsum a arcu cursus vitae congue. Egestas erat imperdiet sed euismod nisi porta. Quis commodo
            odio
            aenean sed. Tellus in hac habitasse platea. Sit amet cursus sit amet. Rhoncus mattis rhoncus
            urna
            neque
            viverra. Eget dolor morbi non arcu risus quis varius. Accumsan in nisl nisi scelerisque eu
            ultrices
            vitae auctor eu. Tincidunt augue interdum velit euismod in. Sapien nec sagittis aliquam
            malesuada
            bibendum arcu vitae elementum curabitur.<br><br>

            Integer vitae justo eget magna fermentum iaculis eu non. Pellentesque id nibh tortor id aliquet
            lectus
            proin. Velit egestas dui id ornare arcu odio. Penatibus et magnis dis parturient montes
            nascetur.
            Hendrerit gravida rutrum quisque non tellus orci. Diam maecenas ultricies mi eget. Massa massa
            ultricies
            mi quis hendrerit dolor. Adipiscing diam donec adipiscing tristique risus nec feugiat in
            fermentum.
            Mauris in aliquam sem fringilla. Egestas maecenas pharetra convallis posuere morbi. Tellus
            integer
            feugiat scelerisque varius morbi enim nunc. Etiam tempor orci eu lobortis elementum nibh tellus
            molestie. Augue lacus viverra vitae congue eu. Convallis tellus id interdum velit laoreet.
            Imperdiet
            proin fermentum leo vel orci porta non pulvinar. Scelerisque varius morbi enim nunc faucibus a.
            Molestie
            a iaculis at erat pellentesque adipiscing commodo elit at. Nisi quis eleifend quam adipiscing
            vitae
            proin sagittis nisl rhoncus.
        </p>

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