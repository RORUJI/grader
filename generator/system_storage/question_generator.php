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
        $answercode = "SELECT";
        $resultcode = "SELECT";
        $temptablecode = "SELECT";
        if ($data != "*") {
            foreach ($data as $key => $value) {
                $fieldName[] = $value;
            }
            for ($i = 0; $i < count($fieldName); $i++) {
                if ($i < count($fieldName) - 1) {
                    $temptablecode = "$temptablecode $fieldName[$i],";
                    $answercode = "$answercode $fieldName[$i],";
                    $resultcode = "$resultcode $fieldName[$i],";
                } else {
                    $temptablecode = "$temptablecode $fieldName[$i]";
                    $answercode = "$answercode $fieldName[$i]";
                    $resultcode = "$resultcode $fieldName[$i]";
                }
            }
        } else {
            $answercode = $answercode . " *";
            $resultcode = $resultcode . " *";
            $temptablecode = $temptablecode . " *";
        }
        $answercode = $answercode . " FROM $table";
        $resultcode = $resultcode . " FROM $table";
        $temptablecode = $temptablecode . " FROM $table";
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
                $answercode = $answercode . " $joinType $joinTableData[0] ON $table.$joinTableData[1] = $joinTableData[0].$joinTableData[1]";
                $resultcode = $resultcode . " $joinType $joinTableData[0] ON $table.$joinTableData[1] = $joinTableData[0].$joinTableData[1]";
                $temptablecode = $temptablecode . " $joinType $joinTableData[0] ON $table.$joinTableData[1] = $joinTableData[0].$joinTableData[1]";
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
                        $answercode = $answercode . " WHERE " . $conditionField . " " . $condition . " " . "'$conditionCompare'";
                        $resultcode = $resultcode . " WHERE " . $conditionField . " " . $condition . " " . "'$conditionCompare'";
                        $temptablecode = $temptablecode . " WHERE " . $conditionField . " " . $condition . " " . "'$conditionCompare'";
                        if (isset($_POST['order-checkbox'])) {
                            $orderby = $_POST['orderby'];
                            $sort = $_POST['sort'];
                            if ($orderby == "") {
                                echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกคอลัมส์ที่ต้องการจัดเรียง!"));
                            } else if ($sort == "") {
                                echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกประเภทการจัดเรียง!"));
                            } else {
                                $answercode = $answercode . " ORDER BY " . $orderby . " " . $sort;
                                $resultcode = $resultcode . " ORDER BY " . $orderby . " " . $sort;
                                $temptablecode = $temptablecode . " ORDER BY " . $orderby . " " . $sort;
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
                        $answercode = $answercode . " ORDER BY " . $orderby . " " . $sort;
                        $resultcode = $resultcode . " ORDER BY " . $orderby . " " . $sort;
                        $temptablecode = $temptablecode . " ORDER BY " . $orderby . " " . $sort;
                        include_once "thai_translation.php";
                    }
                } else {
                    include_once "thai_translation.php";
                }
            }
        } else {
            if (isset($_POST['condition-checkbox'])) {
                $answercode = $answercode . " WHERE ";
                $resultcode = $resultcode . " WHERE ";
                $temptablecode = $temptablecode . " WHERE ";
                $clauseCount = $_POST['clauseCount'];
                if (empty($clauseCount)) {
                    echo json_encode(array("status" => "error", "msg" => "กรุณาใส่จำนวนเงื่อนไข!"));
                } else {
                    $msg = "";
                    $columnNameArray = $_POST['columnName'];
                    $operatorArray = $_POST['operator'];
                    $valueArray = $_POST['value'];

                    if ($clauseCount > 1) {
                        $logicalOperatorArray = $_POST['logicalOperator'];

                        for ($i = 0; $i < $clauseCount; $i++) {
                            $count = $i + 1;

                            if ($columnNameArray[$i] == "") {
                                echo json_encode(array(
                                    "status" => "error",
                                    "msg" => "กรุณาเลือกคอลัมส์สำหรับเงื่อนไขที่ $count!"
                                ));
                                break;
                            } else if ($operatorArray[$i] == "") {
                                echo json_encode(array(
                                    "status" => "error",
                                    "msg" => "กรุณาเลือกเงื่อนไขที่ $count!"
                                ));
                                break;
                            } else if ($valueArray[$i] == "") {
                                echo json_encode(array(
                                    "status" => "error",
                                    "msg" => "กรุณากรอกข้อมูลเทียบที่ $count!"
                                ));
                                break;
                            } else if ($i < $clauseCount - 1 && $logicalOperatorArray[$i] == "") {
                                echo json_encode(array(
                                    "status" => "error",
                                    "msg" => "กรุณาใส่ Logical Operator ที่ $count!"
                                ));
                                break;
                            } else {
                                if ($i < $clauseCount - 1) {
                                    $answercode = $answercode . $columnNameArray[$i] . " " . $operatorArray[$i] . " " . "'$valueArray[$i]'" . " " . $logicalOperatorArray[$i] . " ";
                                    $resultcode = $resultcode . $columnNameArray[$i] . " " . $operatorArray[$i] . " " . "'$valueArray[$i]'" . " " . $logicalOperatorArray[$i] . " ";
                                    $temptablecode = $temptablecode . $columnNameArray[$i] . " " . $operatorArray[$i] . " " . "'$valueArray[$i]'" . " " . $logicalOperatorArray[$i] . " ";
                                } else {
                                    $answercode = $answercode . $columnNameArray[$i] . " " . $operatorArray[$i] . " " . "'$valueArray[$i]'";
                                    $resultcode = $resultcode . $columnNameArray[$i] . " " . $operatorArray[$i] . " " . "'$valueArray[$i]'";
                                    $temptablecode = $temptablecode . $columnNameArray[$i] . " " . $operatorArray[$i] . " " . "'$valueArray[$i]'";
                                }
                                continue;
                            }
                        }
                        if (isset($_POST['order-checkbox'])) {
                            $orderby = $_POST['orderby'];
                            $sort = $_POST['sort'];
                            if ($orderby == "") {
                                echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกคอลัมส์ที่ต้องการจัดเรียง!"));
                            } else if ($sort == "") {
                                echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกประเภทการจัดเรียง!"));
                            } else {
                                $answercode = $answercode . " " . "ORDER BY " . $orderby . " " . $sort;
                                $resultcode = $resultcode . " " . "ORDER BY " . $orderby . " " . $sort;
                                $temptablecode = $temptablecode . " " . "ORDER BY " . $orderby . " " . $sort;
                                echo json_encode(array("status" => "success", "msg" => $temptablecode));
                            }
                        } else {
                            include_once "thai_translation.php";
                        }
                    } else {
                        if ($columnNameArray[0] == "") {
                            echo json_encode(array(
                                "status" => "error",
                                "msg" => "กรุณาเลือกคอลัมส์สำหรับเงื่อนไข!"
                            ));
                        } else if ($operatorArray[0] == "") {
                            echo json_encode(array(
                                "status" => "error",
                                "msg" => "กรุณาเลือกเงื่อนไข!"
                            ));
                        } else if ($valueArray[0] == "") {
                            echo json_encode(array(
                                "status" => "error",
                                "msg" => "กรุณากรอกข้อมูลเทียบ!"
                            ));
                        } else {
                            $answercode = $answercode . $columnNameArray[0] . " " . $operatorArray[0] . " " . "'$valueArray[0]'";
                            $resultcode = $resultcode . $columnNameArray[0] . " " . $operatorArray[0] . " " . "'$valueArray[0]'";
                            $temptablecode = $temptablecode . $columnNameArray[0] . " " . $operatorArray[0] . " " . "'$valueArray[0]'";

                            if (isset($_POST['order-checkbox'])) {
                                $orderby = $_POST['orderby'];
                                $sort = $_POST['sort'];
                                if ($orderby == "") {
                                    echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกคอลัมส์ที่ต้องการจัดเรียง!"));
                                } else if ($sort == "") {
                                    echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกประเภทการจัดเรียง!"));
                                } else {
                                    $answercode = $answercode . " " . "ORDER BY " . $orderby . " " . $sort;
                                    $resultcode = $resultcode . " " . "ORDER BY " . $orderby . " " . $sort;
                                    $temptablecode = $temptablecode . " " . "ORDER BY " . $orderby . " " . $sort;
                                    echo json_encode(array("status" => "success", "msg" => $temptablecode));
                                }
                            } else {
                                include_once "thai_translation.php";
                            }
                        }
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
                        $answercode = $answercode . " ORDER BY " . $orderby . " " . $sort;
                        $resultcode = $resultcode . " ORDER BY " . $orderby . " " . $sort;
                        $temptablecode = $temptablecode . " ORDER BY " . $orderby . " " . $sort;
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
    $answercode = "INSERT INTO $table(";
    $resultcode = "SELECT * FROM \$usertable WHERE ";
    if (isset($_POST['field-data'])) {
        if ($_POST['field-name'] != "*") {
            $fieldName = $_POST['field-name'];
            $fieldData = $_POST['field-data'];
            for ($i = 0; $i < count($fieldData); $i++) {
                if ($fieldData[$i] == "") {
                    echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูล $fieldName[$i]!"));
                    break;
                } else {
                    $answercode = $answercode . $fieldName[$i];
                    $resultcode = $resultcode . $fieldName[$i] . " = " . "'$fieldData[$i]'";
                    if ($i < count($fieldName) - 1) {
                        $answercode = $answercode . ", ";
                        $resultcode = $resultcode . " AND ";
                    } else {
                        $answercode = $answercode . ") VALUES(";
                        $resultcode = $resultcode . ";";
                        for ($j = 0; $j < count($fieldData); $j++) {
                            if ($fieldData[$j] == "") {
                                echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูล $fieldName[$i]!"));
                                break;
                            } else {
                                $answercode = $answercode . "'$fieldData[$j]'";
                                if ($j < count($fieldData) - 1) {
                                    $answercode = $answercode . ", ";
                                } else {
                                    $answercode = $answercode . ");";
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
                    $answercode = $answercode . $fieldName[$i];
                    $resultcode = $resultcode . $fieldName[$i] . " = " . "'$fieldData[$i]'";
                    if ($i < count($fieldName) - 1) {
                        $answercode = $answercode . ", ";
                        $resultcode = $resultcode . " AND ";
                    } else {
                        $answercode = $answercode . ") VALUES(";
                        $resultcode = $resultcode . ";";
                        for ($j = 0; $j < count($fieldData); $j++) {
                            if ($fieldData[$j] == "") {
                                echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูล $fieldName[$i]!"));
                                break;
                            } else {
                                $answercode = $answercode . "'$fieldData[$j]'";
                                if ($j < count($fieldData) - 1) {
                                    $answercode = $answercode . ", ";
                                } else {
                                    $answercode = $answercode . ");";
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
    $answercode = "DELETE FROM $table WHERE ";
    $resultcode = "SELECT * FROM \$usertable WHERE ";
    if (isset($_POST['field-data'])) {
        if ($_POST['field-name'] != "*") {
            $fieldName = $_POST['field-name'];
            $fieldData = $_POST['field-data'];
            for ($i = 0; $i < count($fieldData); $i++) {
                if ($fieldData[$i] == "") {
                    echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูล $fieldName[$i]!"));
                    break;
                } else {
                    $answercode = $answercode . $fieldName[$i] . " = " . "'$fieldData[$i]'";
                    $resultcode = $resultcode . $fieldName[$i] . " = " . "'$fieldData[$i]'";
                    if ($i < count($fieldName) - 1) {
                        $answercode = $answercode . " AND ";
                        $resultcode = $resultcode . " AND ";
                    } else {
                        $answercode = $answercode . ";";
                        $resultcode = $resultcode . ";";
                        for ($j = 0; $j < count($fieldData); $j++) {
                            if ($fieldData[$j] == "") {
                                echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูล $fieldName[$i]!"));
                                break;
                            } else {
                                include_once "thai_translation.php";
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
                    $answercode = $answercode . $fieldName[$i] . " = " . "'$fieldData[$i]'";
                    $resultcode = $resultcode . $fieldName[$i] . " = " . "'$fieldData[$i]'";
                    if ($i < count($fieldName) - 1) {
                        $answercode = $answercode . " AND ";
                        $resultcode = $resultcode . " AND ";
                    } else {
                        $answercode = $answercode . ";";
                        $resultcode = $resultcode . ";";
                        for ($j = 0; $j < count($fieldData); $j++) {
                            if ($fieldData[$j] == "") {
                                echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูล $fieldName[$i]!"));
                                break;
                            } else {
                                include_once "thai_translation.php";
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
    $answercode = "UPDATE $table SET ";
    $resultcode = "SELECT * FROM \$usertable WHERE ";
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
                $answercode = $answercode . "$fieldName[$i] = '$afterUpdate[$i]'";
                $resultcode = $resultcode . "$fieldName[$i] = '$afterUpdate[$i]'";
                if ($i < count($beforeUpdate) - 1) {
                    $answercode = $answercode . ", ";
                    $resultcode = $resultcode . " AND ";
                } else {
                    $answercode = $answercode . " WHERE ";
                    $resultcode = $resultcode . ";";
                    for ($j = 0; $j < count($afterUpdate); $j++) {
                        $answercode = $answercode . $fieldName[$j] . " = " . "'$beforeUpdate[$j]'";
                        if ($j < count($afterUpdate) - 1) {
                            $answercode = $answercode . " AND ";
                        } else {
                            $answercode = $answercode . ";";
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
                $answercode = $answercode . "$fieldName[$i] = '$afterUpdate[$i]'";
                $resultcode = $resultcode . "$fieldName[$i] = '$afterUpdate[$i]'";
                if ($i < count($beforeUpdate) - 1) {
                    $answercode = $answercode . ", ";
                    $resultcode = $resultcode . " AND ";
                } else {
                    $answercode = $answercode . " WHERE ";
                    $resultcode = $resultcode . ";";
                    for ($j = 0; $j < count($afterUpdate); $j++) {
                        $answercode = $answercode . $fieldName[$j] . " = " . "'$beforeUpdate[$j]'";
                        if ($j < count($afterUpdate) - 1) {
                            $answercode = $answercode . " AND ";
                        } else {
                            $answercode = $answercode . ";";
                            include_once "thai_translation.php";
                        }
                    }
                }
            }
        }
    }
}