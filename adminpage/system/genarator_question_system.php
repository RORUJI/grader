<?php
session_start();

include_once "../../dbconnect.php";

$type = $_POST['type'];
$table = $_POST['table'];
$condition = $_POST['condition'];
$andor = $_POST['andor'];
if (!empty($_POST['data'])) {
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
        if (!empty($condition['field'][0])) {
            $i = 0;
            $sql = $sql . "WHERE ";
            foreach ($condition['field'] as $key) {
                if (!empty($key)) {
                    $sql = $sql . $key . " " . $condition['condition'][$i] . " " . $condition['compare'][$i] . " ";
                    $i++;
                    if (!empty($condition['field'][$i])) {
                        $sql = $sql . $andor . " ";
                    }
                }
            }
        }
    } else if ($type == 2) {
        $sql = "INSERT INTO $table (";
        $sql = $sql . (") VALUES (");
        $sql = $sql . (");");
    }
    echo $sql;
}
?>