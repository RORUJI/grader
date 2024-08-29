<?php

session_start();
include_once "../dbconnect.php";

if ($_SESSION['level'] != 2) {

    header('location: ../index.php');

} else {
    $tableSql = "SELECT table_name FROM information_schema.tables WHERE table_schema = 'grader'
    AND table_type = 'BASE TABLE' AND table_name NOT LIKE 'mysql_%' AND table_name NOT LIKE 
    'information_schema_%' AND table_name NOT LIKE 'performance_schema_%' AND table_name NOT LIKE 'sys_%' AND
    table_name != 'quiz' AND table_name != 'score' AND table_name != 'type' AND table_name != 'user' AND
    table_name != 'level'";
    $tableQuery = $conn->query($tableSql);
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="../style2.css?v<?php echo time(); ?>">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <title>Grader</title>
    </head>

    <body>
        <nav class="sidebar">
            <header>
                <div class="image-text">
                    <span class="image">
                        <img src="../User.jpg" alt="">
                    </span>

                    <div class="text header-text">
                        <span class="name">
                            <?php echo $_SESSION['username']; ?>
                        </span>
                        <span class="profession">Web developer</span>
                    </div>
                </div>

                <i class='bx bx-chevron-right toggle'></i>

            </header>

            <div class="menu-bar">
                <div class="menu">
                    <li class="search-box">
                        <i class='bx bx-search icon'></i>
                        <input type="search" placeholder="Search...">
                    </li>
                    <li class="nav-link">
                        <a href="../index.php">
                            <i class='bx bx-home icon'></i>
                            <span class="text nav-text">Home</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bxs-user icon'></i>
                            <span class="text nav-text">Profile</span>
                        </a>
                    </li>
                </div>
                <div class="bottom-content">
                    <li class="">
                        <a href="../system/logout_system.php">
                            <i class="bx bx-log-out icon"></i>
                            <span class="text nav-text">Logout</span>
                        </a>
                    </li>

                    <li class="mode">
                        <div class="moon-sun">
                            <i class="bx bx-moon icon moon"></i>
                            <i class="bx bx-sun icon sun"></i>
                        </div>
                        <span class="mode-text text">Dark Mode</span>

                        <div class="toggle-switch">
                            <span class="switch"></span>
                        </div>
                    </li>
                </div>
            </div>
        </nav>

        <section class="home">
            <div class="text">
                <div class="div-text"><br>
                    <div class="div-text">
                        <div class="div-grader">
                            <form action="system_storage/question_generator.php" method="post" id="generatorForm" class="p-3">
                                <h2 class="fw-bold text-center">สร้างโจทย์ปัญหา</h2>
                                <hr>
                                <div class="mb">
                                    <div class="row p-2" id="selectField">
                                        <div id="type-select" class="col-3 p-2 rounded me-3 type-select">
                                            <label for="type" class="form-label fw-bold">เลือกประเภทของโจทย์</label>
                                            <select name="type" id="type" class="form-select form-select-sm">
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
                                        <div id="table-select" class="col p-2 rounded me-2 type-select">
                                            <div class="row">
                                                <div class="col">
                                                    <label for="table"
                                                        class="form-label fw-bold">ตารางที่ต้องการใช้งาน</label>
                                                    <select name="table" id="table" class="form-select form-select-sm">
                                                        <option value="">เลือกตารางข้อมูล</option>
                                                        <?php while ($row = $tableQuery->fetch_assoc()): ?>
                                                            <option value="<?php echo $row['table_name']; ?>">
                                                                <?php echo $row['table_name']; ?>
                                                            </option>
                                                        <?php endwhile; ?>
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
                </div>
            </div>
        </section>

        <script>
            const body = document.querySelector("body"),
                sidebar = body.querySelector(".sidebar"),
                toggle = body.querySelector(".toggle"),
                searchBtn = body.querySelector(".search-box"),
                modeSwtich = body.querySelector(".toggle-switch")
            modeText = body.querySelector(".mode-text");

            toggle.addEventListener("click", () => {
                sidebar.classList.toggle("close");
            });

            modeSwtich.addEventListener("click", () => {
                body.classList.toggle("dark");

                if (body.classList.contains("dark")) {
                    modeText.innerText = "Light Mode"
                } else {
                    modeText.innerText = "Dark Mode"
                }
            });

            $(document).ready(function () {
                $('#type, #table').on('change', function (e) {
                    e.preventDefault();
                    let type = $('#type').val();
                    let table = $('#table').val();
                    $.ajax({
                        type: 'POST',
                        url: 'system_storage/selection_table.php',
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
                                        $.ajax({
                                            type: 'POST',
                                            url: 'form_storage/question_detail_form.php',
                                            data: {
                                                type: result.type,
                                                question: result.question,
                                                answercode: result.answercode,
                                                resultcode: result.resultcode,
                                                temptablecode: result.temptablecode
                                            },
                                            success: function (data) {
                                                $('#input-field').html(data);
                                                $('#selectField').remove();
                                            }
                                        });
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

    </html>

<?php } ?>