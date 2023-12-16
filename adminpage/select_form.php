<?php
$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'grader' AND TABLE_NAME = '$table'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=q, initial-scale=1.0">
</head>

<body>
    <div class="row p-2">
        <div class="col-3 p-2 bg-secondary-subtle rounded">
            <label for="request-data" class="form-label fw-bold">ต้องการเรียกข้อมูลอะไรบ้าง</label>
            <!--PHP SELECT TABLE FIELD LOOP-->
            <?php while ($row = $result->fetch_array()): ?>
                <div class="mb-3">
                    <input type="checkbox" name="data[]" id="request-data" class="form-check-input request-data"
                        value="<?php echo $row[0]; ?>">
                    <label for="select-data" class="form-check-label">
                        <?php echo $row[0]; ?>
                    </label>
                </div>
            <?php endwhile; ?>

            <input class="form-check-input" id="all-request" name="data" type="checkbox" value="*">
            <label for="select-all-data" class="form-check-label">ทั้งหมด</label>
        </div>
        <div class="col ms-3 p-2 bg-secondary-subtle rounded">
            <label for="set-condition" class="form-label fw-bold">กำหนดเงื่อนไข</label>
            <div class="row">
                <?php $i = 0; ?>
                <?php while ($i < 2): ?>
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
                            <input type="text" class="form-control" name="condition[compare][]"
                                placeholder="กรอกตัวเปรียบเทียบ" value="">
                        </div>
                        <?php if ($i < 1): ?>
                            <div class="col mb-3">
                                <label for="select-compare" class="form-label">เลือกตัวเชื่อม</label>
                                <select name="andor" class="form-select">
                                    <option value="">เลือกตัวเชื่อม</option>
                                    <option value="AND">AND</option>
                                    <option value="OR">OR</option>
                                </select>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php
                    $i++;
                    ?>
                <?php endwhile; ?>
                <div class="row">
                    <div class="col mb-3">
                        <label for="sort" class="form-label fw-bold">เรียงลำดับ</label>
                        <select name="orderby" class="form-select">
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
                        <select class="form-select" name="sort">
                            <option value="">เรียงลำดับ</option>
                            <option value="ASC">น้อยไปมาก</option>
                            <option value="DESC">มากไปน้อย</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="select-join-type" class="form-label fw-bold">JOIN</label>
                        <select class="form-select" name="jointype">"
                            <option value="">เลือกรูปแบบการ JOIN</option>
                            <option value="INNER JOIN">INNER JOIN</option>
                            <option value="LEFT JOIN">LEFT JOIN</option>
                            <option value="RIGHT JOIN">RIGHT JOIN</option>
                            <option value="FULL OUTER JOIN">FULL OUTER JOIN</option>
                        </select>
                    </div>
                    <?php
                    $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'grader' AND TABLE_NAME = '$table'";
                    $result = $conn->query($sql);
                    $mainTable = array();

                    while ($row = $result->fetch_array()) {
                        $mainTable[] = $row[0];
                    }
                    $showTable = "SHOW TABLES";
                    $result = $conn->query($showTable);
                    $tablename = array();

                    while ($row = $result->fetch_array()) {
                        $tablename[] = $row[0];
                    }
                    ?>
                    <div class="col">
                        <label for='select-join-table' class='form-label fw-bold'>ตารางที่ต้องการ JOIN</label>
                        <select name="jointable" class="form-select">
                            <option value="">เลือกตารางที่ต้องการ JOIN</option>;
                            <?php
                            for ($i = 0; $i < count($tablename); $i++) {
                                $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'grader' AND TABLE_NAME = '$tablename[$i]'";
                                $result = $conn->query($sql);
                                $tablefield = array();
                                while ($row = $result->fetch_array()) {
                                    $tablefield[] = $row[0];
                                }
                                ?>
                                <?php for ($j = 0; $j < count($mainTable); $j++): ?>
                                    <?php for ($k = 0; $k < count($tablefield); $k++): ?>
                                        <?php if ($table != $tablename[$i] && $mainTable[$j] == $tablefield[$k]): ?>
                                            <option value="<?php echo $tablename[$i] . " " . $tablefield[$k]; ?>">
                                                <?php echo $tablename[$i]; ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                <?php endfor; ?>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>