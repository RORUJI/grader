<?php
session_start();

include_once "../dbconnect.php";

if ($_SESSION['level'] != '2') {
    header("Location: ../system/logout_system.php");
} else {

    $sql = "SELECT COUNT(score), SUM(score), username, email FROM score INNER JOIN user ON score.userid = user.userid 
            INNER JOIN quiz ON score.quizid = quiz.quizid GROUP BY score.userid";
    $query = $conn->query($sql);

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
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">คะแนนรวม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    while ($row = $query->fetch_assoc()):
                                    ?>
                                        <tr>
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $row['username'] ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['SUM(score)'] . "/" . $row['COUNT(score)'] * 2; ?></td>
                                        </tr>
                                    <?php
                                        $count++;
                                    endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="../change-mode.js?"></script>

        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </body>

    </html>

<?php } ?>