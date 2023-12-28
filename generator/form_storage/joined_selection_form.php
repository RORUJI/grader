<?php
session_start();

include_once "../../dbconnect.php";

if (isset($_POST['join-checkbox'])) {
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
    </body>

    </html>

<?php } ?>