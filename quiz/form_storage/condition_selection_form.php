<?php
session_start();

include_once "../../dbconnect.php";

if (isset($_POST['condition-checkbox'])) {
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
        <?php $i = 0; ?>
        <?php while ($i < 1): ?>
            <?php
            $result = $conn->query($sql);
            ?>
            <div class="row row-cols-4">
                <div class="col mb-3">
                    <?php if ($i < 1): ?>
                        <label for="select-field" class="form-label">เลือกคอล์มส์</label>
                    <?php endif; ?>
                    <select class="form-select" name="condition[field][]">
                        <option value="">เลือกคอล์มส์</option>
                        <?php while ($row = $result->fetch_array()): ?>
                            <option value="<?php echo $row[0]; ?>">
                                <?php echo $row[0]; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col mb-3'">
                    <?php if ($i < 1): ?>
                        <label for="select-condition" class="form-label">เลือกเงื่อนไข</label>
                    <?php endif; ?>
                    <select class="form-select" name="condition[condition][]">
                        <option value="">เลือกเงื่อนไข</option>
                        <option value=">">มากกว่า</option>
                        <option value="<">น้อยกว่า</option>
                        <option value="=">เท่ากับ</option>
                    </select>
                </div>
                <div class="col mb-3">
                    <?php if ($i < 1): ?>
                        <label for="compare" class="form-label">กรอกตัวเปรียบเทียบ</label>
                    <?php endif; ?>
                    <input type="text" class="form-control" name="condition[compare][]" placeholder="กรอกตัวเปรียบเทียบ"
                        value="">
                </div>
                <?php if ($i < 1): ?>
                    <!-- <div class="col mb-3">
                        <label for="select-compare" class="form-label">เลือกตัวเชื่อม</label>
                        <select name="conditionLink" class="form-select">
                            <option value="">เลือกตัวเชื่อม</option>
                            <option value="AND">AND</option>
                            <option value="OR">OR</option>
                        </select>
                    </div> -->
                <?php endif; ?>
            </div>
            <?php
            $i++;
            ?>
        <?php endwhile; ?>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script></script>
    </body>

    </html>

<?php } ?>