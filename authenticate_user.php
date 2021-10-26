<?php
session_start();

if (!isset($_POST['email'], $_POST['password'])) {
    // Send back to login
    header("Location: http://apickard01.lampt.eeecs.qub.ac.uk/login.php");
    exit();
}

$email = $_POST['email'];
$password = $_POST['password'];

$endpoint = "http://apickard01.lampt.eeecs.qub.ac.uk/API/apps/users.php?email=" . $email;

$user = json_decode(file_get_contents($endpoint), true)['data'][0];

if (password_verify($password, $user['password'])) {

    // Not storing email or password, just incase!
    session_regenerate_id();
    $_SESSION['loggedin'] = true;
    $_SESSION['display_name'] = $user['display_name'];
    $_SESSION['user_level'] = $user['user_level'];
    $_SESSION['id'] = $user['id'];

    // To index after login
    header("Location: http://apickard01.lampt.eeecs.qub.ac.uk");
} else {
    // Invalid PW, send back to login
    header("Location: http://apickard01.lampt.eeecs.qub.ac.uk/login.php");
    exit();
}
