<?php
session_start();

include_once "../../dbconnect.php";

header('Content-Type: application/json');

if (!isset($_POST['quizId'])) {
    header('Location: ../home.php');
} else {
    $quizId = $_POST['quizId'];
    $sql = "SELECT * FROM score WHERE quizid = $quizId";
    $query = $conn->query($sql);

    $disabledItems = [];

    if ($query->num_rows > 0) {
        while ($result = $query->fetch_assoc()) {
            $disabledItems[] = (int) $result['userid'];
        }
    }

    echo json_encode($disabledItems);
}
?>