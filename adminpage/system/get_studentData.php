<?php
session_start();

try {
    include_once "../../dbconnect.php";

    $sql = "SELECT * FROM score ";
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>