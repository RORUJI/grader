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
    <nav class="navbar navbar-expand-lg bg-body">
        <div class="container">
            <a class="navbar-brand" href="home.php">
                <h2 class="text-primary fw-bold">G r a d e r</h2>
            </a>
            <div class="justify-content-end align-items-center">
                <?php if (!isset($_SESSION['levelID'])): ?>
                    <a href="login.php" class="btn btn-primary ms-3">Login</a>
                <?php endif; ?>
                <?php if (isset($_SESSION['levelID'])): ?>
                    <span class="text-primary fw-bold"><i class="bi bi-person-fill"></i> Username:&nbsp;</span>
                    <span>
                        <?php echo $_SESSION['username']; ?>
                    </span>
                    <a href="system/logout_system.php" id="signout-btn" class="btn btn-danger ms-3">
                        <i class="bi bi-door-closed-fill"></i>Logout</a>
                <?php endif; ?>
                <button type="button" class="btn btn-danger" id="btnBack">Back</button>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="position-absolute top-50 start-50 translate-middle" style="width: 150vh; height: 75vh">
            <form action="system/genarator_question_system.php" method="post" id="generatorForm"
                class="bg-body p-3 w-100 h-100 rounded shadow-lg overflow-y-scroll">
                <h2 class="fw-bold text-center">สร้างโจทย์ปัญหา</h2>
                <hr>
                <div class="mb">
                    <div class="row p-2">
                        <div id="type-select" class="col-3 p-2 bg-secondary-subtle rounded me-3">
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
                        <div class="col p-2 bg-secondary-subtle rounded me-3">
                            <div class="row">
                                <div class="col">
                                    <label for="table" class="form-label fw-bold">ตารางที่ต้องการใช้งาน</label>
                                    <select name="table" id="table" class="form-select">
                                        <option value="">เลือกตารางข้อมูล</option>
                                        <option value="person">person</option>
                                        <option value="gender">gender</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div id="input-field"></div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#type, #table').on('change', function (e) {
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
                        if (type == "" || table == "") {
                            $('#input-field').html('');
                        } else {
                            $('#input-field').html(data);
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
                                text: result.msg,
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
                                                $('#input-field').html(data);
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
                                                $('#input-field').html(data);
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
                                                $('#input-field').html(data);
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