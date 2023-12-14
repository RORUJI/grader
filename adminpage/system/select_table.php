<?php
session_start();

include_once "../../dbconnect.php";

$type = $_POST['type'];
$table = $_POST['table'];

if (!empty($type) && !empty($table)) {
    if ($type == 1) {
        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table'";
        $result = $conn->query($sql);
        echo "<div class='row'>
                <div class='col-3'>
                    <label for='request' class='form-label'>ต้องการเรียกข้อมูลอะไรบ้าง</label>";
        while ($row = $result->fetch_array()) {
            $i = 0;
            echo
                "<div class='mb-3'>
                    <input class='form-check-input request-data' name='data[]' type='checkbox' value='$row[$i]'>
                    <label for='$row[$i]' class='form-check-label'>$row[$i]</label>
                </div>";
            $i++;
        }
        echo
            "<input class='form-check-input' id='all-request' name='data' type='checkbox' value='*'>
            <label for='All' class='form-check-label'>ทั้งหมด</label>
        </div>
        <div class='col'>
            <label for='condtion' class='form-label'>กำหนดเงื่อนไข</label>
                <div class='row'>";
        $count = 0;
        while ($count < 2) {
            $result = $conn->query($sql);
            $i = 0;
            echo
                "<div class='row'>
                    <div class='col mb-3'>
                        <label for='condition' class='form-label'>เลือกคอล์มส์</label>
                        <select class='form-select' name='condition[field][]'>
                            <option value=''>เลือกคอล์มส์</option>";
            while ($row = $result->fetch_array()) {
                echo "<option value='$row[$i]'>$row[$i]</option>";
            }
            echo
                "</select>
            </div>
            <div class='col mb-3'>
                <label for='condition' class='form-label'>เลือกเงื่อนไข</label>
                <select class='form-select' name='condition[condition][]'>'
                    <option value=''>เลือกเงื่อนไข</option>
                    <option value='>'>มากกว่า</option>
                    <option value='<'>น้อยกว่า</option>
                    <option value='='>เท่ากับ</option>
                </select>
            </div>
            <div class='col mb-3'>
                <label for='condition' class='form-label'>กรอกตัวเปรียบเทียบ</label>
                <input type='text' class='form-control' name='condition[compare][]' placeholder='กรอกตัวเปรียบเทียบ' value=''>
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
                    <label for='sort' class='form-label'>เรียงลำดับ</label>
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
            <label for='sort' class='form-label'>เรียงลำดับจาก</label>
            <select class='form-select' name='sort'>'
                <option value=''>เรียงลำดับ</option>
                <option value='ASC'>น้อยไปมาก</option>
                <option value='DESC'>มากไปน้อย</option>
            </select>
        </div>";
    }
    echo
        "</div>
    </div>";
}
?>

<script>
    $('#all-request').click(function () {
        $('.request-data').prop('disabled', $('#all-request').is(':checked'));
    });
</script>