<?php
session_start();

include_once "../../dbconnect.php";

if (!isset($_POST['data'])) {

} else if ($_POST['data'] == "*") {

} else {
    $input = $_POST['data'];
}
$datas = array();

foreach ($input as $key => $value) {
    $datas[$key] = $value;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="col p-2 bg-secondary-subtle rounded">
        <label for="request-data" class="form-label fw-bold">ต้องการใส่ข้อมูล</label>
        <!--PHP INSERT DATA FIELD LOOP-->
        <?php foreach ($datas as $data): ?>
            <div class="mb-2">
                <label for="input-data" class="form-label">
                    <?php echo $data; ?>
                </label>
                <input type="text" name="data-field[]" id="" class="form-control" value=""
                    placeholder="กรุณากรอก <?php echo $data; ?>">
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>