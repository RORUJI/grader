<?php
session_start();
include_once "../dbconnect.php";

if (!isset($_SESSION['userid'])) {
    header("Location: ../system/logout_system.php");
} else if (!isset($_GET['quizId'])) {
    header("Location: ../index.php");
} else {
    $quizId = $_GET['quizId'];
    $sqlStudentCheck = "SELECT * FROM score WHERE userid = " . $_SESSION['userid'] . " AND quizid = $quizId LIMIT 1";
    $queryStudentCheck = $conn->query($sqlStudentCheck);

    if ($queryStudentCheck->num_rows != 1) {
        header("Location: ../all_quiz.php");
    } else {
        $sqlQuiz = "SELECT * FROM quiz WHERE quizid = $quizId";
        $queryQuiz = $conn->query($sqlQuiz);
        $resultQuiz = $queryQuiz->fetch_assoc();
        ?>

            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="../style2.css?v<?php echo time(); ?>">
                <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
                <title>แบบฝึกหัด</title>
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
                            <li class="nav-link">
                                <a href="../index.php">
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
                                <a href="history.php">
                                    <i class="bx bx-history icon"></i>
                                    <span class="text nav-text">คะแนนของคุณ</span>
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
                        <div class="div-text"><br>
                            <div class="container">
                            <form action="system_storage/result_check_system.php" method="post" class="p-2" id="testQuizForm">
                                <input type="hidden" name="quizId" value="<?php echo $resultQuiz['quizid']; ?>">
                                <input type="hidden" name="typeId" value="<?php echo $resultQuiz['typeID']; ?>">
                                <div class="text-center">
                                    <h3 class="fw-bold">แก้ไขโจทย์ปัญหา</h3>
                                    <hr>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-auto">
                                        <label for="" class="form-label">ข้อที่</label>
                                        <span class="form-control form-control-sm">
                                        <?php echo $resultQuiz['quizid']; ?>
                                        </span>
                                    </div>

                                    <div class="col">
                                        <label for="" class="form-label">โจทย์กำหนดให้</label>
                                        <span class="form-control form-control-sm">
                                        <?php echo $resultQuiz['quiz']; ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="" class="form-label">SQL CODE</label>
                                        <textarea name="code" id="" class="form-control form-control-sm" cols="30" rows="10"></textarea>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                            </form>
                            </div>
                        </div>
                    </div>

                <script src="../change-mode.js?"></script>

                <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    $(document).ready(function () {
                        $('#testQuizForm').submit(function (e) {
                            e.preventDefault();
                            let formUrl = $(this).attr('action');
                            let reqMethod = $(this).attr('method');
                            let formData = $(this).serialize();

                            $.ajax({
                                type: reqMethod,
                                url: formUrl,
                                data: formData,
                                success: function (data) {
                                    let jsonData = JSON.parse(data);

                                    if (jsonData.status == "success") {
                                        Swal.fire({
                                            icon: jsonData.status,
                                            title: jsonData.title,
                                            text: jsonData.text,
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'ดูคะแนน',
                                            showCancelButton: true,
                                            cancelButtonColor: '#d33',
                                            cancelButtonText: 'ภายหลัง'
                                        }).then(function(r) {
                                            if (r.isConfirmed) {
                                                window.location.href = "../history.php";
                                            }
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: jsonData.status,
                                            title: jsonData.title,
                                            text: jsonData.text
                                        });
                                    }
                                }
                            });
                        });
                    });
                </script>

            </body>

            </html>

    <?php }
}
?>