<?php
session_start();

include_once "../dbconnect.php";

$type = "test";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../style.css?v<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Grader</title>
</head>

<body class="bg-primary">
    <div class="container-fluid">
<<<<<<< HEAD
        <div class="position-absolute top-50 start-50 translate-middle" style="width: 150vh;">
            <form action="system/genarator_question_system.php" method="post" id="generatorForm" class="bg-body p-3 w-100 h-100">
                <h2 class="fw-bold text-center">สร้างโจทย์ปัญหา</h2>
                <hr>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-3">
                            <label for="type" class="form-label">เลือกประเภทของโจทย์</label>
=======
        <div class="position-absolute top-50 start-50 translate-middle" style="width: 150vh; height: 75vh;">
            <form action="system/genarator_question_system.php" method="post" id="generatorForm"
                class="bg-body p-3 w-100 h-100 rounded shadow-lg overflow-y-scroll">
                <h2 class="fw-bold text-center">สร้างโจทย์ปัญหา</h2>
                <hr>
                <div class="mb">
                    <div class="row p-2">
                        <div id="type-select" class="col-3 p-2 bg-secondary-subtle rounded me-3">
                            <label for="type" class="form-label fw-bold">เลือกประเภทของโจทย์</label>
>>>>>>> ded83b0489228833df1517cd8053755522c07ff9
                            <select name="type" id="type" class="form-select">
                                <option value="">เลือกประเภทของโจทย์</option>
                                <?php $sql = "SELECT * FROM type";
                                $result = $conn->query($sql);
<<<<<<< HEAD
                                while ($row = $result->fetch_assoc()) : ?>
=======
                                while ($row = $result->fetch_assoc()): ?>
>>>>>>> ded83b0489228833df1517cd8053755522c07ff9
                                    <option value="<?php echo $row['typeID']; ?>">
                                        <?php echo $row['type']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
<<<<<<< HEAD
                        <div class="col">
                            <label for="table" class="form-label">ตารางที่ต้องการใช้งาน</label>
                            <select name="table" id="table" class="form-select">
                                <option value="">เลือกตารางข้อมูล</option>
                                <option value="person">person</option>
                                <option value="gender">gender</option>
                            </select>
                        </div>
                        <div class="col-1">
                            <label for="" class="form-label"></label>
                            <button type="button" class="btn btn-primary" id="btn-tb">ตกลง</button>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <span id="check"></span>
                </div>
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
=======
                        <div id="table-select" class="col-4 p-2 bg-secondary-subtle rounded">
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
                    <span id="check">

                    </span>
                </div>
>>>>>>> ded83b0489228833df1517cd8053755522c07ff9
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#btn-tb').on('click', function(e) {
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
                    success: function(data) {
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
                            Swal.fire({
                                icon: 'success',
                                title: 'สำเร็จ!',
                                text: result.question,
                                showConfirmButton: true,
                                showCancelButton: true,
                                confirmButtonText: 'ดูผลลับ',
                                cancelButtonText: 'แก้ไข',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33'
                            }).then(function (r) {
                                if (r.isConfirmed) {
                                    let type = $('#type').val();

                                    if (type == 1) {
                                        $.ajax({
                                            type: 'POST',
                                            url: 'system/question_detail_system.php',
                                            data: {
                                                type: result.type,
                                                question: result.question,
                                                selectSQL: result.selectSQL
                                            },
                                            success: function (data) {
                                                $('#check').html(data);
                                                $('#type-select').remove();
                                                $('#table-select').remove();
                                            }
                                        });
                                    } else if (type == 2) {
                                        $.ajax({
                                            type: 'POST',
                                            url: 'system/question_detail_system.php',
                                            data: {
                                                type: result.type,
                                                question: result.question,
                                                selectSQL: result.selectSQL,
                                                insertSQL: result.insertSQL,
                                                deleteSQL: result.deleteSQL
                                            },
                                            success: function (data) {
                                                $('#check').html(data);
                                                $('#type-select').remove();
                                                $('#table-select').remove();
                                            }
                                        });
                                    } else if (type == 3) {
                                        $.ajax({
                                            type: 'POST',
                                            url: 'system/question_detail_system.php',
                                            data: {
                                                type: result.type,
                                                question: result.question,
                                                selectSQL: result.selectSQL,
                                                insertSQL: result.insertSQL,
                                                deleteSQL: result.deleteSQL
                                            },
                                            success: function (data) {
                                                $('#check').html(data);
                                                $('#type-select').remove();
                                                $('#table-select').remove();
                                            }
                                        });
                                    }
                                } else {

                                }
                            });
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