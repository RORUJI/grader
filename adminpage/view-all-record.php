<?php
session_start();
if (!isset($_SESSION['userid']) && !isset($_SESSION['username']) && !isset($_SESSION['level'])) {
    header('location: ../index.php');
} else {
    if ($_SESSION['level'] != 2) {
        header('location: ../index.php');
    } else {
        include_once "../dbconnect.php";
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
            .record-header {
                background: var(--primary-color-light);
                display: flex;
                justify-content: center;
                align-items: center;
                border-radius: 18px;
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
                        <div class="div-graph">
                            <div class="col me-2">
                                <div class="record-header p-2 mb-2">
                                    <h2>บันทึกการทำโจทย์</h2>
                                </div>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Username</th>
                                            <th scope="col">โจทย์ปัญหา</th>
                                            <th scope="col">ผลลัพธ์</th>
                                            <th scope="col">คำอธิบาย</th>
                                            <th scope="col">เวลาที่ทำ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM quiz_record INNER JOIN user ON quiz_record.userid = user.userid
                                                INNER JOIN quiz ON quiz_record.quizid = quiz.quizid ORDER BY created_at DESC";
                                        $query = $conn->query($sql);
                                        while ($row = $query->fetch_assoc()):
                                            ?>

                                            <tr>
                                                <td><?php echo $row['username']; ?></td>
                                                <td><?php echo $row['quiz']; ?></td>
                                                <td><?php echo $row['status']; ?></td>
                                                <td><?php echo $row['description']; ?></td>
                                                <td><?php echo $row['created_at']; ?></td>
                                            </tr>

                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <script src="../change-mode.js?"></script>

            <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

            <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>

            <script>
                let myDataTable = new DataTable('.table');
            </script>
        </body>

        </html>

    <?php }
} ?>