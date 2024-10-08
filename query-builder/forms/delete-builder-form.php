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
    <div class="col-3 mx-2 p-2 rounded type-select">
        <label for="request-insert-data" class="form-label fw-bold">ต้องการลบข้อมูลอะไรบ้าง</label>
        <!--PHP DELETE TABLE FIELD LOOP-->
        <?php while ($row = $result->fetch_array()): ?>
            <div class="mb-3">
                <input type="checkbox" name="field-name[]" id="request-data" class="form-check-input request-data"
                    value="<?php echo $row[0]; ?>">
                <label for="select-data" class="form-check-label">
                    <?php echo $row[0]; ?>
                </label>
            </div>
        <?php endwhile; ?>
        <input class="form-check-input" id="all-select" name="field-name" type="checkbox" value="*">
        <label for="select-all-data" class="form-check-label">ทั้งหมด</label>
    </div>
    <div id="input-data" class="col mx-2 p-2 rounded type-select"></div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('input[name="field-name[]"]').on('change', function (e) {
                let datas = $('#generatorForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: 'forms/delete-data-form.php',
                    data: datas,
                    success: function (data) {
                        if (data == "") {
                            $('#input-data').html('');
                        } else {
                            $('#input-data').html(data);
                        }
                    }
                });
            });
        });

        $(document).ready(function () {
            $('#all-select').click(function () {
                $('.request-data').prop('disabled', $('#all-select').is(':checked'));

                let datas = $('#generatorForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: 'forms/delete-data-form.php',
                    data: datas,
                    success: function (data) {
                        if (data == "") {
                            $('#input-data').html('');
                        } else {
                            $('#input-data').html(data);
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>