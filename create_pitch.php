<?php
session_start();

if (!isset($_POST['user_id'], $_POST['pitch_title'], $_POST['name'], $_POST['genre_id'], $_POST['description'], $_POST['motive'], $_POST['audience'])) {
    // Send back to pitch creation
    header("Location: http://apickard01.lampt.eeecs.qub.ac.uk/new_pitch.php");
    exit();
}

$url = 'http://apickard01.lampt.eeecs.qub.ac.uk/API/apps/pitch.php';
$data = array(
    'user_id' => $_POST['user_id'],
    'pitch_title' => $_POST['pitch_title'],
    'name' => $_POST['name'],
    'genre_id' => $_POST['genre_id'],
    'description' => $_POST['description'],
    'motive' => $_POST['motive'],
    'audience' => $_POST['audience']
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

$res = explode(',', $result);

for ($loop = 0; $loop < count($res); $loop++) {
    if (strpos($res[$loop], "id") != 0) {
        $id = explode(':', $res[$loop])[1];
        if (strpos($id, "}") != 0) {
            $id = substr($id, 0, 2);
        }
    }
}

echo $id;

if (!$result) {
    // Send back to pitch creation on fail
    header("Location: http://apickard01.lampt.eeecs.qub.ac.uk/new_pitch.php");
    exit();
} else {
    // Send to pitch page after pitch created
    header("Location: http://apickard01.lampt.eeecs.qub.ac.uk/pitch.php?pitch={$id}");
    exit();
}