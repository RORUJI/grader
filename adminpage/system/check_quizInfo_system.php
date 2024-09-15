<?php
session_start();
include_once "../../dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("Location: ../view-quiz.php");
} else {
    $quizId = $_POST['quizId'];
    $sql = "SELECT * FROM score WHERE quizid = $quizId";
    $query = $conn->query($sql);
    $rowCount = $query->num_rows;

    if ($rowCount > 0) {
        echo json_encode(
            array(
                "status" => "warning",
                "title" => "คำเตือน",
                "text" => "มีนักเรียนถูกกำหนดให้ทำโจทย์ข้อนี้<br>ต้องการลบไปพร้อมกันหรือไม่",
                "html" => true
            )
        );
    } else {
        echo json_encode(
            array(
                "status" => "success"
            )
        );
    }
}
?>