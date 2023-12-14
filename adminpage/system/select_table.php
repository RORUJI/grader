<?php
session_start();

include_once "../../dbconnect.php";

$type = $_POST['type'];
$table = $_POST['table'];

if (!empty($type) && !empty($table)) {
    if ($type == 1) {
        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'grader' AND TABLE_NAME = '$table'";
        $result = $conn->query($sql);
        echo "<div class='row p-2'>
                <div class='col-3 p-2 bg-secondary-subtle rounded'>
                    <label for='request' class='form-label fw-bold'>ต้องการเรียกข้อมูลอะไรบ้าง</label>";
        while ($row = $result->fetch_array()) {
            echo
                "<div class='mb-3'>
                    <input class='form-check-input request-data' name='data[]' type='checkbox' value='$row[0]'>
                    <label for='$row[0]' class='form-check-label'>$row[0]</label>
                </div>";
        }
        echo
            "<input class='form-check-input' id='all-request' name='data' type='checkbox' value='*'>
            <label for='All' class='form-check-label'>ทั้งหมด</label>
        </div>
        <div class='col ms-3 p-2 bg-secondary-subtle rounded'>
            <label for='condtion' class='form-label fw-bold'>กำหนดเงื่อนไข</label>
                <div class='row'>";
        $count = 0;
        while ($count < 2) {
            $result = $conn->query($sql);
            $i = 0;
            echo
                "<div class='row row-cols-4 '>
                    <div class='col mb-3'>";
            if ($count < 1) {
                echo "<label for='condition' class='form-label'>เลือกคอล์มส์</label>";
            }
            echo
                "<select class='form-select' name='condition[field][]'>
                    <option value=''>เลือกคอล์มส์</option>";
            while ($row = $result->fetch_array()) {
                echo "<option value='$row[$i]'>$row[$i]</option>";
            }
            echo
                "</select>
            </div>
            <div class='col mb-3'>";
            if ($count < 1) {
                echo "<label for='condition' class='form-label'>เลือกเงื่อนไข</label>";
            }
            echo
                "<select class='form-select' name='condition[condition][]'>'
                    <option value=''>เลือกเงื่อนไข</option>
                    <option value='>'>มากกว่า</option>
                    <option value='<'>น้อยกว่า</option>
                    <option value='='>เท่ากับ</option>
                </select>
            </div>
            <div class='col mb-3'>";
            if ($count < 1) {
                echo "<label for='condition' class='form-label'>กรอกตัวเปรียบเทียบ</label>";
            }
            echo
                "<input type='text' class='form-control' name='condition[compare][]' placeholder='กรอกตัวเปรียบเทียบ' value=''>
            </div>";
            if ($count < 1) {
                echo
                    "<div class='col mb-3'>
                        <label for='' class='form-label'>เลือก</label>
                        <select name='andor' class='form-select'>
                            <option value=''>เลือกตัวเชื่อม</option>
                            <option value='AND'>AND</option>
                            <option value='OR'>OR</option>
                        </select>
                    </div>";
            }
            echo "</div>";
            $i++;
            $count++;
        }
        echo
            "<div class='row'>
                <div class='col mb-3'>
                    <label for='sort' class='form-label fw-bold'>เรียงลำดับ</label>
                    <select class='form-select' name='orderby'>'
                        <option value=''>เรียงลำดับโดย</option>";
        $result = $conn->query($sql);
        $i = 0;
        while ($row = $result->fetch_array()) {
            echo "<option value='$row[$i]'>$row[$i]</option>";
        }
        echo
            "</select>
        </div>
        <div class='col mb-3'>
            <label for='sort' class='form-label fw-bold'>เรียงลำดับจาก</label>
            <select class='form-select' name='sort'>'
                <option value=''>เรียงลำดับ</option>
                <option value='ASC'>น้อยไปมาก</option>
                <option value='DESC'>มากไปน้อย</option>
            </select>
        </div>";
    }
    echo
        "</div>
        <div class='row'>
            <div class='col'>
                <label for='join' class='form-label fw-bold'>JOIN</label>
                <select class='form-select' name='sort'>'
                    <option value=''>เลือกรูปแบบการ JOIN</option>
                    <option value='INNER JOIN'>INNER JOIN</option>
                    <option value='LEFT JOIN'>LEFT JOIN</option>
                    <option value='RIGHT JOIN'>RIGHT JOIN</option>
                    <option value='FULL OUTER JOIN'>FULL OUTER JOIN</option>
                </select>
            </div>";
    $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'grader' AND TABLE_NAME = '$table'";
    $result = $conn->query($sql);
    $mainTable = array();
    while ($row = $result->fetch_array()) {
        $mainTable[] = $row[0];
    }
    $showTable = "SHOW TABLES";
    $result = $conn->query($showTable);
    echo
        "<div class='col'>
            <label for='join' class='form-label fw-bold'>ตารางที่ต้องการ JOIN</label>
            <select class='form-select' name='sort'>'
                <option value=''>เลือกตารางที่ต้องการ JOIN</option>";
    $tablename = array();
    while ($row = $result->fetch_array()) {
        $tablename[] = $row[0];
    }
    for ($i = 0; $i < count($tablename); $i++) {
        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'grader' AND TABLE_NAME = '$tablename[$i]'";
        $result = $conn->query($sql);
        $tablefield = array();
        while ($row = $result->fetch_array()) {
            $tablefield[] = $row[0];
        }
        //echo $mainTable[$i] . " ";
        for ($j = 0; $j < count($mainTable); $j++) {
            for ($k = 0; $k < count($tablefield); $k++) {
                if ($table != $tablename[$i] && $mainTable[$j] == $tablefield[$k]) {
                    echo "<option value='$tablefield[$k]'>$tablename[$i]</option>";
                }
            }
        }
    }
    echo
        "</select>'
        </div>
    </div>
</div>";
}
?>

<script>
    $('#all-request').click(function () {
        $('.request-data').prop('disabled', $('#all-request').is(':checked'));
    });
</script>