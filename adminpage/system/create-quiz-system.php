<?php
session_start();
include_once "../../dbconnect.php";

if (isset($_SESSION['userid'])) {
    if ($_SESSION['level'] > 1) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $request = $_POST['request'];
            $type_id = $_POST['type_id'];
            $sql_code = $_POST['sql_code'];

            switch ($type_id) {
                case 1:
                    include_once "create_selectQuiz_system.php";
                    break;
                case 2:
                    include_once "create_insertQuiz_system.php";
                    break;
                case 3:
                    include_once "create_deleteQuiz_system.php";
                    break;
                case 4:
                    include_once "create_updateQuiz_system.php";
                    break;
            }

            if (empty($request) && $create == "success") {
                include_once "thai_translation.php";
            } else {
                try {
                    $sql = "INSERT INTO quiz(quiz, answercode, resultcode, temptablecode, typeID) VALUES(?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('ssssi', $request, $sql_code, $result_code, $create_temptable, $type_id);
                    if ($stmt->execute()) {
                        echo json_encode(
                            array(
                                "status" => "success",
                                "msg" => "เพิ่มข้อมูลลง Database สำเร็จแล้ว!"
                            )
                        );
                    } else {
                        echo json_encode(
                            array(
                                "status" => "error",
                                "msg" => "เพิ่มข้อมูลลง Database ไม่สำเร็จแล้ว!"
                            )
                        );
                    }
                } catch (Exception $e) {
                    echo json_encode(
                        array(
                            "status" => "error",
                            "msg" => "เพิ่มข้อมูลลง Database ไม่สำเร็จแล้ว!"
                        )
                    );
                }
            }

        } else {
            header('location: ../create-quiz-myself.php');
        }
    } else {
        header('location: ../../system/logout_system.php');
    }
} else {
    header('location: ../../system/logout_system.php');
}
