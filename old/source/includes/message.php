<?php
$login_message1 = $obj->get_message("login_msg");
$message1 = $obj->get_message("message");
$success_msg = $obj->get_message("success_msg");
$messageClass1 = $_SESSION['messageClass'];

$obj->remove_message("login_msg");
$obj->remove_message("message");
$obj->remove_message("success_msg");
$_SESSION['messageClass'] = "";
?>
