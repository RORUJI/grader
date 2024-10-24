<?php
session_start();
if (!isset($_SESSION['userid']) && !isset($_SESSION['username']) && !isset($_SESSION['level'])) {
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
                        <?php if ($_SESSION['level'] == 1): ?>
                            <a href="../history.php">
                                <i class="bx bx-history icon"></i>
                                <span class="text nav-text">คะแนนของคุณ</span>
                            </a>
                        <?php endif; ?>
                        <?php if ($_SESSION['level'] == 2): ?>
                            <a href="../adminpage/sum-student-score.php">
                                <i class="bx bx-history icon"></i>
                                <span class="text nav-text">คะแนนรวม</span>
                            </a>
                        <?php endif; ?>
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
                <div class="row div-text"><br>
                    <div class="col-3 div-graph mt-4">
                        <div class="Column2">
                            <a href="person_table.php">
                                <div class="ColumnA3 p-2 text-center">ตาราง Person</div>
                            </a>
                            <a href="gender_table.php">
                                <div class="ColumnA3 p-2 text-center">ตาราง Gender</div>
                            </a>
                        </div>
                    </div>
                    <div class="col-3 div-graph mt-4">
                        <div class="Column2">
                            <a href="manu_table.php">
                                <div class="ColumnA3 p-2 text-center">ตาราง Manu</div>
                            </a>
                            <a href="manu_category_table.php">
                                <div class="ColumnA3 p-2 text-center">ตาราง Manu Category</div>
                            </a>
                            <a href="manu_type_table.php">
                                <div class="ColumnA3 p-2 text-center">ตาราง Manu Type</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="../change-mode.js?"></script>
    </body>

    </html>

    <?php
} ?>