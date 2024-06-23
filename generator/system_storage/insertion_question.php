<?php
session_start();
include_once "../../dbconnect.php";
$typeID = $_POST['type'];
$quiz = $_POST['quiz'];
$answercode = $_POST['answercode'];
$resultcode = $_POST['resultcode'];
$temptablecode = $_POST['temptablecode'];
        try {
            $sql = "INSERT INTO quiz(quiz, answercode, resultcode, temptablecode, typeID) VALUES(?, ?, ?, ?, ?);";
            $statement = $conn->prepare($sql);
            $statement->bind_param('ssssi', $quiz, $answercode, $resultcode, $temptablecode, $typeID);
            $result = $statement->execute();
            if ($result) {
                echo json_encode(array("status" => "success", "msg" => "เพิ่มข้อมูลลง Database สำเร็จแล้ว!"));
            } else {
                echo json_encode(array("status" => "error", "msg" => "เพิ่มข้อมูลลง Database ไม่สำเร็จ!"));
            }
        } catch (Exception $e) {
            echo json_encode(array("status" => "error", "msg" => "ข้อผิดพลาด -> " . $e->getMessage()));
        }
?>