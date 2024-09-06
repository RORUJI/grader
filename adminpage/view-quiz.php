<?php
session_start();

include_once "../dbconnect.php";

if ($_SESSION['level'] != 2) {
    header("location: ../index.php");
} else {
    $sql = "SELECT * FROM quiz INNER JOIN type ON quiz.typeid = type.typeid";
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
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
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
                    <li class="nav-link">
                        <a href="../history.php">
                            <i class='bx bx-history icon'></i>
                            <span class="text nav-text">History</span>
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
                <div class="div-text p-3">
                    <div class="table-responsive">
                        <table class="table" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ชื่อโจทย์ปัญหา</th>
                                    <th scope="col">ประเภท</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $query->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['quizid']; ?></td>
                                        <td><?php echo $row['quiz']; ?></td>
                                        <td><?php echo $row['type']; ?></td>
                                        <td>
                                            <a href="read-quiz.php?quizId=<?php echo $row['quizid']; ?>"
                                                class="btn btn-primary btn-sm">
                                                Read
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <script src="../change-mode.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
        <script>
            let table = new DataTable('#dataTable');
        </script>
    </body>

    </html>

<?php } ?>