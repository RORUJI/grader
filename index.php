<?php
session_start();

include_once "dbconnect.php";

if (!isset($_SESSION['userid'])) {

    header('location: login2.php');

} else {

    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style2.css?v<?php echo time(); ?>">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <title>Grader</title>
    </head>

    <body>
        <nav class="sidebar">
            <header>
                <div class="image-text">
                    <span class="image">
                        <img src="User.jpg" alt="">
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
                        <a href="index.php">
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
                        <a href="system/logout_system.php" id="logout-button">
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
                    <div class="timeline">
                        <div class="text-center">
                            <?php
                            $sql = "SELECT * FROM score INNER JOIN user ON score.userid = user.userid INNER JOIN quiz ON
                            score.quizid = quiz.quizid ORDER BY record DESC LIMIT 2";
                            $query = $conn->query($sql);
                            while ($row = $query->fetch_assoc()) {
                                echo "<h2>{$row['username']} ข้อที่ทำล่าสุด {$row['quizid']} เวลา {$row['record']}</h2>";
                            }
                            ?>
                        </div>
                    </div><br>
                    <div class="div-graph">
                        <div class="col-8 Column1">
                            <div class="H">
                                <h1 class="fw-bold text-center">จัดอันดับ</h1>
                                <?php
                                $count = 1;
                                $sql = "SELECT username, SUM(score) FROM score INNER JOIN user ON score.userid = user.userid
                                    GROUP BY score.userid ORDER BY SUM(score) DESC";
                                $query = $conn->query($sql);
                                while ($row = $query->fetch_assoc()) {
                                    echo "<h1>$count. {$row['username']} คะแนนรวม {$row['SUM(score)']}</h1>";
                                    $count++;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-4 Column2">
                            <a href="all_quiz.php">
                                <div class="Column3 text-center">แบบฝึกหัด<br>SQL</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="change-mode.js?"></script>
    </body>

    </html>

<?php } ?>