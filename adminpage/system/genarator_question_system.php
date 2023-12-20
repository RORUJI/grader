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
    if ($type == 1) {
        $selectSQL = "SELECT";
        $fieldName = array();

        if ($data != "*") {
            foreach ($data as $key => $value) {
                $fieldName[] = $value;
            }

            for ($i = 0; $i < count($fieldName); $i++) {
                if ($i < count($fieldName) - 1) {
                    $selectSQL = "$selectSQL $fieldName[$i],";
                } else {
                    $selectSQL = "$selectSQL $fieldName[$i]";
                }
            }
        } else {
            $selectSQL = "$selectSQL *";
        }
        $selectSQL = "$selectSQL FROM $table";

        if (isset($_POST['jointype']) && $_POST['jointable']) {
            if ($_POST['jointype'] != "" || $_POST['jointable'] != "") {
                $joinType = $_POST['jointype'];
                $joinTable = $_POST['jointable'];
                $joinData = explode(' ', $joinTable);
                $joinTableData = array();
                if ($joinType != "" && $joinTable != "") {
                    foreach ($joinData as $key => $value) {
                        $joinTableData[] = $value;
                    }
                    $selectSQL = "$selectSQL $joinType $joinTableData[0] ON $table.$joinTableData[1] = $joinTableData[0].$joinTableData[1]";
                } else if ($joinType != "" && $joinTable == "") {
                    echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกตารางที่ต้องการ JOIN!"));
                } else {
                    echo json_encode(array("status" => "error", "msg" => "กรุณาประเภทที่ต้องการ JOIN!"));
                }
            }
        }

        if (isset($_POST['condition'])) {
            $selectSQL = "$selectSQL WHERE";
            $condition = $_POST['condition'];
            $whereField = array();
            $whereCondition = array();
            $whereCompare = array();

            foreach ($condition['field'] as $key => $value) {
                $whereField[] = $value;
            }
            foreach ($condition['condition'] as $key => $value) {
                $whereCondition[] = $value;
            }
            foreach ($condition['compare'] as $key => $value) {
                $whereCompare[] = $value;
            }

            if ($_POST['conditionLink'] != "") {
                $conditionLink = $_POST['conditionLink'];
            } else {
                $conditionLink = "";
            }

            for ($i = 0; $i < count($whereField); $i++) {
                $selectSQL = "$selectSQL $whereField[$i] $whereCondition[$i] '$whereCompare[$i]'";

                if ($i < count($whereField) - 1) {
                    $selectSQL = "$selectSQL $conditionLink";
                }
            }
        } else {

        }

        if (isset($_POST['orderby']) != "" || isset($_POST['sort']) != "") {
            $orderby = $_POST['orderby'];
            $sort = $_POST['sort'];

            if ($orderby != "" && $sort != "") {
                $selectSQL = "$selectSQL ORDER BY $orderby $sort";
            } else if ($orderby != "" && $sort == "") {
                $orderby = $_POST['orderby'];
                $selectSQL = "$selectSQL ORDER BY $orderby";
            } else {
                echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกคอลัมส์ที่ต้องการให้เรียง!"));
            }
        }

    } else if ($type == 2) {
        $field = array();
        $data = array();
        $data = $_POST['data-field'];
        $insertSQL = "INSERT INTO $table (";
        $selectSQL = "SELECT * FROM $table WHERE ";
        $deleteSQL = "DELETE FROM $table WHERE ";
        if ($_POST['data'] != '*') {
            $field = $_POST['data'];
        } else {
            $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'grader' AND TABLE_NAME = '$table'";
            $result = $conn->query($sql);
            while ($row = $result->fetch_array()) {
                $field[] = $row[0];
            }
        }

        for ($i = 0; $i < count($field); $i++) {
            $insertSQL = $insertSQL . $field[$i];
            if ($i < count($field) - 1) {
                $insertSQL = "$insertSQL, ";
            } else {
                continue;
            }
        }

        $insertSQL = $insertSQL . (") VALUES (");
        for ($i = 0; $i < count($data); $i++) {
            $insertSQL = "$insertSQL '$data[$i]'";
            $selectSQL = "$selectSQL $field[$i] = '$data[$i]'";
            $deleteSQL = "$deleteSQL $field[$i] = '$data[$i]'";
            ;
            if ($i < count($data) - 1) {
                $insertSQL = "$insertSQL, ";
                $selectSQL = "$selectSQL AND ";
                $deleteSQL = "$deleteSQL AND ";
            } else {
                continue;
            }
        }
        $insertSQL = $insertSQL . (");");
    } else if ($type == 3) {
        $deleteSQL = "DELETE FROM $table WHERE";
        $selectSQL = "SELECT * FROM $table WHERE ";
        $insertSQL = "INSERT INTO $table (";
        $field = array();
        $data = $_POST['data-field'];

        if ($_POST['data'] != '*') {
            $field = $_POST['data'];
        } else {
            $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'grader' AND TABLE_NAME = '$table'";
            $result = $conn->query($sql);
            while ($row = $result->fetch_array()) {
                $field[] = $row[0];
            }
        }

        for ($i = 0; $i < count($field); $i++) {
            $deleteSQL = "$deleteSQL $field[$i] = '$data[$i]'";
            $selectSQL = "$selectSQL $field[$i] = '$data[$i]'";
            $insertSQL = $insertSQL . $field[$i];
            if ($i < count($field) - 1) {
                $deleteSQL = "$deleteSQL AND ";
                $selectSQL = "$selectSQL AND ";
                $insertSQL = "$insertSQL, ";
            } else {
                $deleteSQL = "$deleteSQL;";
                $selectSQL = "$selectSQL;";
                $insertSQL = $insertSQL . ")";
            }
        }
        $insertSQL = "$insertSQL VALUES (";
        for ($i = 0; $i < count($data); $i++) {
            $insertSQL = $insertSQL . "'$data[$i]'";
            if ($i < count($data) - 1) {
                $insertSQL = "$insertSQL, ";
            } else {
                $insertSQL = $insertSQL . ");";
            }
        }
    } else {
        $checkEcho = "";

        if ($_POST['data'] != '*') {
            $field = $_POST['data'];
        } else {
            $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'grader' AND TABLE_NAME = '$table'";
            $result = $conn->query($sql);
            while ($row = $result->fetch_array()) {
                $field[] = $row[0];
            }
        }

        $beforeUpdateData = $_POST['before-update-field'];
        $afterUpdateData = $_POST['after-update-field'];
        $beforeData = array();
        $afterData = array();

        foreach ($beforeUpdateData as $key => $value) {
            if ($beforeUpdateData[$key] == "") {
                $checkEcho = "beforeUpdateEmpty";
                break;
            } else {
                $beforeData[] = $value;
            }
        }

        if ($checkEcho == "beforeUpdateEmpty") {
            echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูลก่อนแก้ไข!"));
        } else {
            foreach ($afterUpdateData as $key => $value) {
                if ($afterUpdateData[$key] == "") {
                    $checkEcho = "afterUpdateEmpty";
                    break;
                } else {
                    $afterData[] = $value;
                }
            }
            if ($checkEcho == "afterUpdateEmpty") {
                echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูลหลังแก้ไข!"));
            } else {
                $updateSQL = "UPDATE $table SET";
                $selectSQL = "SELECT * FROM $table WHERE";
                $insertSQL = "INSERT INTO $table (";
                $deleteSQL = "DELETE FROM $table WHERE";

                for ($i = 0; $i < count($field); $i++) {
                    $updateSQL = "$updateSQL $field[$i] = '$afterData[$i]'";
                    $selectSQL = "$selectSQL $field[$i] = '$beforeData[$i]'";
                    $insertSQL = $insertSQL . $field[$i];
                    $deleteSQL = "$deleteSQL $field[$i] = '$afterData[$i]'";

                    if ($i < count($field) - 1) {
                        $updateSQL = "$updateSQL, ";
                        $selectSQL = "$selectSQL AND ";
                        $insertSQL = "$insertSQL, ";
                        $deleteSQL = "$deleteSQL AND";
                    } else {
                        $insertSQL = "$insertSQL)";
                        continue;
                    }
                }

                $updateSQL = "$updateSQL WHERE";
                $insertSQL = "$insertSQL VALUES (";

                for ($i = 0; $i < count($field); $i++) {
                    $updateSQL = "$updateSQL $field[$i] = '$beforeData[$i]'";
                    $insertSQL = $insertSQL . $afterData[$i];

                    if ($i < count($field) - 1) {
                        $updateSQL = "$updateSQL AND";
                        $insertSQL = "$insertSQL, ";
                    } else {
                        $insertSQL = "$insertSQL);";
                        continue;
                    }
                }

                $question = "จงแก้ไขข้อมูลที่";

                for ($i = 0; $i < count($beforeData); $i++) {
                    $question = "$question $field[$i] เป็น $beforeData[$i]";

                    if ($i < count($beforeData) - 1) {
                        $question = "$question และ";
                    } else {
                        continue;
                    }
                }

                $question = "$question ให้";

                for ($i = 0; $i < count($afterData); $i++) {
                    $question = "$question $field[$i] เป็น $afterData[$i]";

                    if ($i < count($beforeData) - 1) {
                        $question = "$question และ";
                    } else {
                        continue;
                    }
                }

                echo json_encode(array("status" => "success", "msg" => "ทำการสร้างโจทย์ปัญหาของคุณสำเร็จแล้ว",
                    "question" => $question, "selectSQL" => $selectSQL, "insertSQL" => $insertSQL,
                    "deleteSQL" => $deleteSQL, "type" => $type));
            }
        }
    }
    $question = "";
    if ($type == 1) {
        $selectStr = array();
        $selectSQLStr = explode(" ", $selectSQL);
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
        // echo "$question <br/> $selectSQL";
        echo json_encode(array("status" => "success", "msg" => "ทำการสร้างโจทย์ปัญหาของคุณสำเร็จแล้ว",
            "question" => $question, "selectSQL" => $selectSQL, "type" => $type));
    } else if ($type == 2) {
        $fieldNameStr = array();
        $fieldDataStr = array();
        $question = "จงเพิ่มข้อมูล ";
        foreach ($field as $key => $value) {
            $fieldNameStr[] = $value;
        }

        foreach ($data as $key => $value) {
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
        echo json_encode(array("status" => "success", "msg" => "ทำการสร้างโจทย์ปัญหาของคุณสำเร็จแล้ว",
            "question" => $question, "selectSQL" => $selectSQL, "insertSQL" => $insertSQL,
            "deleteSQL" => $deleteSQL, "type" => $type));
    } else if ($type == 3) {
        $fieldNameStr = array();
        $fieldDataStr = array();
        $question = "จงลบข้อมูลที่มี";
        foreach ($field as $key => $value) {
            $fieldNameStr[] = $value;
        }

        foreach ($data as $key => $value) {
            $fieldDataStr[] = $value;
        }

        for ($i = 0; $i < count($fieldNameStr); $i++) {
            $question = "$question $fieldNameStr[$i] = '$fieldDataStr[$i]'";

            if ($i < count($fieldNameStr) - 1) {
                $question = "$question, ";
            }
        }
        $question = "$question ออกจากตาราง $table";

        echo json_encode(array("status" => "success", "msg" => "ทำการสร้างโจทย์ปัญหาของคุณสำเร็จแล้ว",
            "question" => $question, "selectSQL" => $selectSQL, "insertSQL" => $insertSQL,
            "deleteSQL" => $deleteSQL, "type" => $type));
    } else {

    }
}