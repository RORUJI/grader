<?php
session_start();
include_once "../../dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] != "GET") {
    header("Location: ../view-quiz.php");
} else {
    $userId = $_GET['userId'];
    $quizId = $_GET['quizId'];

    $sql = "DELETE FROM score WHERE userid = $userId AND quizid = $quizId";
    $query = $conn->query($sql);

    try {
        if ($query) {
            echo json_encode(
                array(
                    "status" => "success",
                    "title" => "สำเร็จ",
                    "text" => "ลบนักเรียนคนนี้แล้ว"
                )
            );
        } else {
            if ($query) {
                echo json_encode(
                    array(
                        "status" => "success",
                        "title" => "สำเร็จ",
                        "text" => "ลบนักเรียนคนนี้แล้ว"
                    )
                );
            } else {
                echo json_encode(
                    array(
                        "status" => "error",
                        "title" => "ล้มเหลว",
                        "text" => "ไม่สามารถลบนักเรียนคนนี้ได้"
                    )
                );
            }
        }
    } catch (Exception $e) {
        echo json_encode(
            array(
                "status" => "error",
                "title" => "ล้มเหลว",
                "text" => "ไม่สามารถลบนักเรียนคนนี้ได้เพราะ $e"
            )
        );
    }
}
?>