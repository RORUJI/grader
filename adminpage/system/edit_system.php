<?php
session_start();
include_once "../../dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../view-quiz.php");
} else {
    try {
        $quizId = $_POST['quizId'];
        $quiz = $_POST['quiz'];
        $type = $_POST['type'];
        $answerCode = $_POST['answerCode'];
        $resultCode = $_POST['resultCode'];
        $temptableCode = $_POST['temptableCode'];

        $sql = "UPDATE quiz SET quiz = '$quiz',
                typeID = $type,
                answercode = '$answerCode',
                resultcode = '$resultCode',
                temptablecode = '$temptableCode'
                WHERE quizid = $quizId";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo json_encode(
                array(
                    'status' => 'error',
                    'title' => 'ล้มเหลว',
                    'text' => 'แก้ไขโจทย์ปัญหาไม่สำเร็จเนื่องจาก' . $conn->error
                )
            );
        } else {
            $stmt->execute();

            $stmt->close();
            $conn->close();
        }

        echo json_encode(
            array(
                'status' => 'success',
                'title' => 'สำเร็จ',
                'text' => 'แก้ไขโจทย์ปัญหาเรียบร้อยแล้ว'
            )
        );
    } catch (PDOException $e) {
        echo "No interests selected.";
    }
}
?>