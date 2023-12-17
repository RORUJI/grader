<?php
session_start();

include_once "../../dbconnect.php";

if (!isset($_POST['type'])) {
    echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกประเภทโจทย์!"));
} else if (!isset($_POST['table'])) {
    echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกตารางข้อมูล!"));
} else if (!isset($_POST['data'])) {
    echo json_encode(array("status" => "error", "msg" => "กรุณายืนยันโจทย์และตารางข้อมูลหรือเลือกข้อมูลที่ต้องการ!"));
} else {
    $type = $_POST['type'];
    $table = $_POST['table'];
    $data = $_POST['data'];
    $count = 1;
    if ($type == 1) {
        if ($_POST['orderby'] != "" && $_POST['sort'] == "") {
            echo json_encode(array("status" => "error", "msg" => "กรุณาลำดับด้วย!"));
        } else if ($_POST['jointype'] != "" && $_POST['jointable'] == "") {
            echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกตารางที่ต้องการ JOIN!"));
        } else if ($_POST['jointype'] == "" && $_POST['jointable'] != "") {
            echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกตประเภทของการ JOIN!"));
        } else
            $selectSQL = "SELECT ";
        if ($data != '*') {
            foreach ($data as $key) {
                $selectSQL = $selectSQL . $key;
                if ($count < count($data)) {
                    $selectSQL = $selectSQL . ", ";
                } else {
                    $selectSQL = $selectSQL . " ";
                }
                $count++;
            }
        } else {
            $selectSQL = $selectSQL . $data . " ";
        }
        $selectSQL = $selectSQL . "FROM $table ";
        if ($_POST['jointype'] != "" && $_POST['jointable'] != "") {
            $jointype = $_POST['jointype'];
            $jointable = explode(' ', $_POST['jointable']);
            $joindata = array();
            foreach ($jointable as $key) {
                $joindata[] = $key;
            }
            $selectSQL = $selectSQL . " " . $jointype . " " . $joindata[0] . " ON " . $table . "." . $joindata[1] . " = " . $joindata[0] . "." . $joindata[1];
        }
        $condition = $_POST['condition'];
        $andor = $_POST['andor'];
        if (!empty($condition['field'][0])) {
            $i = 0;
            $selectSQL = $selectSQL . " WHERE ";
            foreach ($condition['field'] as $key) {
                if (!empty($key)) {
                    $selectSQL = $selectSQL . $key . " " . $condition['condition'][$i] . " " . "'" . $condition['compare'][$i] . "'" . " ";
                    $i++;
                    if (!empty($condition['field'][$i])) {
                        $selectSQL = $selectSQL . $andor . " ";
                    }
                }
            }
        }
        if ($_POST['orderby'] != "" && $_POST['sort'] != "") {
            $orderby = $_POST['orderby'];
            $sort = $_POST['sort'];
            $selectSQL = $selectSQL . "ORDER BY " . $orderby . " " . $sort;
        }
    } else if ($type == 2) {
        $field = array();
        if ($_POST['data'] != '*') {
            $field = $_POST['data'];
        } else {
            $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'grader' AND TABLE_NAME = '$table'";
            $result = $conn->query($sql);
            while ($row = $result->fetch_array()) {
                $field[] = $row[0];
            }
        }

        $insertSQL = "INSERT INTO $table (";
        for ($i = 0; $i < count($field); $i++) {
            $insertSQL = $insertSQL . $field[$i];
            if ($i < count($field) - 1) {
                $insertSQL = $insertSQL . ", ";
            } else {
                continue;
            }
        }
        $insertSQL = $insertSQL . (") VALUES (");
        $insertSQL = $insertSQL . (");");
        echo $insertSQL;
    } else if ($type == 3) {

    } else {

    }
    if ($type == 1) {
        $selectStr = array();
        $selectSQLStr = explode(" ", $selectSQL);
        foreach ($selectSQLStr as $key => $value) {
            $selectStr[] = $value;
        }
        $question = "";
        for ($i = 0; $i < count($selectStr); $i++) {
            if ($selectStr[$i] == "SELECT") {
                $question = $question . "จงเรียกข้อมูล";
            } else if ($selectStr[$i] == "INSERT") {

            } else if ($selectStr[$i] == "INTO") {

            } else if ($selectStr[$i] == "DELETE") {

            } else if ($selectStr[$i] == "*") {
                $question = $question . "ทั้งหมด";
            } else if ($selectStr[$i] == "FROM") {
                $question = $question . "จากตาราง " . $table . " ";
            } else if ($selectStr[$i] == "INNER" || $selectStr[$i] == "LEFT" || $selectStr[$i] == "RIGHT" || $selectStr[$i] == "FULL") {
                $question = $question . "โดยทำการ " . $selectStr[$i] . " ";
            } else if ($selectStr[$i] == "OUTER") {
                $question = $question . $selectStr[$i] . " ";
            } else if ($selectStr[$i] == "JOIN") {
                $question = $question . $selectStr[$i] . " กับตาราง ";
            } else if ($selectStr[$i] == "ON" || str_contains($selectStr[$i], ".") || $selectStr[$i] == "=" || $selectStr[$i] == $table || $selectStr[$i] == "''") {
                continue;
            } else if ($selectStr[$i] == "WHERE") {
                $question = $question . " ที่ ";
            } else if ($selectStr[$i] == ">") {
                $question = $question . "มากกว่า";
            } else if ($selectStr[$i] == "<") {
                $question = $question . "น้อยกว่า ";
            } else if ($selectStr[$i] == "=") {
                $question = $question . "เท่ากับ ";
            } else if ($selectStr[$i] == "AND") {
                $question = $question . "และ ";
            } else if ($selectStr[$i] == "OR") {
                $question = $question . "หรือ ";
            } else if ($selectStr[$i] == "ORDER") {
                $question = $question . "จัดเรียง";
            } else if ($selectStr[$i] == "BY") {
                $question = $question . "โดย ";
            } else if ($selectStr[$i] == "ASC") {
                $question = $question . "จากน้อยไปมาก";
            } else if ($selectStr[$i] == "DESC") {
                $question = $question . "จากมากไปน้อย";
            } else {
                $question = $question . " " . $selectStr[$i] . " ";
            }
        }
        echo json_encode(array("status" => "success", "msg" => "ทำการสร้างโจทย์ปัญหาของคุณสำเร็จแล้ว", "question" => $question, "selectSQL" => $selectSQL, "type" => $type));
    }
}