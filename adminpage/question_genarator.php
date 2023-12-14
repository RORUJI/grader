<?php
session_start();

include_once "../dbconnect.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../style.css?v<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Grader</title>
</head>

<body class="bg-primary">
    <div class="container-fluid">
        <div class="position-absolute top-50 start-50 translate-middle" style="width: 150vh; height: 80vh;">
            <form action="system/genarator_question_system.php" method="post" id="generatorForm"
                class="bg-body p-3 w-100 h-100 rounded shadow-lg overflow-y-scroll">
                <h2 class="fw-bold text-center">สร้างโจทย์ปัญหา</h2>
                <hr>
                <div class="mb">
                    <div class="row p-2">
                        <div class="col-3 p-2 bg-secondary-subtle rounded me-3">
                            <label for="type" class="form-label fw-bold">เลือกประเภทของโจทย์</label>
                            <select name="type" id="type" class="form-select">
                                <option value="">เลือกประเภทของโจทย์</option>
                                <?php $sql = "SELECT * FROM type";
                                $result = $conn->query($sql);
                                while ($row = $result->fetch_assoc()): ?>
                                    <option value="<?php echo $row['typeID']; ?>">
                                        <?php echo $row['type']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-4 p-2 bg-secondary-subtle rounded">
                            <label for="table" class="form-label fw-bold">ตารางที่ต้องการใช้งาน</label>
                            <div class="row">
                                <div class="col-8">
                                    <select name="table" id="table" class="form-select w-100">
                                        <option value="">เลือกตารางข้อมูล</option>
                                        <option value="person">person</option>
                                        <option value="gender">gender</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-primary w-100" id="btn-tb">ตกลง</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb">
                    <span id="check"></span>
                </div>
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#btn-tb').on('click', function (e) {
                e.preventDefault();
                let type = $('#type').val();
                let table = $('#table').val();
                $.ajax({
                    type: 'POST',
                    url: 'system/select_table.php',
                    data: {
                        type: type,
                        table: table
                    },
                    success: function (data) {
                        if (type == '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'ล้มเหลว',
                                text: 'กรุณาเลือกประเภทของโจทย์ปัญหา!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else if (table == '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'ล้มเหลว',
                                text: 'กรุณาเลือกตารางข้อมูล!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            $('#check').html(data);
                        }
                    }
                });
            });
        });

        $(document).ready(function () {
            $('#generatorForm').submit(function (e) {
                e.preventDefault();
                let formUrl = $(this).attr('action');
                let reqMethod = $(this).attr('method');
                let formData = $(this).serialize();

                $.ajax({
                    type: reqMethod,
                    url: formUrl,
                    data: formData,
                    success: function (data) {
                        let result = JSON.parse(data);

                        if (result.status == 'success') {
                            console.log(result.msg);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'ล้มเหลว!',
                                text: result.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>