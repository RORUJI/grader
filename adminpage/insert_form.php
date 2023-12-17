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
            <label for="request-insert-data" class="form-label fw-bold">ต้องการใส่ข้อมูลอะไรบ้าง</label>
            <!--PHP INSERT TABLE FIELD LOOP-->
            <?php while ($row = $result->fetch_array()): ?>
                <div class="mb-3">
                    <input type="checkbox" name="data[]" id="request-data" class="form-check-input request-data"
                        value="<?php echo $row[0]; ?>">
                    <label for="select-data" class="form-check-label">
                        <?php echo $row[0]; ?>
                    </label>
                </div>
            <?php endwhile; ?>
            <input class="form-check-input" id="all-select" name="data" type="checkbox" value="*">
            <label for="select-all-data" class="form-check-label">ทั้งหมด</label>
            <div class="row">
                <div class="col mt-2">
                    <button type="button" id="btn" class="btn btn-primary">
                        ยืนยัน
                    </button>
                </div>
            </div>
        </div>
        <div id="input-data" class="col">

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('#btn').on('click', function () {
                let datas = $('#generatorForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: 'system/input_data_system.php',
                    data: datas,
                    success: function (data) {
                        if (data == "") {
                            Swal.fire({
                                icon: 'error',
                                title: 'ล้มเหลว!',
                                text: 'กรุณาเลือกข้อมูลที่ต้องการให้ใส่',
                                showConfirmButton: false,
                                timer: 1500
                            });
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
            });
        });
    </script>
</body>

</html>