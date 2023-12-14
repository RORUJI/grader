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
        <form action="system/genarator_question_system.php" method="post" class="bg-body p-3 w-100 h-100">
            <h2 class="fw-bold text-center">สร้างโจทย์ปัญหา</h2>
            <hr>
            <div class="mb-3">
                <div class="row">
                    <div class="col-3">
                        <label for="type" class="form-label">เลือกประเภทของโจทย์</label>
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
        </form>
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
    </script>
</body>