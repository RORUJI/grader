<?php
session_start();

include_once "../../dbconnect.php";

if (isset($_POST['order-checkbox'])) {
    $table = $_POST['table'];
    $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'grader' AND TABLE_NAME = '$table'";
    $result = $conn->query($sql);
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
        <div class="row">
            <div class="col mb-3">
                <label for="sort" class="form-label fw-bold">เรียงลำดับ</label>
                <select name="orderby" class="form-select form-select-sm">
                    <option value="">เรียงลำดับโดย</option>
                    <?php
                    $result = $conn->query($sql);
                    ?>
                    <?php while ($row = $result->fetch_array()): ?>
                        <option value="<?php echo $row[0]; ?>">
                            <?php echo $row[0]; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col mb-3">
                <label for="sort" class="form-label fw-bold">เรียงลำดับจาก</label>
                <select class="form-select form-select-sm" name="sort">
                    <option value="">เรียงลำดับ</option>
                    <option value="ASC">น้อยไปมาก</option>
                    <option value="DESC">มากไปน้อย</option>
                </select>
            </div>
        </div>
    </body>

    </html>

<?php } ?>