<?php
session_start();

session_destroy();
// Send back to main page after log out
header('Location: index.php');
