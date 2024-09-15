<?php
session_start();
include_once "../../dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../view-quiz.php");
} else {
    $quizId = $_POST['quizId'];
    $sqlStudent = "DELETE FROM score WHERE quizid = $quizId";
    $queryStudent = $conn->query($sqlStudent);
    $sqlQuiz = "DELETE FROM quiz WHERE quizid = $quizId";
    $queryQuiz = $conn->query($sqlQuiz);

    if ($queryQuiz) {
        echo json_encode(
            array(
                "status" => "success",
                "title" => "สำเร็จ",
                "text" => "ลบโจทย์ปัญหาข้อนี้แล้ว",
            )
        );
    } else {
        echo json_encode(
            array(
                "status" => "error",
                "title" => "ล้มเหลว",
                "text" => "ไม่สามารถลบโจทย์ปัญหาข้อนี้ได้",
            )
        );
    }
}