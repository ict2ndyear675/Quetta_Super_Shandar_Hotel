<?php

session_start();

// Destroy all session data
$_SESSION = array();

// Destroy the session
session_destroy();

// Return to the admin login page
header("Location: login.php");
exit();

?>