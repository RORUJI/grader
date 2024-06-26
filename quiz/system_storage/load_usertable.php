<?php
session_start();
$usertable_code = $_POST['resultcode'];
$usertable = $_POST['table'];
$_SESSION[$_SESSION['username']] = $usertable_code;
$_SESSION['usertable'] = $usertable;
echo json_encode(array('status' => 'success'));
?>