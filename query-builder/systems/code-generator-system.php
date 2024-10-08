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
        $code = "SELECT";
        if ($data != "*") {
            foreach ($data as $key => $value) {
                $fieldName[] = $value;
            }
            for ($i = 0; $i < count($fieldName); $i++) {
                if ($i < count($fieldName) - 1) {
                    $code = "$code $fieldName[$i],";
                } else {
                    $code = "$code $fieldName[$i]";
                }
            }
        } else {
            $code = $code . " *";
        }
        $code = $code . " FROM $table";
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
                $code = $code . " $joinType $joinTableData[0] ON $table.$joinTableData[1] = $joinTableData[0].$joinTableData[1]";
                if (isset($_POST['condition-checkbox'])) {
                    $code = $code . " WHERE ";
                    $clauseCount = $_POST['clauseCount'];

                    if ($clauseCount == "") {
                        echo json_encode(array(
                            "status" => "error",
                            "msg" => "กรุณาใส่จำนวนเงื่อนไข!"
                        ));
                    } else {
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
                                        $code = $code . $columnNameArray[$i] . " " . $operatorArray[$i] . " " . "'$valueArray[$i]'" . " " . $logicalOperatorArray[$i] . " ";
                                    } else {
                                        $code = $code . $columnNameArray[$i] . " " . $operatorArray[$i] . " " . "'$valueArray[$i]'";

                                        if (isset($_POST['order-checkbox'])) {
                                            $orderby = $_POST['orderby'];
                                            $sort = $_POST['sort'];
                                            if ($orderby == "") {
                                                echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกคอลัมส์ที่ต้องการจัดเรียง!"));
                                            } else if ($sort == "") {
                                                echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกประเภทการจัดเรียง!"));
                                            } else {
                                                $code = $code . " " . "ORDER BY " . $orderby . " " . $sort;
                                                echo json_encode(array(
                                                    "status" => "success",
                                                    "msg" => "Generate sql code successfully.",
                                                    "code" => $code,
                                                    "type" => $type,
                                                    "table" => $table
                                                ));
                                            }
                                        } else {
                                            echo json_encode(array(
                                                "status" => "success",
                                                "msg" => "Generate sql code successfully.",
                                                "code" => $code,
                                                "type" => $type,
                                                "table" => $table
                                            ));
                                        }
                                    }
                                }
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
                                $code = $code . $columnNameArray[0] . " " . $operatorArray[0] . " " . "'$valueArray[0]'";

                                if (isset($_POST['order-checkbox'])) {
                                    $orderby = $_POST['orderby'];
                                    $sort = $_POST['sort'];
                                    if ($orderby == "") {
                                        echo json_encode(array(
                                            "status" => "error",
                                            "msg" => "กรุณาเลือกคอลัมส์ที่ต้องการจัดเรียง!"
                                        ));
                                    } else if ($sort == "") {
                                        echo json_encode(array(
                                            "status" => "error",
                                            "msg" => "กรุณาเลือกประเภทการจัดเรียง!"
                                        ));
                                    } else {
                                        $code = $code . " " . "ORDER BY " . $orderby . " " . $sort;
                                        echo json_encode(array(
                                            "status" => "success",
                                            "msg" => "Generate sql code successfully.",
                                            "code" => $code,
                                            "type" => $type,
                                            "table" => $table
                                        ));
                                    }
                                } else {
                                    echo json_encode(array(
                                        "status" => "success",
                                        "msg" => "Generate sql code successfully.",
                                        "code" => $code,
                                        "type" => $type,
                                        "table" => $table
                                    ));
                                }
                            }
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
                        $code = $code . " ORDER BY " . $orderby . " " . $sort;
                        echo json_encode(
                            array(
                                "status" => "success",
                                "msg" => "Generate sql code successfully.",
                                "code" => $code,
                                "type" => $type,
                                "table" => $table
                            )
                        );
                    }
                } else {
                    echo json_encode(
                        array(
                            "status" => "success",
                            "msg" => "Generate sql code successfully.",
                            "code" => $code,
                            "type" => $type,
                            "table" => $table
                        )
                    );
                }
            }
        } else {
            if (isset($_POST['condition-checkbox'])) {
                $code = $code . " WHERE ";
                $clauseCount = $_POST['clauseCount'];

                if ($clauseCount == "") {
                    echo json_encode(array(
                        "status" => "error",
                        "msg" => "กรุณาใส่จำนวนเงื่อนไข!"
                    ));
                } else {
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
                                    $code = $code . $columnNameArray[$i] . " " . $operatorArray[$i] . " " . "'$valueArray[$i]'" . " " . $logicalOperatorArray[$i] . " ";
                                } else {
                                    $code = $code . $columnNameArray[$i] . " " . $operatorArray[$i] . " " . "'$valueArray[$i]'";

                                    if (isset($_POST['order-checkbox'])) {
                                        $orderby = $_POST['orderby'];
                                        $sort = $_POST['sort'];
                                        if ($orderby == "") {
                                            echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกคอลัมส์ที่ต้องการจัดเรียง!"));
                                        } else if ($sort == "") {
                                            echo json_encode(array("status" => "error", "msg" => "กรุณาเลือกประเภทการจัดเรียง!"));
                                        } else {
                                            $code = $code . " " . "ORDER BY " . $orderby . " " . $sort;
                                            echo json_encode(array(
                                                "status" => "success",
                                                "msg" => "Generate sql code successfully.",
                                                "code" => $code,
                                                "type" => $type,
                                                "table" => $table
                                            ));
                                        }
                                    } else {
                                        echo json_encode(array(
                                            "status" => "success",
                                            "msg" => "Generate sql code successfully.",
                                            "code" => $code,
                                            "type" => $type,
                                            "table" => $table
                                        ));
                                    }
                                }
                            }
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
                            $code = $code . $columnNameArray[0] . " " . $operatorArray[0] . " " . "'$valueArray[0]'";

                            if (isset($_POST['order-checkbox'])) {
                                $orderby = $_POST['orderby'];
                                $sort = $_POST['sort'];
                                if ($orderby == "") {
                                    echo json_encode(array(
                                        "status" => "error",
                                        "msg" => "กรุณาเลือกคอลัมส์ที่ต้องการจัดเรียง!"
                                    ));
                                } else if ($sort == "") {
                                    echo json_encode(array(
                                        "status" => "error",
                                        "msg" => "กรุณาเลือกประเภทการจัดเรียง!"
                                    ));
                                } else {
                                    $code = $code . " " . "ORDER BY " . $orderby . " " . $sort;
                                    echo json_encode(array(
                                        "status" => "success",
                                        "msg" => "Generate sql code successfully.",
                                        "code" => $code,
                                        "type" => $type,
                                        "table" => $table
                                    ));
                                }
                            } else {
                                echo json_encode(array(
                                    "status" => "success",
                                    "msg" => "Generate sql code successfully.",
                                    "code" => $code,
                                    "type" => $type,
                                    "table" => $table
                                ));
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
                        $code = $code . " ORDER BY " . $orderby . " " . $sort;
                        echo json_encode(
                            array(
                                "status" => "success",
                                "msg" => "Generate sql code successfully.",
                                "code" => $code,
                                "type" => $type,
                                "table" => $table
                            )
                        );
                    }
                } else {
                    echo json_encode(
                        array(
                            "status" => "success",
                            "msg" => "Generate sql code successfully.",
                            "code" => $code,
                            "type" => $type,
                            "table" => $table
                        )
                    );
                }
            }
        }
    }
} else if ($type == 2) {
    $fieldName = [];
    $fieldData = [];
    $code = "INSERT INTO $table(";
    if (isset($_POST['field-data'])) {
        if ($_POST['field-name'] != "*") {
            $fieldName = $_POST['field-name'];
            $fieldData = $_POST['field-data'];
            for ($i = 0; $i < count($fieldData); $i++) {
                if ($fieldData[$i] == "") {
                    echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูล $fieldName[$i]!"));
                    break;
                } else {
                    $code = $code . $fieldName[$i];
                    if ($i < count($fieldName) - 1) {
                        $code = $code . ", ";
                    } else {
                        $code = $code . ") VALUES(";
                        for ($j = 0; $j < count($fieldData); $j++) {
                            if ($fieldData[$j] == "") {
                                echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูล $fieldName[$i]!"));
                                break;
                            } else {
                                $code = $code . "'$fieldData[$j]'";
                                if ($j < count($fieldData) - 1) {
                                    $code = $code . ", ";
                                } else {
                                    $code = $code . ");";
                                    echo json_encode(
                                        array(
                                            "status" => "success",
                                            "msg" => "Generate sql code successfully.",
                                            "code" => $code,
                                            "type" => $type,
                                            "table" => $table
                                        )
                                    );
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
                    $code = $code . $fieldName[$i];
                    if ($i < count($fieldName) - 1) {
                        $code = $code . ", ";
                    } else {
                        $code = $code . ") VALUES(";
                        for ($j = 0; $j < count($fieldData); $j++) {
                            if ($fieldData[$j] == "") {
                                echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูล $fieldName[$i]!"));
                                break;
                            } else {
                                $code = $code . "'$fieldData[$j]'";
                                if ($j < count($fieldData) - 1) {
                                    $code = $code . ", ";
                                } else {
                                    $code = $code . ");";
                                    echo json_encode(
                                        array(
                                            "status" => "success",
                                            "msg" => "Generate sql code successfully.",
                                            "code" => $code,
                                            "type" => $type,
                                            "table" => $table
                                        )
                                    );
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
    $code = "DELETE FROM $table WHERE ";
    if (isset($_POST['field-data'])) {
        if ($_POST['field-name'] != "*") {
            $fieldName = $_POST['field-name'];
            $fieldData = $_POST['field-data'];
            for ($i = 0; $i < count($fieldData); $i++) {
                if ($fieldData[$i] == "") {
                    echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูล $fieldName[$i]!"));
                    break;
                } else {
                    $code = $code . $fieldName[$i] . " = " . "'$fieldData[$i]'";
                    if ($i < count($fieldName) - 1) {
                        $code = $code . " AND ";
                    } else {
                        $code = $code . ";";
                        for ($j = 0; $j < count($fieldData); $j++) {
                            if ($fieldData[$j] == "") {
                                echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูล $fieldName[$i]!"));
                                break;
                            } else {
                                echo json_encode(
                                    array(
                                        "status" => "success",
                                        "msg" => "Generate sql code successfully.",
                                        "code" => $code,
                                        "type" => $type,
                                        "table" => $table
                                    )
                                );
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
                    $code = $code . $fieldName[$i] . " = " . "'$fieldData[$i]'";
                    if ($i < count($fieldName) - 1) {
                        $code = $code . " AND ";
                    } else {
                        $code = $code . ";";
                        for ($j = 0; $j < count($fieldData); $j++) {
                            if ($fieldData[$j] == "") {
                                echo json_encode(array("status" => "error", "msg" => "กรุณากรอกข้อมูล $fieldName[$i]!"));
                                break;
                            } else {
                                echo json_encode(
                                    array(
                                        "status" => "success",
                                        "msg" => "Generate sql code successfully.",
                                        "code" => $code,
                                        "type" => $type,
                                        "table" => $table
                                    )
                                );
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
    $code = "UPDATE $table SET ";
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
                $code = $code . "$fieldName[$i] = '$afterUpdate[$i]'";
                if ($i < count($beforeUpdate) - 1) {
                    $code = $code . ", ";
                } else {
                    $code = $code . " WHERE ";
                    for ($j = 0; $j < count($afterUpdate); $j++) {
                        $code = $code . $fieldName[$j] . " = " . "'$beforeUpdate[$j]'";
                        if ($j < count($afterUpdate) - 1) {
                            $code = $code . " AND ";
                        } else {
                            $code = $code . ";";
                        }
                    }
                    echo json_encode(
                        array(
                            "status" => "success",
                            "msg" => "Generate sql code successfully.",
                            "code" => $code,
                            "type" => $type,
                            "table" => $table
                        )
                    );
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
                $code = $code . "$fieldName[$i] = '$afterUpdate[$i]'";

                if ($i < count($beforeUpdate) - 1) {
                    $code = $code . ", ";
                } else {
                    $code = $code . " WHERE ";
                    for ($j = 0; $j < count($afterUpdate); $j++) {
                        $code = $code . $fieldName[$j] . " = " . "'$beforeUpdate[$j]'";

                        if ($j < count($afterUpdate) - 1) {
                            $code = $code . " AND ";
                        } else {
                            $code = $code . ";";
                        }
                    }
                    echo json_encode(
                        array(
                            "status" => "success",
                            "msg" => "Generate sql code successfully.",
                            "code" => $code,
                            "type" => $type,
                            "table" => $table
                        )
                    );
                }
            }
        }
    }
}