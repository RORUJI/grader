<?php
session_start();

include_once "../../dbconnect.php";

if (isset($_POST['data'])) {
    $table = $_POST['table'];
    $input = $_POST['data'];
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
        <title>Document</title>
    </head>

    <body>
        <div class="col p-2 bg-secondary-subtle rounded">
            <label for="request-data" class="form-label fw-bold">ต้องการใส่ข้อมูล</label>
            <!--PHP INSERT DATA FIELD LOOP-->
            <?php foreach ($datas as $data): ?>
                <div class="mb-3">
                    <label for="input-data" class="form-label">
                        <?php echo $data; ?>
                    </label>
                    <input type="text" name="data-field[]" id="" class="form-control" value=""
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