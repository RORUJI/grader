<?php
$question = "";
if ($type == 1) {
    $selectStr = array();
    $selectSQLStr = explode(" ", $answercode);
    foreach ($selectSQLStr as $key => $value) {
        $selectStr[] = $value;
    }
    for ($i = 0; $i < count($selectStr); $i++) {
        if ($selectStr[$i] == "SELECT") {
            $question = $question . "จงเรียกข้อมูล";
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
        } else if ($selectStr[$i] == "ON" || strpos($selectStr[$i], ".") !== false || $selectStr[$i] == "=" || $selectStr[$i] == $table || $selectStr[$i] == "''") {
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
    echo json_encode(
        array(
            "status" => "success",
            "msg" => "ทำการสร้างโจทย์ปัญหาของคุณสำเร็จแล้ว",
            "question" => $question,
            "answercode" => $answercode,
            "resultcode" => $resultcode,
            "temptablecode" => $temptablecode,
            "type" => $type
        )
    );
} else if ($type == 2) {
    $fieldNameStr = array();
    $fieldDataStr = array();
    $question = "จงเพิ่มข้อมูล ";
    foreach ($fieldName as $key => $value) {
        $fieldNameStr[] = $value;
    }
    foreach ($fieldData as $key => $value) {
        $fieldDataStr[] = $value;
    }
    for ($i = 0; $i < count($fieldNameStr); $i++) {
        $question = $question . "$fieldNameStr[$i] = $fieldDataStr[$i]";
        if ($i < count($fieldNameStr) - 1) {
            $question = $question . ", ";
        } else {
            $question = $question . " ";
        }
    }
    $question = $question . "ลงในตาราง $table";
    $temptablecode = "SELECT * FROM $table";
    echo json_encode(
        array(
            "status" => "success",
            "msg" => "ทำการสร้างโจทย์ปัญหาของคุณสำเร็จแล้ว",
            "question" => $question,
            "answercode" => $answercode,
            "resultcode" => $resultcode,
            "temptablecode" => $temptablecode,
            "type" => $type
        )
    );
} else if ($type == 3) {
    $fieldNameStr = array();
    $fieldDataStr = array();
    $question = "จงลบข้อมูลที่มี ";
    foreach ($fieldName as $key => $value) {
        $fieldNameStr[] = $value;
    }
    foreach ($fieldData as $key => $value) {
        $fieldDataStr[] = $value;
    }
    for ($i = 0; $i < count($fieldNameStr); $i++) {
        $question = $question . "$fieldNameStr[$i] = $fieldDataStr[$i]";
        if ($i < count($fieldNameStr) - 1) {
            $question = $question . ", ";
        } else {
            $question = $question . " ";
        }
    }
    $question = "$question ออกจากตาราง $table";
    $temptablecode = "SELECT * FROM $table";
    echo json_encode(
        array(
            "status" => "success",
            "msg" => "ทำการสร้างโจทย์ปัญหาของคุณสำเร็จแล้ว",
            "question" => $question,
            "answercode" => $answercode,
            "resultcode" => $resultcode,
            "temptablecode" => $temptablecode,
            "type" => $type
        )
    );
} else {
    $question = "จงแก้ไขข้อมูลในตาราง $table ที่มี ";
    for ($i = 0; $i < count($fieldName); $i++) {
        $question = $question . $fieldName[$i] . " เท่ากับ $beforeUpdate[$i] ";
        if ($i < count($fieldName) - 1) {
            $question = $question . "และ ";
        } else {
            $question = $question . "ให้เป็น ";
            for ($j = 0; $j < count($afterUpdate); $j++) {
                $question = $question . $fieldName[$j] . " เท่ากับ $afterUpdate[$j] ";
                if ($j < count($afterUpdate) - 1) {
                    $question = $question . "และ ";
                } else {
                    continue;
                }
            }
        }
    }
    $temptablecode = "SELECT * FROM $table";
    echo json_encode(
        array(
            "status" => "success",
            "msg" => "ทำการสร้างโจทย์ปัญหาของคุณสำเร็จแล้ว",
            "question" => $question,
            "answercode" => $answercode,
            "resultcode" => $resultcode,
            "temptablecode" => $temptablecode,
            "type" => $type
        )
    );
}
?>