<?php
session_start();
if (!isset($_SESSION['username']) && !isset($_POST['quizid'])) {
    header("location: ../../index.php");
} else {
    include_once "../../dbconnect.php";
    $quizid = $_POST['quizid'];
    //Load sql code from table.
    $loadtable = $conn->query("SELECT * FROM quiz WHERE quizid = '$quizid' LIMIT 1");
    $loadresult = $loadtable->fetch_assoc();
    $username = strtolower($_SESSION['username']);
    $usertable = "temp$username";
    $selectcode = str_replace("\$usertable", $usertable, $loadresult['temptablecode']);
    //Create temporarily table.
    $temptable = $conn->query("CREATE TABLE $usertable AS $selectcode");
}
?>