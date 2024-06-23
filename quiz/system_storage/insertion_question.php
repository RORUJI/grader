<?php
session_start();
include_once "../../dbconnect.php";
$typeID = $_POST['type'];
$question = $_POST['question'];
if ($typeID == 1) {
    $selectSQL = $_POST['select_code'];
    if ($selectSQL == "") {
        echo json_encode(array("status" => "error", "msg" => "กรุณากรอก SELECT CODE!"));
    } else {
        try {
            $sql = "INSERT INTO question(question, select_code, typeID) VALUES(?, ?, ?);";
            $statement = $conn->prepare($sql);
            $statement->bind_param('ssi', $question, $selectSQL, $typeID);
            $result = $statement->execute();
            if ($result) {
                echo json_encode(array("status" => "success", "msg" => "เพิ่มข้อมูลลง Database สำเร็จแล้ว!"));
            } else {
                echo json_encode(array("status" => "error", "msg" => "เพิ่มข้อมูลลง Database ไม่สำเร็จ!"));
            }
        } catch (Exception $e) {
            echo json_encode(array("status" => "error", "msg" => "ข้อผิดพลาด -> " . $e->getMessage()));
        }
    }
} else if ($typeID == 2) {
    $selectSQL = $_POST['select_code'];
    $insertSQL = $_POST['insert_code'];
    $deleteSQL = $_POST['delete_code'];
    if ($selectSQL == "") {
        echo json_encode(array("status" => "error", "msg" => "กรุณากรอก SELECT CODE!"));
    } else if ($insertSQL == "") {
        echo json_encode(array("status" => "error", "msg" => "กรุณากรอก INSERT CODE!"));
    } else if ($deleteSQL == "") {
        echo json_encode(array("status" => "error", "msg" => "กรุณากรอก DELETE CODE!"));
    } else {
        try {
            $sql = "INSERT INTO question(question, select_code, insert_code, delete_code, typeID) VALUES(?, ?, ?, ?, ?);";
            $statement = $conn->prepare($sql);
            $statement->bind_param('ssssi', $question, $selectSQL, $insertSQL, $deleteSQL, $typeID);
            $result = $statement->execute();
            if ($result) {
                echo json_encode(array("status" => "success", "msg" => "เพิ่มข้อมูลลง Database สำเร็จแล้ว!"));
            } else {
                echo json_encode(array("status" => "error", "msg" => "เพิ่มข้อมูลลง Database ไม่สำเร็จ!"));
            }
        } catch (Exception $e) {
            echo json_encode(array("status" => "error", "msg" => "ข้อผิดพลาด -> " . $e->getMessage()));
        }
    }
} else if ($typeID == 3) {
    $selectSQL = $_POST['select_code'];
    $insertSQL = $_POST['insert_code'];
    $deleteSQL = $_POST['delete_code'];
    if ($selectSQL == "") {
        echo json_encode(array("status" => "error", "msg" => "กรุณากรอก SELECT CODE!"));
    } else if ($insertSQL == "") {
        echo json_encode(array("status" => "error", "msg" => "กรุณากรอก INSERT CODE!"));
    } else if ($deleteSQL == "") {
        echo json_encode(array("status" => "error", "msg" => "กรุณากรอก DELETE CODE!"));
    } else {
        try {
            $sql = "INSERT INTO question(question, select_code, insert_code, delete_code, typeID) VALUES(?, ?, ?, ?, ?);";
            $statement = $conn->prepare($sql);
            $statement->bind_param('ssssi', $question, $selectSQL, $insertSQL, $deleteSQL, $typeID);
            $result = $statement->execute();
            if ($result) {
                echo json_encode(array("status" => "success", "msg" => "เพิ่มข้อมูลลง Database สำเร็จแล้ว!"));
            } else {
                echo json_encode(array("status" => "error", "msg" => "เพิ่มข้อมูลลง Database ไม่สำเร็จ!"));
            }
        } catch (Exception $e) {
            echo json_encode(array("status" => "error", "msg" => "ข้อผิดพลาด -> " . $e->getMessage()));
        }
    }
} else {
    $selectSQL = $_POST['select_code'];
    $insertSQL = $_POST['insert_code'];
    $updateSQL = $_POST['update_code'];
    $beforeSQL = $_POST['before_code'];
    if ($selectSQL == "") {
        echo json_encode(array("status" => "error", "msg" => "กรุณากรอก SELECT CODE!"));
    } else if ($insertSQL == "") {
        echo json_encode(array("status" => "error", "msg" => "กรุณากรอก INSERT CODE!"));
    } else if ($updateSQL == "") {
        echo json_encode(array("status" => "error", "msg" => "กรุณากรอก UPDATE CODE!"));
    } else if ($beforeSQL == "") {
        echo json_encode(array("status" => "error", "msg" => "กรุณากรอก BEFORE CODE!"));
    } else {
        try {
            $sql = "INSERT INTO question(question, select_code, insert_code, update_code, before_code, typeID) VALUES(?, ?, ?, ?, ?, ?);";
            $statement = $conn->prepare($sql);
            $statement->bind_param('sssssi', $question, $selectSQL, $insertSQL, $updateSQL, $beforeSQL, $typeID);
            $result = $statement->execute();
            if ($result) {
                echo json_encode(array("status" => "success", "msg" => "เพิ่มข้อมูลลง Database สำเร็จแล้ว!"));
            } else {
                echo json_encode(array("status" => "error", "msg" => "เพิ่มข้อมูลลง Database ไม่สำเร็จ!"));
            }
        } catch (Exception $e) {
            echo json_encode(array("status" => "error", "msg" => "ข้อผิดพลาด -> " . $e->getMessage()));
        }
    }
}
?>