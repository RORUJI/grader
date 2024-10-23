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
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
        <title>Grader</title>
    </head>

    <style>
        * {
            font-family: "Poppins", sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .detail {
            padding: .7vw;
            background-color: #F6F5FF;
        }

        .code-field {
            height: 12vw;
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
                        <h3 class="fw-bold">รายละเอียดของโจทย์ปัญหา</h3>
                        <hr>
                        <div class="detail rounded">
                            <div class="row mb-3">
                                <div class="col-auto">
                                    <label for="" class="form-label fw-bold">ข้อ</label>
                                    <span class="form-control form-control-sm" style="width: 4vw;">
                                        <?php echo $resultQuiz['quizid']; ?>
                                    </span>
                                </div>

                                <div class="col">
                                    <label for="" class="form-label fw-bold">โจทย์ปัญหา</label>
                                    <span class="form-control form-control-sm">
                                        <?php echo $resultQuiz['quiz']; ?>
                                    </span>
                                </div>

                                <div class="col-auto">
                                    <label for="" class="form-label fw-bold">ประเภท</label>
                                    <span class="form-control form-control-sm">
                                        <?php echo $resultQuiz['type']; ?>
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="" class="form-label fw-bold">Code คำตอบ</label>
                                    <span class="form-control form-control-sm code-field">
                                        <?php echo $resultQuiz['answercode']; ?>
                                    </span>
                                </div>

                                <div class="col">
                                    <label for="" class="form-label fw-bold">Code ตรวจผลลัพธ์</label>
                                    <span class="form-control form-control-sm code-field">
                                        <?php echo $resultQuiz['resultcode']; ?>
                                    </span>
                                </div>

                                <div class="col">
                                    <label for="" class="form-label fw-bold">Code ที่ใช้สร้างตารางชั่วคราว</label>
                                    <span class="form-control form-control-sm code-field">
                                        <?php echo $resultQuiz['temptablecode']; ?>
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-auto">
                                    <a href="view-quiz.php" class="btn btn-sm btn-danger">กลับ</a>
                                    <a href="edit-quiz.php?quizId=<?php echo $resultQuiz['quizid']; ?>" class="btn btn-sm btn-success">
                                        แก้ไข
                                    </a>
                                    <a href="view-quiz-score.php?quizId=<?php echo $resultQuiz['quizid']; ?>"
                                        class="btn btn-sm btn-info">ดูคะแนน</a>
                                    <a href="select-student.php?quizId=<?php echo $resultQuiz['quizid']; ?>"
                                        class="btn btn-sm btn-primary">
                                        กำหนดนักเรียน
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <script src="../change-mode.js?"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    </body>

    </html>

<?php } ?>