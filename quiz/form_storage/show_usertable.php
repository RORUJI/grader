<?php
session_start();
include_once ('../../dbconnect.php');
$usertable_code = $_SESSION[$_SESSION['username']];
$usertable = $_SESSION['usertable'];
$query = $conn->query($usertable_code);
$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'grader' AND TABLE_NAME = '$usertable'";
$tablehead = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style2.css?v<?php echo time(); ?>">
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
                        <?php if (!isset($_SESSION['userID'])): ?>
                            Guest
                        <?php endif; ?>
                    </span>
                    <span class="profession">Test</span>
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
                    <a href="index2.php">
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
                    <a href="login.php">
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
            <div class="div-text">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <?php while ($row = $tablehead->fetch_array()): ?>
                            <?php for ($i = 0; $i < $tablehead->field_count; $i++): ?>
                                <th scope="row"><?php echo $row[$i]; ?></th>
                            <?php endfor; ?>
                        <?php endwhile; ?>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $query->fetch_array()):
                            ?>
                            <tr>
                                <?php for ($i = 0; $i < $query->field_count; $i++): ?>
                                    <td scope="row"><?php echo $row[$i]; ?></td>
                                <?php endfor; ?>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <script src="../../scipt.js"></script>
</body>

</html>