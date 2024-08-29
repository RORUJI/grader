<?php
session_start();

include_once "../../dbconnect.php";

$table = $_POST['table'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="row row-cols-4 mb-2">
        <div class="col">
            <?php if ($_POST['count'] != ""): ?>
                <label for="select-field" class="form-label">เลือกคอล์มส์</label>
            <?php endif; ?>
            <?php for ($i = 0; $i < $_POST['count']; $i++): ?>
                <?php
                $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'grader' AND TABLE_NAME = '$table'";
                $result = $conn->query($sql);
                ?>
                <select class="form-select form-select-sm mb-1" name="columnName[]">
                    <option value="">เลือกคอล์มส์</option>
                    <?php while ($row = $result->fetch_array()): ?>
                        <option value="<?php echo $row[0]; ?>">
                            <?php echo $row[0]; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            <?php endfor; ?>
        </div>

        <div class="col">
            <?php if ($_POST['count'] != ""): ?>
                <label for="select-condition" class="form-label">เลือกเงื่อนไข</label>
            <?php endif; ?>
            <?php for ($i = 0; $i < $_POST['count']; $i++): ?>
                <select class="form-select form-select-sm mb-1" name="operator[]">
                    <option value="">เลือกเงื่อนไข</option>
                    <option value=">">มากกว่า</option>
                    <option value="<">น้อยกว่า</option>
                    <option value="=">เท่ากับ</option>
                    <option value=">=">มากกว่าหรือเท่ากับ</option>
                    <option value="<=">น้อยกว่าหรือเท่ากับ</option>
                    <option value="<>">ไม่เท่ากับ</option>
                </select>
            <?php endfor; ?>
        </div>

        <div class="col">
            <?php if ($_POST['count'] != ""): ?>
                <label for="compare" class="form-label">Value</label>
            <?php endif; ?>
            <?php for ($i = 0; $i < $_POST['count']; $i++): ?>
                <input type="text" class="form-control form-control-sm mb-1" name="value[]" placeholder="Value" value="">
            <?php endfor; ?>
        </div>

        <div class="col">
            <?php if ($_POST['count'] > 1): ?>
                <label for="select-compare" class="form-label">เลือกตัวเชื่อม</label>
            <?php endif; ?>
            <?php for ($i = 0; $i < $_POST['count']; $i++): ?>
                <?php if ($i < $_POST['count'] - 1): ?>
                    <select name="logicalOperator[]" class="form-select form-select-sm mb-1">
                        <option value="">เลือกตัวเชื่อม</option>
                        <option value="AND">AND</option>
                        <option value="OR">OR</option>
                    </select>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
</body>

</html>