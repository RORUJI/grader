<?php
session_start();

include_once "../../dbconnect.php";

$type = $_POST['type'];
$table = $_POST['table'];

if (!empty($type) && !empty($table)) {
    if ($type == 1) {
        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table'";
        $result = $conn->query($sql);
        echo "<div class='row'>";
        echo "<div class='col-3'>";
        echo "<label for='request' class='form-label'>ต้องการเรียกข้อมูลอะไรบ้าง</label>";
        while ($row = $result->fetch_array()) {
            $i = 0;
            echo "<div class='mb-3'>";
            echo "<input class='form-check-input request-data' name='data[]' type='checkbox' value='$row[$i]'> ";
            echo "<label for='$row[$i]' class='form-check-label'>$row[$i]</label>";
            echo "</div>";
            $i++;
        }
        echo "<input class='form-check-input' id='all-request' name='data' type='checkbox' value='*'> ";
        echo "<label for='All' class='form-check-label'>ทั้งหมด</label>";
        echo "</div>";
        echo "<div class='col'>";
        echo "<label for='condtion' class='form-label'>กำหนดเงื่อนไข</label>";
        echo "<div class='row'>";
        $count = 0;
        while ($count < 2) {
            $result = $conn->query($sql);
            $i = 0;
            echo "<div class='row'>";
            echo "<div class='col mb-3'>";
            echo "<label for='condition' class='form-label'>เลือกคอล์มส์</label>";
            echo "<select class='form-select' name='condition[field][]'>";
            echo "<option value=''>";
            echo "เลือกคอล์มส์";
            echo "</option>";
            while ($row = $result->fetch_array()) {
                echo "<option value='$row[$i]'>";
                echo $row[$i];
                echo "</option>";
            }
            echo "</select>";
            echo "</div>";
            echo "<div class='col mb-3'>";
            echo "<label for='condition' class='form-label'>เลือกเงื่อนไข</label>";
            echo "<select class='form-select' name='condition[condition][]'>'";
            echo "<option value=''>";
            echo "เลือกเงื่อนไข";
            echo "</option>";
            echo "<option value='>'>";
            echo "มากกว่า";
            echo "</option>";
            echo "<option value='<'>";
            echo "น้อยกว่า";
            echo "</option>";
            echo "<option value='='>";
            echo "เท่ากับ";
            echo "</option>";
            echo "</select>";
            echo "</div>";
            echo "<div class='col mb-3'>";
            echo "<label for='condition' class='form-label'>กรอกตัวเปรียบเทียบ</label>";
            echo "<input type='text' class='form-control' name='condition[compare][]' placeholder='กรอกตัวเปรียบเทียบ' value=''>";
            echo "</div>";
            if ($count < 1) {
                echo "<div class='col mb-3'>";
                echo "<label for='' class='form-label'>เลือก</label>";
                echo "<select name='andor' class='form-select'>";
                echo "<option value=''>";
                echo "เลือกตัวเชื่อม";
                echo "</option>";
                echo "<option value='AND'>";
                echo "AND";
                echo "</option>";
                echo "<option value='OR'>";
                echo "OR";
                echo "</option>";
                echo "</select>";
                echo "</div>";
            }
            echo "</div>";
            $i++;
            $count++;
        }
        echo "<div class='row'>";
        echo "<div class='col mb-3'>";
        echo "<label for='sort' class='form-label'>เรียงลำดับ</label>";
        echo "<select class='form-select' name='orderby'>'";
        echo "<option value=''>";
        echo "เรียงลำดับโดย";
        echo "</option>";
        $result = $conn->query($sql);
        $i = 0;
        while ($row = $result->fetch_array()) {
            echo "<option value='$row[$i]'>";
            echo $row[$i];
            echo "</option>";
        }
        echo "</select>";
        echo "</div>";
        echo "<div class='col mb-3'>";
        echo "<label for='sort' class='form-label'>เรียงลำดับจาก</label>";
        echo "<select class='form-select' name='sort'>'";
        echo "<option value=''>";
        echo "เรียงลำดับ";
        echo "</option>";
        echo "<option value='ASC'>";
        echo "น้อยไปมาก";
        echo "</option>";
        echo "<option value='DESC'>";
        echo "มากไปน้อย";
        echo "</option>";
        echo "</select>";
        echo "</div>";
        echo "</div>";
    }
    echo "</div>";
    echo "</div>";
    echo "</div>";
}
?>

<script>
    $('#all-request').click(function() {
        $('.request-data').prop('disabled', $('#all-request').is(':checked'));
    });
</script>