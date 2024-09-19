<?php
	session_start();
    // Destroy all sessions
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    
    // Redirect to the login page after logout
    header('Location: index.php');
    exit();
?>