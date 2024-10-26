<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    include_once "../../dbconnect.php";

    $table_name = "temp{$_SESSION['userid']}";
    $sql = "DROP TABLE $table_name";
    $query = $conn->query($sql);
}
?>