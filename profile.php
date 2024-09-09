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
                    <li class="search-box">
                        <i class='bx bx-search icon'></i>
                        <input type="search" placeholder="Search...">
                    </li>
                    <li class="nav-link">
                        <a href="index.php">
                            <i class='bx bx-home icon'></i>
                            <span class="text nav-text">Home</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="profile.php">
                            <i class='bx bxs-user icon'></i>
                            <span class="text nav-text">Profile</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="history.php">
                            <i class='bx bx-history icon'></i>
                            <span class="text nav-text">History</span>
                        </a>
                    </li>
                </div>
                <div class="bottom-content">
                    <li class="">
                        <a href="system/logout_system.php" id="logout-button">
                            <i class="bx bx-log-out icon"></i>
                            <span class="text nav-text">Logout</span>
                        </a>
                    </li>

                    <li class="mode">
                        <div class="moon-sun">
                            <i class="bx bx-moon icon moon"></i>
                            <i class="bx bx-sun icon sun"></i>
                        </div>
                        <span class="mode-text text">Dark Mode</span>

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
                    <div class="rounded-5 type-select text-center p-2 w-50">
                        <h2 class="fw-bold">Profile</h2>
                        <hr>
                        <div class="rounded p-2 text-start">
                            <div class="input-group input-group-sm mb-3">
                                <label for="username" class="input-group-text" style="width: 9vw; font-size: 1vw;">Username</label>
                                <span class="form-control form-control-sm"><?php echo $result['username']; ?></span>
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <label for="email" class="input-group-text" style="width: 9vw; font-size: 1vw;">Email</label>
                                <span class="form-control form-control-sm"><?php echo $result['email']; ?></span>
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <label for="phoneNumber" class="input-group-text" style="width: 9vw; font-size: 1vw;">Phone Number</label>
                                <span class="form-control form-control-sm"><?php echo $result['tel']; ?></span>
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <label for="status" class="input-group-text" style="width: 9vw; font-size: 1vw;">Status</label>
                                <span class="form-control form-control-sm"><?php echo $result['levelname']; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
        </section>

        <script src="change-mode.js"></script>
    </body>

    </html>

<?php } ?>