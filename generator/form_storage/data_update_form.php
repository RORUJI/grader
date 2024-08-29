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
        <div class="row" style="flex-grow: 1;">
            <div class="col">
                <label for="request-data" class="form-label fw-bold">ก่อนแก้ไข</label>
                <!--PHP DATA FIELD LOOP-->
                <?php foreach ($datas as $data): ?>
                    <div class="mb-2">
                        <label for="input-data" class="form-label">
                            <?php echo $data; ?>
                        </label>
                        <input type="text" name="before-update-field[]" id="" class="form-control form-control-sm" value=""
                            placeholder="กรุณากรอก <?php echo $data; ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col">
                <label for="request-data" class="form-label fw-bold">หลังแก้ไข</label>
                <!--PHP DATA FIELD LOOP-->
                <?php foreach ($datas as $data): ?>
                    <div class="mb-2">
                        <label for="input-data" class="form-label">
                            <?php echo $data; ?>
                        </label>
                        <input type="text" name="after-update-field[]" id="" class="form-control form-control-sm" value=""
                            placeholder="กรุณากรอก <?php echo $data; ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="text-end">
            <button class="btn btn-primary btn-sm">Create</button>
        </div>
    </body>

    </html>
<?php } ?>