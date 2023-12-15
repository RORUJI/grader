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
        echo json_encode(array("status" => "success", "msg" => $sql));
    } else if ($type == 2) {
        $sql = "INSERT INTO $table (";
        $sql = $sql . (") VALUES (");
        $sql = $sql . (");");
    }
}
