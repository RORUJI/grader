<?php
session_start();
include_once "../../dbconnect.php";
$type = $_POST['type'];
$table = $_POST['table'];
if ($type == 1) {
    if (!isset($_POST['data'])) {
        echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกข้อมูลที่ต้องการ!"));
    } else {
        $data = $_POST['data'];
        $fieldName = [];
        $selectSQL = "SELECT";
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
            $selectSQL = $selectSQL . " *";
        }
        $selectSQL = $selectSQL . " FROM $table";
        if (isset($_POST['join-checkbox'])) {
            if ($_POST['jointype'] == "") {
                echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกประเภทของการ JOIN"));
            } else if ($_POST['jointable'] == "") {
                echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกตารางที่ต้องการ JOIN"));
            } else {
                $joinType = $_POST['jointype'];
                $joinTable = $_POST['jointable'];
                $joinData = explode(' ', $joinTable);
                $joinTableData = [];
                foreach ($joinData as $key => $value) {
                    $joinTableData[] = $value;
                }
                $selectSQL = $selectSQL . " $joinType $joinTableData[0] ON $table.$joinTableData[1] = $joinTableData[0].$joinTableData[1]";
                if (isset($_POST['condition-checkbox'])) {
                    $conditionData = $_POST['condition'];
                    if ($conditionData['field'][0] == "") {
                        echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกคอลัมส์สำหรับเงื่อนไข!"));
                    } else if ($conditionData['condition'][0] == "") {
                        echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกเงื่อนไข!"));
                    } else if ($conditionData['compare'][0] == "") {
                        echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูลเทียบ!"));
                    } else {
                        $conditionField = $conditionData['field'][0];
                        $condition = $conditionData['condition'][0];
                        $conditionCompare = $conditionData['compare'][0];
                        $selectSQL = $selectSQL . " WHERE " . $conditionField . " " . $condition . " " . "'$conditionCompare'";
                        if (isset($_POST['order-checkbox'])) {
                            $orderby = $_POST['orderby'];
                            $sort = $_POST['sort'];
                            if ($orderby == "") {
                                echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกคอลัมส์ที่ต้องการจัดเรียง!"));
                            } else if ($sort == "") {
                                echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกประเภทการจัดเรียง!"));
                            } else {
                                $selectSQL = $selectSQL . " ORDER BY " . $orderby . " " . $sort;
                                include_once "thai_translation.php";
                            }
                        } else {
                            include_once "thai_translation.php";
                        }
                    }
                } else if (isset($_POST['order-checkbox'])) {
                    $orderby = $_POST['orderby'];
                    $sort = $_POST['sort'];
                    if ($orderby == "") {
                        echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกคอลัมส์ที่ต้องการจัดเรียง!"));
                    } else if ($sort == "") {
                        echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกประเภทการจัดเรียง!"));
                    } else {
                        $selectSQL = $selectSQL . " ORDER BY " . $orderby . " " . $sort;
                        include_once "thai_translation.php";
                    }
                } else {
                    include_once "thai_translation.php";
                }
            }
        } else {
            if (isset($_POST['condition-checkbox'])) {
                $conditionData = $_POST['condition'];
                if ($conditionData['field'][0] == "") {
                    echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกคอลัมส์สำหรับเงื่อนไข!"));
                } else if ($conditionData['condition'][0] == "") {
                    echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกเงื่อนไข!"));
                } else if ($conditionData['compare'][0] == "") {
                    echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูลเทียบ!"));
                } else {
                    $conditionField = $conditionData['field'][0];
                    $condition = $conditionData['condition'][0];
                    $conditionCompare = $conditionData['compare'][0];
                    $selectSQL = $selectSQL . " WHERE " . $conditionField . " " . $condition . " " . "'$conditionCompare'";
                    if (isset($_POST['order-checkbox'])) {
                        $orderby = $_POST['orderby'];
                        $sort = $_POST['sort'];
                        if ($orderby == "") {
                            echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกคอลัมส์ที่ต้องการจัดเรียง!"));
                        } else if ($sort == "") {
                            echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกประเภทการจัดเรียง!"));
                        } else {
                            $selectSQL = $selectSQL . " " . "ORDER BY " . $orderby . " " . $sort;
                            echo json_encode(array("status" => "success", "msg" => $selectSQL));
                        }
                    } else {
                        include_once "thai_translation.php";
                    }
                }
            } else {
                if (isset($_POST['order-checkbox'])) {
                    $orderby = $_POST['orderby'];
                    $sort = $_POST['sort'];
                    if ($orderby == "") {
                        echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกคอลัมส์ที่ต้องการจัดเรียง!"));
                    } else if ($sort == "") {
                        echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกประเภทการจัดเรียง!"));
                    } else {
                        $selectSQL = $selectSQL . " ORDER BY " . $orderby . " " . $sort;
                        include_once "thai_translation.php";
                    }
                } else {
                    include_once "thai_translation.php";
                }
            }
        }
    }
} else if ($type == 2) {
    $fieldName = [];
    $fieldData = [];
    $insertSQL = "INSERT INTO $table(";
    $deleteSQL = "DELETE FROM $table WHERE ";
    $selectSQL = "SELECT * FROM $table WHERE ";
    if (isset($_POST['field-data'])) {
        if ($_POST['field-name'] != "*") {
            $fieldName = $_POST['field-name'];
            $fieldData = $_POST['field-data'];
            for ($i = 0; $i < count($fieldData); $i++) {
                if ($fieldData[$i] == "") {
                    echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูล $fieldName[$i]!"));
                    break;
                } else {
                    $insertSQL = $insertSQL . $fieldName[$i];
                    $deleteSQL = $deleteSQL . $fieldName[$i] . " = " . "'$fieldData[$i]'";
                    $selectSQL = $selectSQL . $fieldName[$i] . " = " . "'$fieldData[$i]'";
                    if ($i < count($fieldName) - 1) {
                        $insertSQL = $insertSQL . ", ";
                        $deleteSQL = $deleteSQL . " AND ";
                        $selectSQL = $selectSQL . " AND ";
                    } else {
                        $insertSQL = $insertSQL . ") VALUES(";
                        $deleteSQL = $deleteSQL . ";";
                        $selectSQL = $selectSQL . ";";
                        for ($j = 0; $j < count($fieldData); $j++) {
                            if ($fieldData[$j] == "") {
                                echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูล $fieldName[$i]!"));
                                break;
                            } else {
                                $insertSQL = $insertSQL . "'$fieldData[$j]'";
                                if ($j < count($fieldData) - 1) {
                                    $insertSQL = $insertSQL . ", ";
                                } else {
                                    $insertSQL = $insertSQL . ");";
                                    include_once "thai_translation.php";
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'grader' AND TABLE_NAME = '$table'";
            $result = $conn->query($sql);
            $fieldData = $_POST['field-data'];
            while ($row = $result->fetch_array()) {
                $fieldName[] = $row[0];
            }
            for ($i = 0; $i < count($fieldName); $i++) {
                if ($fieldData[$i] == "") {
                    echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูล $fieldName[$i]!"));
                    break;
                } else {
                    $insertSQL = $insertSQL . $fieldName[$i];
                    $deleteSQL = $deleteSQL . $fieldName[$i] . " = " . "'$fieldData[$i]'";
                    $selectSQL = $selectSQL . $fieldName[$i] . " = " . "'$fieldData[$i]'";
                    if ($i < count($fieldName) - 1) {
                        $insertSQL = $insertSQL . ", ";
                        $deleteSQL = $deleteSQL . " AND ";
                        $selectSQL = $selectSQL . " AND ";
                    } else {
                        $insertSQL = $insertSQL . ") VALUES(";
                        $deleteSQL = $deleteSQL . ";";
                        $selectSQL = $selectSQL . ";";
                        for ($j = 0; $j < count($fieldData); $j++) {
                            if ($fieldData[$j] == "") {
                                echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูล $fieldName[$i]!"));
                                break;
                            } else {
                                $insertSQL = $insertSQL . "'$fieldData[$j]'";
                                if ($j < count($fieldData) - 1) {
                                    $insertSQL = $insertSQL . ", ";
                                } else {
                                    $insertSQL = $insertSQL . ");";
                                    include_once "thai_translation.php";
                                }
                            }
                        }
                    }
                }
            }
        }
    } else {
        echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกข้อมูล!"));
    }
} else if ($type == 3) {
    $fieldName = [];
    $fieldData = [];
    $insertSQL = "INSERT INTO $table(";
    $deleteSQL = "DELETE FROM $table WHERE ";
    $selectSQL = "SELECT * FROM $table WHERE ";
    if (isset($_POST['field-data'])) {
        if ($_POST['field-name'] != "*") {
            $fieldName = $_POST['field-name'];
            $fieldData = $_POST['field-data'];
            for ($i = 0; $i < count($fieldData); $i++) {
                if ($fieldData[$i] == "") {
                    echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูล $fieldName[$i]!"));
                    break;
                } else {
                    $insertSQL = $insertSQL . $fieldName[$i];
                    $deleteSQL = $deleteSQL . $fieldName[$i] . " = " . "'$fieldData[$i]'";
                    $selectSQL = $selectSQL . $fieldName[$i] . " = " . "'$fieldData[$i]'";
                    if ($i < count($fieldName) - 1) {
                        $insertSQL = $insertSQL . ", ";
                        $deleteSQL = $deleteSQL . " AND ";
                        $selectSQL = $selectSQL . " AND ";
                    } else {
                        $insertSQL = $insertSQL . ") VALUES(";
                        $deleteSQL = $deleteSQL . ";";
                        $selectSQL = $selectSQL . ";";
                        for ($j = 0; $j < count($fieldData); $j++) {
                            if ($fieldData[$j] == "") {
                                echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูล $fieldName[$i]!"));
                                break;
                            } else {
                                $insertSQL = $insertSQL . "'$fieldData[$j]'";
                                if ($j < count($fieldData) - 1) {
                                    $insertSQL = $insertSQL . ", ";
                                } else {
                                    $insertSQL = $insertSQL . ");";
                                    include_once "thai_translation.php";
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'grader' AND TABLE_NAME = '$table'";
            $result = $conn->query($sql);
            $fieldData = $_POST['field-data'];
            while ($row = $result->fetch_array()) {
                $fieldName[] = $row[0];
            }
            for ($i = 0; $i < count($fieldName); $i++) {
                if ($fieldData[$i] == "") {
                    echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูล $fieldName[$i]!"));
                    break;
                } else {
                    $insertSQL = $insertSQL . $fieldName[$i];
                    $deleteSQL = $deleteSQL . $fieldName[$i] . " = " . "'$fieldData[$i]'";
                    $selectSQL = $selectSQL . $fieldName[$i] . " = " . "'$fieldData[$i]'";
                    if ($i < count($fieldName) - 1) {
                        $insertSQL = $insertSQL . ", ";
                        $deleteSQL = $deleteSQL . " AND ";
                        $selectSQL = $selectSQL . " AND ";
                    } else {
                        $insertSQL = $insertSQL . ") VALUES(";
                        $deleteSQL = $deleteSQL . ";";
                        $selectSQL = $selectSQL . ";";
                        for ($j = 0; $j < count($fieldData); $j++) {
                            if ($fieldData[$j] == "") {
                                echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูล $fieldName[$i]!"));
                                break;
                            } else {
                                $insertSQL = $insertSQL . "'$fieldData[$j]'";
                                if ($j < count($fieldData) - 1) {
                                    $insertSQL = $insertSQL . ", ";
                                } else {
                                    $insertSQL = $insertSQL . ");";
                                    include_once "thai_translation.php";
                                }
                            }
                        }
                    }
                }
            }
        }
    } else {
        echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกข้อมูล!"));
    }
} else {
    $updateSQL = "UPDATE $table SET ";
    $returnSQL = "UPDATE $table SET ";
    $selectSQL = "SELECT * FROM $table WHERE ";
    $beforeSQL = "SELECT * FROM $table WHERE ";
    $insertSQL = "INSERT INTO $table(";
    $fieldName = $_POST['field-name'];
    $beforeUpdate = $_POST['before-update-field'];
    $afterUpdate = $_POST['after-update-field'];
    if ($fieldName != "*") {
        for ($i = 0; $i < count($beforeUpdate); $i++) {
            if ($beforeUpdate[$i] == "") {
                echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูลก่อนแก้ไข!"));
                break;
            } else if ($afterUpdate[$i] == "") {
                echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูลหลังแก้ไข!"));
                break;
            } else {
                $updateSQL = $updateSQL . "$fieldName[$i] = '$afterUpdate[$i]'";
                $returnSQL = $returnSQL . "$fieldName[$i] = '$beforeUpdate[$i]'";
                $selectSQL = $selectSQL . "$fieldName[$i] = '$afterUpdate[$i]'";
                $beforeSQL = $beforeSQL . "$fieldName[$i] = '$beforeUpdate[$i]'";
                $insertSQL = $insertSQL . "$fieldName[$i]";
                if ($i < count($beforeUpdate) - 1) {
                    $updateSQL = $updateSQL . ", ";
                    $returnSQL = $returnSQL . ", ";
                    $selectSQL = $selectSQL . " AND ";
                    $beforeSQL = $beforeSQL . " AND ";
                    $insertSQL = $insertSQL . ", ";
                } else {
                    $updateSQL = $updateSQL . " WHERE ";
                    $returnSQL = $returnSQL . " WHERE ";
                    $selectSQL = $selectSQL . ";";
                    $beforeSQL = $beforeSQL . ";";
                    $insertSQL = $insertSQL . ") VALUES(";
                    for ($j = 0; $j < count($afterUpdate); $j++) {
                        $updateSQL = $updateSQL . $fieldName[$j] . " " . "'$beforeUpdate[$j]'";
                        $returnSQL = $returnSQL . $fieldName[$j] . " = " . "'$afterUpdate[$j]'";
                        $insertSQL = $insertSQL . "'$beforeUpdate[$j]'";
                        if ($j < count($afterUpdate) - 1) {
                            $updateSQL = $updateSQL . " AND ";
                            $returnSQL = $returnSQL . " AND ";
                            $insertSQL = $insertSQL . ", ";
                        } else {
                            $updateSQL = $updateSQL . ";";
                            $returnSQL = $returnSQL . ";";
                            $insertSQL = $insertSQL . ");";
                            include_once "thai_translation.php";
                        }
                    }
                }
            }
        }
    } else {
        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'grader' AND TABLE_NAME = '$table'";
        $result = $conn->query($sql);
        $fieldName = [];
        while ($row = $result->fetch_array()) {
            $fieldName[] = $row[0];
        }
        for ($i = 0; $i < count($beforeUpdate); $i++) {
            if ($beforeUpdate[$i] == "") {
                echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูลก่อนแก้ไข!"));
                break;
            } else if ($afterUpdate[$i] == "") {
                echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูลหลังแก้ไข!"));
                break;
            } else {
                $updateSQL = $updateSQL . "$fieldName[$i] = '$afterUpdate[$i]'";
                $returnSQL = $returnSQL . "$fieldName[$i] = '$beforeUpdate[$i]'";
                $selectSQL = $selectSQL . "$fieldName[$i] = '$afterUpdate[$i]'";
                $beforeSQL = $beforeSQL . "$beforeSQL[$i] = '$beforeUpdate[$i]'";
                $insertSQL = $insertSQL . "$fieldName[$i]";
                if ($i < count($beforeUpdate) - 1) {
                    $updateSQL = $updateSQL . ", ";
                    $returnSQL = $returnSQL . ", ";
                    $selectSQL = $selectSQL . " AND ";
                    $beforeSQL = $beforeSQL . " AND ";
                    $insertSQL = $insertSQL . ", ";
                } else {
                    $updateSQL = $updateSQL . " WHERE ";
                    $returnSQL = $returnSQL . " WHERE ";
                    $selectSQL = $selectSQL . ";";
                    $beforeSQL = $beforeSQL . ";";
                    $insertSQL = $insertSQL . ") VALUES(";
                    for ($j = 0; $j < count($afterUpdate); $j++) {
                        $updateSQL = $updateSQL . $fieldName[$j] . " = " . "'$beforeUpdate[$j]'";
                        $returnSQL = $returnSQL . $fieldName[$j] . " = " . "'$afterUpdate[$j]'";
                        $insertSQL = $insertSQL . "'$beforeUpdate[$j]'";
                        if ($j < count($afterUpdate) - 1) {
                            $updateSQL = $updateSQL . " AND ";
                            $returnSQL = $returnSQL . " AND ";
                            $insertSQL = $insertSQL . ", ";
                        } else {
                            $updateSQL = $updateSQL . ";";
                            $returnSQL = $returnSQL . ";";
                            $insertSQL = $insertSQL . ");";
                            include_once "thai_translation.php";
                        }
                    }
                }
            }
        }
    }
}