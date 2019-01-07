<?php session_start(); 
if(isset($_SESSION['user']))
session_unset($_SESSION['user']);
session_unset($_SESSION['scart']);
session_unset(); 
session_destroy(); 
header("Location: index.php"); /* Redirect browser */ 
exit;
?>