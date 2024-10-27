<?php
$temporarily_table_name = '$usertable';
preg_match("/update (\w+)/i", $sql_code, $matches);
$table_name = isset($matches[1]) ? $matches[1] : null;

if ($table_name) {
    $result_code = "SELECT * FROM $temporarily_table_name WHERE ";

    preg_match("/SET\s+(.*?)(?:\s+WHERE|$)/i", $sql_code, $matches);
    if (isset($matches[1])) {
        $set_clause = trim($matches[1], ";");
    } else {
        echo json_encode(array(
            "status" => "error",
            "msg" => "ไม่พบเงื่อนไขหลัง SET"
        ));
        exit;
    }

    preg_match("/WHERE\s+(.*)/i", $sql_code, $matches);
    if (isset($matches[1])) {
        $where_clause = trim($matches[1], ";");
    } else {
        echo json_encode(array(
            "status" => "error",
            "msg" => "ไม่พบเงื่อนไขหลัง WHERE"
        ));
        exit;
    }

    $result_code .= $set_clause;
    $result_code = str_replace(",", " AND ", $result_code);
    $create = "success";
    $create_temptable = "SELECT * FROM $table_name";
} else {
    echo json_encode(array(
        "status" => "error",
        "msg" => "ไม่พบชื่อของตารางในคำสั่ง UPDATE"
    ));
    exit;
}
?>