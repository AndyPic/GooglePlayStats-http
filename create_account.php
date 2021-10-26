<?php
session_start();

if (!isset($_POST['email'], $_POST['password'], $_POST['display_name'])) {
    // Send back to account creation
    header("Location: http://apickard01.lampt.eeecs.qub.ac.uk/new_user.php");
    exit();
}

$url = 'http://apickard01.lampt.eeecs.qub.ac.uk/API/apps/users.php';
$data = array(
    'email' => $_POST['email'],
    'password' => $_POST['password'],
    'display_name' => $_POST['display_name'],
    'level' => $_POST['level']
);

$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

if (!$result) {
    // Send back to account creation on fail
    header("Location: http://apickard01.lampt.eeecs.qub.ac.uk/new_user.php");
    exit();
} else {
    // Send to login after account created
    header("Location: http://apickard01.lampt.eeecs.qub.ac.uk/account_success.php");
    exit();
}
