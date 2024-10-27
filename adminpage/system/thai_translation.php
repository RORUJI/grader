<?php
if ($type_id == 1) {
    $request = "";
    $request .= str_ireplace(
        [">", "<", "=", "AND", "OR", "LIKE", "'", '"', "WHERE", "*", "SELECT", "FROM"],
        ["มากกว่า", "น้อยกว่า", "เท่ากับ", "และ", "หรือ", "", "", "", "ที่มี", "ทั้งหมด", "จงเรียกข้อมูล", "จากตาราง"],
        $sql_code
    );
    $request = preg_replace(
        ["/([\w]+)%/", "/%([\w]+)/"], // ตรวจสอบ % ตามด้วยตัวอักษรและตัวอักษรตามด้วย %
        ["ขึ้นต้นด้วย $1", "ลงท้ายด้วย $1"], // แทนที่
        $request
    );
} else if ($type_id == 2) {
    $request = "จงเพิ่มข้อมูล ";
    for ($i = 0; $i < count($field_names); $i++) {
        $request = $request . "$field_names[$i] = $field_data[$i]";
        if ($i < count($field_names) - 1) {
            $request = $request . ", ";
        } else {
            $request = $request . " ";
        }
    }
    $request .= "ลงในตาราง $table_name";
} else if ($type_id == 3) {
    $request = "จงลบข้อมูลที่มี ";
    $request .= str_ireplace(
        [">", "<", "=", "AND", "OR", "LIKE", "'", '"'],
        ["มากกว่า", "น้อยกว่า", "เท่ากับ", "และ", "หรือ", "", ""],
        $where_clause
    );
    $request = preg_replace(
        ["/([\w]+)%/", "/%([\w]+)/"], // ตรวจสอบ % ตามด้วยตัวอักษรและตัวอักษรตามด้วย %
        ["ขึ้นต้นด้วย $1", "ลงท้ายด้วย $1"], // แทนที่
        $request
    );
} else {
    $request = "จงแก้ไขข้อมูลในตาราง $table_name ที่มี ";
    $request .= str_ireplace(
        [">", "<", "=", "AND", "OR", "LIKE", "'", '"', ","],
        ["มากกว่า", "น้อยกว่า", "เท่ากับ", "และ", "หรือ", "", "", ""],
        $set_clause
    );
    $request .= " ให้เป็น ";
    $request .= str_ireplace(
        [">", "<", "=", "AND", "OR", "LIKE", "'", '"'],
        ["มากกว่า", "น้อยกว่า", "เท่ากับ", "และ", "หรือ", "", ""],
        $where_clause
    );
}

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
?>