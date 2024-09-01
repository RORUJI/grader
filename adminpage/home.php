<?php
session_start();
if (!isset($_SESSION['userid']) && !isset($_SESSION['username']) && !isset($_SESSION['level'])) {
    header('location: ../index.php');
} else {
    if ($_SESSION['level'] != 2) {
        header('location: ../index.php');
    } else {
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
                            <a href="#">
                                <i class='bx bxs-user icon'></i>
                                <span class="text nav-text">Profile</span>
                            </a>
                        </li>
                    </div>
                    <div class="bottom-content">
                        <li class="">
                            <a href="../system/logout_system.php" id="logout-button">
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
                    <div class="div-text"><br>
                        <div class="timeline">TimeLine</div><br>
                        <div class="div-graph">
                            <div class="col-8 Column1">
                                Ranking
                            </div>
                            <div class="col-4 Column2">
                                <a href="../generator/generator.php">
                                    <div class="Column3">Quiz<br>Generator</div>
                                </a>
                                <a href="view-member.php">
                                    <div class="Column4">View<br>Member</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <script src="../scipt.js"></script>
        </body>

        </html>

    <?php }
} ?>