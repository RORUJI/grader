<?php
$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'grader' AND TABLE_NAME = '$table'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=q, initial-scale=1.0">
    <link rel="stylesheet" href="../style2.css?v<?php echo time(); ?>">
</head>

<body>
    <div class="row p-2">
        <div class="col-3 p-2 rounded type-select">
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
            <div class="mb-3">
                <input class="form-check-input" id="all-request" name="data" type="checkbox" value="*">
                <label for="select-all-data" class="form-check-label">ทั้งหมด</label>
            </div>
        </div>
        <div class="col mx-3 p-2 rounded type-select">
            <input type="checkbox" name="condition-checkbox" id="condition-checkbox" class="form-check-input" value="">
            <label for="set-order" class="form-check-label fw-bold">กำหนดเงื่อนไข</label>
            <div class="row">
                <div id="input-condition-field"></div>
            </div>
            <input type="checkbox" name="order-checkbox" id="order-checkbox" class="form-check-input" value="">
            <label for="set-order" class="form-check-label fw-bold">กำหนดการเรียงลำดับ</label>
            <div class="row">
                <div id="input-sort-field"></div>
            </div>
            <input type="checkbox" name="join-checkbox" id="join-checkbox" class="form-check-input" value="">
            <label for="set-join" class="form-check-label fw-bold">กำหนดการ JOIN</label>
            <div class="row">
                <div id="input-join-field"></div>
            </div>
        </div>
    </div>
</body>

<script>
    $(document).ready(function () {
        $('input[name="condition-checkbox"], select[name="condition-count"]').on('change', function (e) {
            let formData = $('#generatorForm').serialize();

            $.ajax({
                type: 'POST',
                url: 'form_storage/condition_selection_form.php',
                data: formData,
                success: function (data) {
                    if (data == "") {
                        $('#input-condition-field').html("");
                    } else {
                        $('#input-condition-field').html(data);
                    }
                }
            });
        });

        $('input[name="order-checkbox"]').on('change', function (e) {
            let formData = $('#generatorForm').serialize();

            $.ajax({
                type: 'POST',
                url: 'form_storage/sorting_selection_form.php',
                data: formData,
                success: function (data) {
                    if (data == "") {
                        $('#input-sort-field').html("");
                    } else {
                        $('#input-sort-field').html(data);
                    }
                }
            });
        });

        $('input[name="join-checkbox"]').on('change', function (e) {
            let formData = $('#generatorForm').serialize();

            $.ajax({
                type: 'POST',
                url: 'form_storage/joined_selection_form.php',
                data: formData,
                success: function (data) {
                    if (data == "") {
                        $('#input-join-field').html("");
                    } else {
                        $('#input-join-field').html(data);
                    }
                }
            });
        });
    });
</script>

</html>