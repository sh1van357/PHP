<?php
// Set session timeout to 1 minute (60 seconds) for testing
ini_set('session.gc_maxlifetime', 60);
ini_set('session.cookie_lifetime', 60);

session_start();
session_destroy();

header("Location: login.php");
?>
