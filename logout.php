<?php
session_start();

// Unset all of the session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect the user back to the login page or any other desired page
header("Location: login.php");
exit();
?>