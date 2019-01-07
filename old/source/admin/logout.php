<?php
// Initialize the session. 
// If you are using session_name("something"), don't forget it now! 
session_start(); 
// Unset all of the session variables. 
session_unset(); 
// Finally, destroy the session. 
session_destroy(); 
header("Location: index.php"); /* Redirect browser */ 
/* Make sure that code below does not get executed when we redirect. */ 
exit;
?>