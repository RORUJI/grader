<?php
$sql_code = preg_replace("/\s+\(\s*/", "(", $sql_code);
$sql_code = preg_replace("/,\s+/", ", ", $sql_code);
$sql_code = preg_replace("/\s+\)/", ")", $sql_code);
$sql_code = preg_replace("/\s+VALUES\s*/", " VALUES", $sql_code);
$sql_code = preg_replace("/\s+/", " ", $sql_code);
$temporarily_table_name = '$usertable';
preg_match("/insert into (\w+)/i", $sql_code, $matches);
$table_name = isset($matches[1]) ? $matches[1] : null;

$result_code = "SELECT * FROM $temporarily_table_name WHERE ";
preg_match("/\(([^)]+)\)\s*VALUES\s*\(([^)]+)\)/i", $sql_code, $matches);

if (count($matches) < 3) {
    echo json_encode(array(
        "status" => "error",
        "msg" => "ข้อมูลไม่ถูกต้องหรือไม่ครบถ้วน"
    ));
    exit; // หยุดการทำงานเมื่อเกิดข้อผิดพลาด
}

$field_names = array_map('trim', explode(",", $matches[1]));
$field_data = array_map(function ($item) {
    return trim($item, " '\"");
}, explode(",", $matches[2]));

if (count($field_names) == count($field_data)) {
    for ($i = 0; $i < count($field_names); $i++) {
        $result_code .= $field_names[$i] . " = ";

        if (is_numeric($field_data[$i])) {
            $result_code .= $field_data[$i];
        } else {
            $result_code .= "'$field_data[$i]'";
        }
        if ($i < count($field_names) - 1) {
            $result_code .= " AND ";
        }
    }

    $create = "success";
    $create_temptable = "SELECT * FROM $table_name";
} else {
    $create = "error";
    echo json_encode(
        array(
            "status" => "error",
            "msg" => "เพิ่มข้อมูลลง Database ไม่สำเร็จแล้ว!"
        )
    );
    exit; // หยุดการทำงานที่นี่หากเกิดข้อผิดพลาด
}
