<!doctype html>
<html lang="en">

<head>
    <title>Grader</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet' />
    <link rel="stylesheet" href="../style2.css" />
</head>

<style>
    .detail {
        padding: .7vw;
        background-color: #F6F5FF;
    }

    .col #sql_code {
        width: 100%;
        height: 20vw;
        resize: none;
        box-sizing: border-box;
    }
</style>

<body>
    <?php
    session_start();
    include_once "../dbconnect.php";

    if (isset($_SESSION['userid'])) {
        if ($_SESSION['level'] == 2) {
            $type_sql = "SELECT * FROM type";
            $type_query = $conn->query($type_sql);
        } else {
            header('location: ../system/logout_system.php');
        }
    } else {
        header('location: ../system/logout_system.php');
    }
    ?>

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
                <li class="nav-link">
                    <a href="home.php">
                        <i class='bx bx-home icon'></i>
                        <span class="text nav-text">หน้าหลัก</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="profile.php">
                        <i class='bx bxs-user icon'></i>
                        <span class="text nav-text">โปรไฟล์</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="sum-student-score.php">
                        <i class="bx bx-history icon"></i>
                        <span class="text nav-text">คะแนนรวม</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="about-us.php">
                        <i class="bi bi-people-fill icon"></i>
                        <span class="text nav-text">เกี่ยวกับเรา</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="contact.php">
                        <i class="bx bxs-contact icon"></i>
                        <span class="text nav-text">ติดต่อเรา</span>
                    </a>
                </li>
            </div>
            <div class="bottom-content">
                <li class="">
                    <a href="../system/logout_system.php" id="logout-button">
                        <i class="bx bx-log-out icon"></i>
                        <span class="text nav-text">ล็อคเอาท์</span>
                    </a>
                </li>

                <li class="mode">
                    <div class="moon-sun">
                        <i class="bx bx-moon icon moon"></i>
                        <i class="bx bx-sun icon sun"></i>
                    </div>
                    <span class="mode-text text">โหมดมืด</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
            </div>
        </div>
    </nav>

    <section class="home">
        <div class="text">
            <div class="div-text">
                <div class="container">
                    <form action="system/create-quiz-system.php" class="p-2" method="post" id="createQuizForm">
                        <div class="text-center">
                            <h3 class="fw-bold">สร้างโจทย์ปัญหา</h3>
                            <hr>
                        </div>

                        <div class="detail rounded">
                            <div class="row mb-2">
                                <div class="col">
                                    <label for="request" class="form-label fw-bold">โจทย์ปัญหากำหนดให้</label>
                                    <input type="text" class="form-control form-control-sm" name="request" id="request"
                                        placeholder="กรุณากำหนดโจทย์ปัญหาของคุณ">
                                </div>

                                <div class="col-auto">
                                    <label for="type_id" class="form-label fw-bold">เลือกประเภทโจทย์ปัญหา</label>
                                    <select name="type_id" id="type_id" class="form-select form-select-sm" required>
                                        <option value="">กรุณาเลือกประเภทโจทย์ปัญหา</option>
                                        <?php
                                        while ($type_row = $type_query->fetch_assoc()):
                                            ?>

                                            <option value="<?php echo $type_row['typeID']; ?>">
                                                <?php echo $type_row['type']; ?>
                                            </option>

                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col">
                                    <label for="sql" class="form-label fw-bold">Code SQL ที่เป็นคำตอบ</label>
                                    <textarea name="sql_code" id="sql_code" class="form-control form-control-sm"
                                        required></textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary fw-bold w-100">สร้างโจทย์ปัญหา</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="../change-mode.js?"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('#createQuizForm').submit(function (e) {
                e.preventDefault()
                let formUrl = $(this).attr('action');
                let reqMethod = $(this).attr('method');
                let formData = $(this).serialize();

                $.ajax({
                    url: formUrl,
                    type: reqMethod,
                    data: formData,
                    success: function (data) {
                        let jsonData = JSON.parse(data);

                        if (jsonData.status == "success") {
                            Swal.fire({
                                icon: "success",
                                title: "สำเร็จ",
                                text: jsonData.msg,
                                showConfirmButton: false,
                                timer: 1200
                            }).then(function () {
                                window.location.href = "view-quiz.php";
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "ล้มเหลว",
                                text: jsonData.msg,
                                showConfirmButton: false,
                                timer: 1200
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>