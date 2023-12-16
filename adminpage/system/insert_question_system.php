<?php
session_start();

include_once "../../dbconnect.php";

$question = $_POST['question'];
$type = $_POST['type'];
$select_code = $_POST['select_code'];
$insert_code = $_POST['insert_code'];
$delete_code = $_POST['delete_code'];

if ($question == "") {
    echo json_encode(array('status' => 'error', 'msg' => 'กรุณากรอกโจทย์ปัญหา'));
} else if ($type == "") {
    echo json_encode(array('status' => 'error', 'msg' => 'กรุณาเลือกประเภท'));
} else {
    try {
        if ($type == 1) {
            if ($select_code == "") {
                echo json_encode(array('status' => 'error', 'msg' => 'กรุณาใส่ SELECT CODE ด้วย'));
            } else {
                $sql = "INSERT INTO question(question, select_code, insert_code, delete_code, typeID) VALUES('$question', '$select_code', '$insert_code', '$delete_code', '$type')";
                $result = $conn->query($sql);

                if ($result) {
                    echo json_encode(array('status' => 'success', 'msg' => 'เพิ่มโจทย์ปัญหาสำเร็จ'));
                } else {
                    echo json_encode(array('status' => 'error', 'msg' => 'เพิ่มโจทย์ปัญหาไม่สำเร็จ'));
                }
            }
        } else if ($type == 2) {
            if ($select_code == "") {
                echo json_encode(array('status' => 'error', 'msg' => 'กรุณาใส่ SELECT CODE ด้วย'));
            } else if ($delete_code == "") {
                echo json_encode(array('status' => 'error', 'msg' => 'กรุณาใส่ DELETE CODE ด้วย'));
            } else {
                $sql = "INSERT INTO question(question, select_code, insert_code, delete_code, typeID) VALUES('$question', '$select_code', '$insert_code', '$delete_code', '$type')";
                $result = $conn->query($sql);

                if ($result) {
                    echo json_encode(array('status' => 'success', 'msg' => 'เพิ่มโจทย์ปัญหาสำเร็จ'));
                } else {
                    echo json_encode(array('status' => 'error', 'msg' => 'เพิ่มโจทย์ปัญหาไม่สำเร็จ'));
                }
            }
        } else {
            if ($select_code == "") {
                echo json_encode(array('status' => 'error', 'msg' => 'กรุณาใส่ SELECT CODE ด้วย'));
            } else if ($insert_code == "") {
                echo json_encode(array('status' => 'error', 'msg' => 'กรุณาใส่ INSERT CODE ด้วย'));
            } else {
                $sql = "INSERT INTO question(question, select_code, insert_code, delete_code, typeID) VALUES('$question', '$select_code', '$insert_code', '$delete_code', '$type')";
                $result = $conn->query($sql);

                if ($result) {
                    echo json_encode(array('status' => 'success', 'msg' => 'เพิ่มโจทย์ปัญหาสำเร็จ'));
                } else {
                    echo json_encode(array('status' => 'error', 'msg' => 'เพิ่มโจทย์ปัญหาไม่สำเร็จ'));
                }
            }
        }
    } catch (Exception $e) {
        echo json_encode(array('status' => 'error', 'msg' => 'เพิ่มโจทย์ปัญหาไม่สำเร็จ'));
    }
}

?>