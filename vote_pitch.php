<?php
session_start();

if (!isset($_POST['rating'], $_POST['pitch_id']) && @!$_SESSION['loggedin']) {
    // Send back to pitches
    header("Location: http://apickard01.lampt.eeecs.qub.ac.uk/all_pitches.php");
    exit();
}

if (@array_key_exists($_POST['pitch_id'], $_SESSION['voted_on'])) {
    // Send back to pitch page
    header("Location: http://apickard01.lampt.eeecs.qub.ac.uk/pitch.php?pitch={$_POST['pitch_id']}");
    exit();
}

echo $_POST['pitch_id'];
echo $_POST['rating'];

// store in session[voted_on]
// the ID = key
// VALUE = the vote 1-5

$url = 'http://apickard01.lampt.eeecs.qub.ac.uk/API/apps/pitch.php';
$data = array(
    'target_id' => $_POST['pitch_id'],
    'rating' => $_POST['rating']
);

$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'PUT',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

// Store voted on in session array
$_SESSION['voted_on'][$_POST['pitch_id']] = $_POST['rating'];

// Send back to pitch page
header("Location: http://apickard01.lampt.eeecs.qub.ac.uk/pitch.php?pitch={$_POST['pitch_id']}");
exit();
