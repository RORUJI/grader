<?php
session_start();

include_once "../dbconnect.php";

if (!isset($_SESSION['userid']) && $_SESSION['level'] != 2) {
    header("Location: ../system/logout_system.php");
} else if (!isset($_GET['quizId'])) {
    header("Location: view-quiz.php");
} else {
    $quizId = $_GET['quizId'];
    $sqlQuiz = "SELECT * FROM quiz
                INNER JOIN type ON quiz.typeid = type.typeid
                WHERE quizid = $quizId";
    $queryQuiz = $conn->query($sqlQuiz);
    $resultQuiz = $queryQuiz->fetch_assoc();

    $sqlType = "SELECT * FROM type";
    $queryType = $conn->query($sqlType);
    ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../style2.css?v<?php echo time(); ?>">
            <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
            <title>Grader</title>
        </head>

        <style>
            .detail {
                padding: .7vw;
                background-color: #F6F5FF;
            }
        </style>

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
                    <div class="div-text"><br>
                        <div class="container">
                            <form action="system/edit_system.php" class="p-2" id="editQuizForm" method="POST">
                                <div class="text-center">
                                    <h3 class="fw-bold">แก้ไขโจทย์ปัญหา</h3>
                                    <hr>
                                </div>

                                <div class="detail rounded">
                                    <div class="row mb-2">
                                        <div class="col-auto">
                                            <label for="" class="form-label">ข้อที่</label>
                                            <span class="form-control form-control-sm"><?php echo $quizId; ?></span>
                                            <input type="hidden" name="quizId" id="quizId" value="<?php echo $quizId; ?>">
                                        </div>

                                        <div class="col">
                                            <label for="" class="form-label">โจทย์ปัญหากำหนดให้</label>
                                            <input type="text" name="quiz" id="quiz" class="form-control form-control-sm"
                                                value="<?php echo $resultQuiz['quiz']; ?>">
                                        </div>

                                        <div class="col-auto">
                                            <label for="" class="form-label">ประเภทของโจทย์ปัญหา</label>
                                            <select name="type" id="type" class="form-select form-select-sm">
                                                <?php
                                                while ($resultType = $queryType->fetch_assoc()) {
                                                    if ($resultType['typeID'] == $resultQuiz['typeID']) {
                                                        ?>
                                                        <option value="<?php echo $resultType['typeID']; ?>" selected>
                                                        <?php echo $resultType['type']; ?>
                                                        </option>
                                                    <?php
                                                    } else {
                                                        ?>
                                                        <option value="<?php echo $resultType['typeID']; ?>">
                                                        <?php echo $resultType['type']; ?>
                                                        </option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="" class="form-label">โค้ดสำหรับคำตอบ</label>
                                            <textarea name="answerCode" id="answerCode" class="form-control form-control-sm"
                                                style="height: 12vw;"><?php echo $resultQuiz['answercode']; ?></textarea>
                                        </div>

                                        <div class="col">
                                            <label for="" class="form-label">โค้ดสำหรับตรวจผลลัพธ์</label>
                                            <textarea name="resultCode" id="resultCode" class="form-control form-control-sm"
                                                style="height: 12vw;"><?php echo $resultQuiz['resultcode']; ?></textarea>
                                        </div>

                                        <div class="col">
                                            <label for="" class="form-label">โค้ดสำหรับสร้างตารางข้อมูลชั่วคราว</label>
                                            <textarea name="temptableCode" id="temptableCode"
                                                class="form-control form-control-sm"
                                                style="height: 12vw;"><?php echo $resultQuiz['temptablecode']; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-auto">
                                            <a href="quiz-detail.php?quizId=<?php echo $quizId; ?>"
                                                class="btn btn-danger btn-sm">กลับ</a>
                                            <button type="submit" class="btn btn-success btn-sm">แก้ไข</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            <script src="../change-mode.js?"></script>

            <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                $(document).ready(function () {
                    $('#editQuizForm').submit(function (e) {
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
                                        showConfirmButton: false,
                                        timer: 1000
                                    }).then(function () {
                                        window.location.href = "quiz-detail.php?quizId=<?php echo $quizId; ?>";
                                    });
                                } else {
                                    Swal.fire({
                                        icon: jsonData.status,
                                        title: jsonData.title,
                                        text: jsonData.text,
                                        showConfirmButton: false,
                                        timer: 1000
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