<?php
session_start();

include_once "../../dbconnect.php";

if ($_POST['type'] == "") {
    echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกประเภทโจทย์!"));
} else if ($_POST['table'] == "") {
    echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกตารางข้อมูล!"));
} else if (!isset($_POST['data'])) {
    echo json_encode(array("status" => "error", "msg" => "กรุณายืนยันโจทย์และตารางข้อมูลหรือเลือกข้อมูลที่ต้องการ!"));
} else if ($_POST['orderby'] != "" && $_POST['sort'] == "") {
    echo json_encode(array("status" => "error", "msg" => "กรุณาลำดับด้วย!"));
} else if ($_POST['jointype'] != "" && $_POST['jointable'] == "") {
    echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกตารางที่ต้องการ JOIN!"));
} else if ($_POST['jointype'] == "" && $_POST['jointable'] != "") {
    echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกตประเภทของการ JOIN!"));
} else {
    $type = $_POST['type'];
    $table = $_POST['table'];
    $data = $_POST['data'];
    $count = 1;
    if ($type == 1) {
        $sql = "SELECT ";
        if ($data != '*') {
            foreach ($data as $key) {
                $sql = $sql . $key;
                if ($count < count($data)) {
                    $sql = $sql . ", ";
                } else {
                    $sql = $sql . " ";
                }
                $count++;
            }
        } else {
            $sql = $sql . $data . " ";
        }
        $sql = $sql . "FROM $table ";
        if ($_POST['jointype'] != "" && $_POST['jointable'] != "") {
            $jointype = $_POST['jointype'];
            $jointable = explode(' ', $_POST['jointable']);
            $joindata = array();
            foreach ($jointable as $key) {
                $joindata[] = $key;
            }
            $sql = $sql . " " . $jointype . " " . $joindata[0] . " ON " . $table . "." . $joindata[1] . " = " . $joindata[0] . "." . $joindata[1];
        }
        $condition = $_POST['condition'];
        $andor = $_POST['andor'];
        if (!empty($condition['field'][0])) {
            $i = 0;
            $sql = $sql . " WHERE ";
            foreach ($condition['field'] as $key) {
                if (!empty($key)) {
                    $sql = $sql . $key . " " . $condition['condition'][$i] . " " . "'" . $condition['compare'][$i] . "'" . " ";
                    $i++;
                    if (!empty($condition['field'][$i])) {
                        $sql = $sql . $andor . " ";
                    }
                }
            }
        }
        if ($_POST['orderby'] != "" && $_POST['sort'] != "") {
            $orderby = $_POST['orderby'];
            $sort = $_POST['sort'];
            $sql = $sql . "ORDER BY " . $orderby . " " . $sort;
        }
    } else if ($type == 2) {
        $sql = "INSERT INTO $table (";
        $sql = $sql . (") VALUES (");
        $sql = $sql . (");");
    } else if ($type == 3) {
    
    } else {

    }
    $str = array();
    $sqlStr = explode(" ", $sql);
    foreach ($sqlStr as $key => $value) {
        $str[] = $value;
    }
    $question = "";
    for ($i = 0; $i < count($str); $i++) {
        if ($str[$i] == "SELECT") {
            $question = $question . "จงเรียกข้อมูล";
        } else if ($str[$i] == "INSERT") {
        
        } else if ($str[$i] == "INTO") {

        } else if ($str[$i] == "DELETE") {

        } else if ($str[$i] == "*") {
            $question = $question . "ทั้งหมด";
        } else if ($str[$i] == "FROM") {
            $question = $question . "จากตาราง " . $table . " ";
        } else if ($str[$i] == "INNER" || $str[$i] == "LEFT" || $str[$i] == "RIGHT" || $str[$i] == "FULL") {
            $question = $question . "โดยทำการ " . $str[$i] . " ";
        } else if ($str[$i] == "OUTER") {
            $question = $question . $str[$i] . " ";
        } else if ($str[$i] == "JOIN") {
            $question = $question . $str[$i] . " กับตาราง ";
        } else if ($str[$i] == "ON" || str_contains($str[$i], ".") || $str[$i] == "=" || $str[$i] == $table || $str[$i] == "''") {
            continue;
        } else if ($str[$i] == "WHERE") {
            $question = $question . " ที่ ";
        } else if ($str[$i] == ">") {
            $question = $question . "มากกว่า";
        } else if ($str[$i] == "<") {
            $question = $question . "น้อยกว่า ";
        } else if ($str[$i] == "=") {
            $question = $question . "เท่ากับ ";
        } else if ($str[$i] == "AND") {
            $question = $question . "และ ";
        } else if ($str[$i] == "OR") {
            $question = $question . "หรือ ";
        } else if ($str[$i] == "ORDER") {
            $question = $question . "จัดเรียง";
        } else if ($str[$i] == "BY") {
            $question = $question . "โดย ";
        } else if ($str[$i] == "ASC") {
            $question = $question . "จากน้อยไปมาก";
        } else if ($str[$i] == "DESC") {
            $question = $question . "จากมากไปน้อย";
        } else {
            $question = $question . " " . $str[$i] . " ";
        }
    }
    echo json_encode(array("status" => "success", "msg" => "ทำการสร้างโจทย์ปัญหาของคุณสำเร็จแล้ว", "question" => $question, "sql" => $sql));
}