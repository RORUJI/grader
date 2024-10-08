<?php
session_start();
include_once "dbconnect.php";

if (!isset($_SESSION['userid'])) {

    header('location: login.php');

} else {

    $sql = "SELECT * FROM user INNER JOIN level ON user.levelid = level.levelid WHERE userid = '$_SESSION[userid]'";
    $query = $conn->query($sql);
    $result = $query->fetch_assoc();
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

    <style>
        .profile-field {
            height: 95%;
            width: 35vw;
            margin: 1vw;
            background: var(--sidebaer-color);
            border-radius: 28px;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }
    </style>

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
                <div class="profile-field row p-2">
                    <div class="col p-2 rounded-5 type-select text-center">
                        <h2 class="fw-bold">Profile</h2>
                        <hr>
                        <div class="rounded p-2 text-start">
                            <div class="mb-2">
                                <label for="username" class="form-label">Username</label>
                                <span class="form-control form-control-sm">
                                    <?php echo $result['username']; ?>
                                </span>
                            </div>

                            <div class="mb-2">
                                <label for="password" class="form-label">Password</label>
                                <span class="form-control form-control-sm">
                                    <?php
                                    for ($i = 0; $i < strlen($result['password']); $i++) {
                                        echo "*";
                                    }
                                    ?>
                                </span>
                            </div>

                            <div class="mb-2">
                                <label for="email" class="form-label">Email</label>
                                <span class="form-control form-control-sm">
                                    <?php echo $result['email']; ?>
                                </span>
                            </div>

                            <div class="mb-2">
                                <label for="tel" class="form-label">Telephone Number</label>
                                <span class="form-control form-control-sm">
                                    <?php
                                    $tel = substr_replace($result['tel'], '-', 3, 0);
                                    $tel = substr_replace($tel, '-', 7, 0);
                                    echo $tel;
                                    ?>
                                </span>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <span class="form-control form-control-sm">
                                    <?php echo $result['levelname']; ?>
                                </span>
                            </div>

                            <div class="mb-2">
                                <a href="edit-profile.php" class="btn btn-sm btn-success">Edit Profile</a>
                                <a href="change-password.php" class="btn btn-sm btn-danger">Change Password</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="change-mode.js?"></script>
    </body>

    </html>

<?php } ?>