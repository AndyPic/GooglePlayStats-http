<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/inc/functions.php');
session_start();

if (@$_SESSION['loggedin'] !== true) {
    // Redirect to login, if not logged in
    header('Location: login.php');
    exit;
}

$endpoint = "http://apickard01.lampt.eeecs.qub.ac.uk/API/apps/users.php?app_user_id=" . $_SESSION['id'];
$user = json_decode(file_get_contents($endpoint), true)['data'][0];

$email = $user['email'];
$role = $user['user_level'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Play Stats - Account</title>
    <link rel="shortcut icon" type="image/x-icon" href="/imgs/gplayIcon.ico" />
    <link rel="stylesheet" href="css/colours.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/account.css">
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
    <script src="js/popups.js"></script>
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

        <div>
            <h2 class="top-bar">Profile</h2>
            <a href="logout.php">
                <button class="top-bar shadow1" id="log-out-button">LOG OUT</button>
            </a>
            <div>
                <h3>Account Information</h3>
                <label for="">
                    <input type="text" placeholder="Security Key">
                </label>

                <div class="row M-TB-10">
                    <div class="col-1"><b>Email</b></div>
                    <div class="col-5 info-container">
                        <button class="update-info-button fa" id="update-email-button" title="Update email address"></button>
                        <p class="data-locked" id="email-locked"><?= $email ?></p>
                        <input class="update-input shadow1 hidden" id="email-input" type="text" placeholder="example@qub.ac.uk">
                        <button class="submit-button shadow1 hidden" id="email-submit">SUBMIT</button>
                        <div class="popup">
                            <span class="popuptext">Email succesfully updated.</span>
                            <span class="popuptext">Invalid email adress entered. (name@name.com)</span>
                            <span class="popuptext">Failed to update email.</span>
                        </div>
                    </div>
                    <div class="col-1"><b>Name</b></div>
                    <div class="col-5 info-container">
                        <button class="update-info-button fa" id="update-name-button" title="Update display name"></button>
                        <p class="data-locked" id="name-locked"><?= $_SESSION['display_name'] ?></p>
                        <input class="update-input shadow1 hidden" id="name-input" type="text" placeholder="New display name">
                        <button class="submit-button shadow1 hidden" id="name-submit">SUBMIT</button>
                        <div class="popup">
                            <span class="popuptext">Name succesfully updated.</span>
                            <span class="popuptext">Invalid name entered.</span>
                            <span class="popuptext">Failed to update name.</span>
                        </div>
                    </div>

                </div>
                <div class="row M-TB-10">

                    <div class="col-1"><b>Pass</b></div>
                    <div class="col-5 info-container">
                        <button class="update-info-button fa" id="update-pw-button" title="Update password"></button>
                        <p class="data-locked" id="pw-locked">Change password?</p>
                        <input class="update-input shadow1 hidden" id="pw-input" type="text" placeholder="New password">
                        <button class="submit-button shadow1 hidden" id="pw-submit">SUBMIT</button>
                        <div class="popup">
                            <span class="popuptext">Password succesfully updated.</span>
                            <span class="popuptext">Invalid password entered.</span>
                            <span class="popuptext">Failed to update password.</span>
                        </div>
                    </div>
                    <div class="col-1"><b>Role</b></div>
                    <div class="col-5"><?= $role ?></div>

                </div>
                <div class="row M-TB-10">
                    <div class="col-1"><b>ID</b></div>
                    <div class="col-5" id="user-id"><?= $_SESSION['id'] ?></div>
                </div>

            </div>
            <?php
            if ($role === "Administrator") {
                // Display admin controll panel
                echo "
                ";
            }
            ?>
        </div>
        <div>
            <h3 style='display: inline-block'>Admin Controll Panel</h3>
            <button style='display: inline-block' title='Toggle Controll Panel' class='fas unselectable' id='admin-toggle' onclick='elementToggle(this.id);'></button>
            <div class='toggle-target padT10' style='display: none;'>

                <div class='admin-panel shadow1'>
                    <h4>Admin Key</h4>
                    <label for='admin-key'>API Key
                        <input id='admin-key' type='text' value="">
                    </label>
                </div>
                <div class='admin-panel shadow1'>
                    <h2>Users</h2>
                    <h4>Amend User Information</h4>
                    <form method='POST' action='' class="posRel">
                        <label for='user-target-id'>Target user ID or Email
                            <input id='user-target-id' type='text' name='target_id' value="">
                        </label>

                        <label for='amend-email'>Change email
                            <input id='amend-email' type='text' name='email' value="">
                        </label>

                        <label for='amend-password'>Change password
                            <input id='amend-password' type='text' name='password' value="">
                        </label>

                        <label for='amend-level'>Change level
                            <select name='level' id='amend-level'>
                                <option value=''>None</option>
                                <option value='1'>Administrator</option>
                                <option value='2'>Moderator</option>
                                <option value='3'>Developer</option>
                                <option value='4'>User</option>
                            </select>
                        </label>
                        <button id="update-user-button" type="button" onclick='adminUpdate(this.id)'>Submit</button>
                        <div class="popup">
                            <span class="popuptext">User succesfully updated.</span>
                            <span class="popuptext">Unable to update user.</span>
                        </div>
                    </form>

                    <h4>Delete User</h4>
                    <form method='POST' action='' class="posRel">
                        <label for='delete-user'>User ID or Email
                            <input id='delete-user' type='text' name='delete_user' value="">
                        </label>
                        <button id="delete-user-button" type="button" onclick='adminDelete(this.id)'>Submit</button>
                        <div class="popup">
                            <span class="popuptext">User succesfully deleted.</span>
                            <span class="popuptext">Unable to delete user.</span>
                        </div>
                    </form>
                </div>

                <div class='admin-panel shadow1'>
                    <h2>Pitches</h2>
                    <h4>Delete pitch</h4>
                    <form method='POST' action='' class="posRel">
                        <label for='delete-pitch'>Pitch ID
                            <input id='delete-pitch' type='text' name='delete_pitch' value="">
                        </label>
                        <button id="delete-pitch-button" type="button" onclick='adminDelete(this.id)'>Submit</button>
                        <div class="popup">
                            <span class="popuptext">Pitch succesfully deleted.</span>
                            <span class="popuptext">Unable to delete pitch.</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            var apiId
            var userId = document.getElementById("user-id").textContent


            var adminUpdate = async buttonId => {
                var thisButton = document.getElementById(buttonId)
                var thisForm = thisButton.parentElement

                var inputs = thisForm.getElementsByTagName("input")
                var selects = thisForm.getElementsByTagName("select")

                var apiKey = document.getElementById("admin-key").value

                var messages = new Array()
                for (loop = 0; loop < inputs.length; loop++) {
                    var tempName = inputs[loop].getAttribute("name")
                    var tempVal = inputs[loop].value

                    if (tempVal != "" && tempVal != null) {
                        messages.push(tempName + "=" + tempVal)
                    }
                }

                if (selects != null) {
                    for (loop = 0; loop < selects.length; loop++) {
                        var tempName = selects[loop].getAttribute("name")
                        var tempVal = selects[loop].value

                        if (tempVal != "" && tempVal != null) {
                            messages.push(tempName + "=" + tempVal)
                        }
                    }
                }


                var sig = generateSignature(messages, apiKey)


                apiId2 = apiId['data'][0]['api_user_id']

                var msgKeys = new Array()
                var msgVals = new Array()
                var data = {}
                for (loop = 0; loop < messages.length; loop++) {
                    msgHodler = messages[loop].split("=")

                    data[msgHodler[0]] = msgHodler[1]
                }

                data['user_id'] = apiId2
                data['sig'] = sig

                adminUpdateUser(thisButton, data)
            }

            var adminUpdateUser = async (thisButton, data) => {

                goPut("apps/users.php", data).then(response => {
                    console.log(response)
                    // Check if data were updated
                    if (response["status"] == "success") {
                        runPopup(thisButton, 1)
                    } else {
                        runPopup(thisButton, 3)
                    }
                })
            }

            var adminDeletePitch = async (thisButton, pitchId, userId, signature) => {

                goDelete("apps/pitch.php", {
                    delete_pitch: pitchId,
                    user_id: userId,
                    sig: signature
                }).then(response => {
                    console.log(response)
                    // Check if data were updated
                    if (response["status"] == "success") {
                        runPopup(thisButton, 1)
                    } else {
                        runPopup(thisButton, 3)
                    }
                })
            }

            var adminDeleteUser = async (thisButton, deleteId, userId, signature) => {
                console.log(signature)

                goDelete("apps/users.php", {
                    delete_user: deleteId,
                    user_id: userId,
                    sig: signature
                }).then(response => {
                    console.log(response)
                    // Check if data were updated
                    if (response["status"] == "success") {
                        runPopup(thisButton, 1)
                    } else {
                        runPopup(thisButton, 3)
                    }
                })
            }


            var adminDelete = async buttonId => {
                var thisButton = document.getElementById(buttonId)
                var thisForm = thisButton.parentElement

                var inputs = thisForm.getElementsByTagName("input")
                var selects = thisForm.getElementsByTagName("select")

                var apiKey = document.getElementById("admin-key").value

                var messages = new Array()
                for (loop = 0; loop < inputs.length; loop++) {
                    var tempName = inputs[loop].getAttribute("name")
                    var tempVal = inputs[loop].value

                    if (tempVal != "" && tempVal != null) {
                        messages.push(tempName + "=" + tempVal)
                    }
                }

                if (selects != null) {
                    for (loop = 0; loop < selects.length; loop++) {
                        var tempName = selects[loop].getAttribute("name")
                        var tempVal = selects[loop].value

                        if (tempVal != "" && tempVal != null) {
                            messages.push(tempName + "=" + tempVal)
                        }
                    }
                }

                var sig = generateSignature(messages, apiKey)

                apiId2 = apiId['data'][0]['api_user_id']

                message = messages[0].split("=")[1]

                if (buttonId.includes("pitch")) {
                    adminDeletePitch(thisButton, message, apiId2, sig)
                } else {
                    adminDeleteUser(thisButton, message, apiId2, sig)
                }
            }

            var updateButtons = document.getElementsByClassName("update-info-button")
            for (loop = 0; loop < updateButtons.length; loop++) {
                updateButtons[loop].onclick = thisEvent => {
                    var thisButton = thisEvent.srcElement
                    var input = thisButton.parentElement.querySelector(".update-input")
                    var pTag = thisButton.parentElement.querySelector(".data-locked")
                    var submitButton = thisButton.parentElement.querySelector(".submit-button")

                    input.classList.toggle("hidden")
                    pTag.classList.toggle("hidden")
                    submitButton.classList.toggle("hidden")
                    thisButton.classList.toggle("active")
                }
            }

            var submitButtons = document.getElementsByClassName("submit-button")
            for (loop = 0; loop < submitButtons.length; loop++) {
                submitButtons[loop].onclick = async thisEvent => {
                    var thisButton = thisEvent.srcElement
                    var input = thisButton.parentElement.querySelector(".update-input")
                    var pTag = thisButton.parentElement.querySelector(".data-locked")
                    var newInfo = input.value
                    var userId = document.getElementById("user-id").textContent

                    // Route to correct function
                    inputId = input.getAttribute("id")
                    if (inputId.includes("email")) {
                        await updateEmail(thisButton, pTag, newInfo, userId)
                    } else if (inputId.includes("name")) {
                        await updateName(thisButton, pTag, newInfo, userId)
                    } else if (inputId.includes("pw")) {
                        await updatePassword(thisButton, newInfo, userId)
                    }

                }
            }

            var updatePassword = async (thisButton, newInfo, userId) => {

                // Guard clause for invalid password (must contain a number and be 6+ chars long)
                if (!validatePasswordFormat(newInfo)) {
                    runPopup(thisButton, 3)
                    return
                }

                goPut("apps/users.php", {
                    password: newInfo,
                    target_id: userId
                }).then(response => {
                    // Check if data were updated
                    if ("rows_updated" in response && response["rows_updated"] == 1) {
                        runPopup(thisButton, 1)
                    } else {
                        runPopup(thisButton, 5)
                    }
                })
            }

            var updateName = async (thisButton, pTag, newInfo, userId) => {

                // Guard clause for invalid name
                if (!validateDisplayNameFormat(newInfo)) {
                    runPopup(thisButton, 3)
                    return
                }

                goPut("apps/users.php", {
                    display_name: newInfo,
                    target_id: userId
                }).then(response => {
                    // Check if data were updated
                    if ("rows_updated" in response && response["rows_updated"] == 1) {
                        pTag.innerText = newInfo
                        runPopup(thisButton, 1)
                    } else {
                        runPopup(thisButton, 5)
                    }
                })
            }

            var updateEmail = async (thisButton, pTag, newInfo, userId) => {

                // Guard clause for invalid email format (string@string.string <- required)
                if (!validateEmailFormat(newInfo)) {
                    runPopup(thisButton, 3)
                    return
                }
                goGet("apps/users.php", "validate_email=" + newInfo).then(response => {
                    if (response['data'] == "invalid") {
                        //invalid - email already in use
                        goPut("apps/users.php", {
                            email: newInfo,
                            target_id: userId
                        }).then(response2 => {
                            // Check if data were updated
                            if ("rows_updated" in response2 && response2["rows_updated"] == 1) {
                                pTag.innerText = newInfo
                                runPopup(thisButton, 1)
                            } else {
                                runPopup(thisButton, 5)
                            }
                        })
                    } else {
                        runPopup(thisButton, 5)
                    }
                })

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