<?php
session_start();

include_once "../../dbconnect.php";

if (isset($_POST['field-name'])) {
    $table = $_POST['table'];
    $input = $_POST['field-name'];
    $datas = array();

    if ($input != "*") {
        foreach ($input as $key => $value) {
            $datas[$key] = $value;
        }
    } else {
        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'grader' AND TABLE_NAME = '$table'";
        $result = $conn->query($sql);
        while ($row = $result->fetch_array()) {
            $datas[] = $row[0];
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../style2.css?v<?php echo time(); ?>">
        <title>Document</title>
    </head>

    <body>
        <div class="col p-2 rounded type-select">
            <label for="request-data" class="form-label fw-bold">ใส่ข้อมูล</label>
            <!--PHP DATA FIELD LOOP-->
            <?php foreach ($datas as $data): ?>
                <div class="mb-3">
                    <label for="input-data" class="form-label">
                        <?php echo $data; ?>
                    </label>
                    <input type="text" name="field-data[]" id="" class="form-control" value=""
                        placeholder="กรุณากรอก <?php echo $data; ?>">
                </div>
            <?php endforeach; ?>
            <div class="mb">
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </div>
        </div>
    </body>

    </html>

<?php } ?>