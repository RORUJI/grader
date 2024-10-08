<?php
session_start();

include_once 'dbconnect.php';

if (!isset($_SESSION['userid'])) {
    header('location: login.php');
} else {
    $sql = "SELECT * FROM score INNER JOIN quiz ON score.quizid = quiz.quizid WHERE userid = '$_SESSION[userid]'";
    $query = $conn->query($sql);
    ?>

    <!DOCTYPE html>
    <html class="bg-primary" lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style2.css?v<?php echo time(); ?>">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
                <div class="div-text p-3">
                    <h2>คะแนนของคุณ</h2>
                    <hr>
                    <table class="table table-bordered" id="myTable">
                        <thead>
                            <tr>
                                <th scope="row">#</th>
                                <th scope="row">Quiz</th>
                                <th scope="row">คะแนน</th>
                                <th scope="row">เวลาที่ส่ง</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $query->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['quizid']; ?></td>
                                    <td><?php echo $row['quiz']; ?></td>
                                    <td><?php echo $row['score']; ?>/2</td>
                                    <td><?php echo $row['record']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <?php
                                $sql = "SELECT sum(score) FROM score WHERE userid = '$_SESSION[userid]'";
                                $query = $conn->query($sql);
                                $yourscore = $query->fetch_assoc();

                                $sql = "SELECT count(*) FROM score WHERE userid = '$_SESSION[userid]'";
                                $query = $conn->query($sql);
                                $sumscore = $query->fetch_assoc();
                                ?>
                                <td>สรุป</td>
                                <td>คะแนนรวมทั้งหมด</td>
                                <td><?php echo $yourscore['sum(score)']; ?>/<?php echo $sumscore['count(*)'] * 2; ?></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>

        </section>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
        <script src="change-mode.js?"></script>
        <script>
            let table = new DataTable('#myTable');
        </script>

    </body>

    </html>
<?php } ?>