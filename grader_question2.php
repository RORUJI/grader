<?php
    session_start();

    include_once('dbconnect.php');

    if (!isset($_GET['questionID'])) {
        header('location: index.php');
    } else {
        $sql = "SELECT * FROM question INNER JOIN type ON question.typeID = type.typeID WHERE questionID = " . $_GET['questionID'] . "";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $sql = "SELECT * FROM question";
        $result = mysqli_query($conn, $sql);
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css?v<?php echo time(); ?>">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                        <?php if (!isset($_SESSION['userID'])) : ?>
                            Guest
                        <?php endif; ?>
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
            <div class="div-text"><br>
            <div class="div-grader">
            <form action="quiz/examine_result.php" method="post"
                id="codeForm" class="">
                <input type="hidden" name="questionID" value="<?php echo $row['questionID']; ?>">
                <h2 class="fw-bold text-center">Insert Code</h2>
                <hr>
                <div class="mb-3">
                    <label for="code" class="form-label fw-bold">Question</label>
                    <span class="form-control">
                        <?php echo $row['question']; ?>
                    </span>
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>
                    <span class="form-control">
                        <input type="hidden" name="type" value="<?php echo $row['typeID']; ?>">
                        <?php echo $row['type']; ?>
                    </span>
                </div>
                <div class="mb-3">
                    <label for="code" class="form-label fw-bold">Insert Your Code</label>
                    <textarea name="sqlCode" id="sqlCode" class="form-control" cols="30" rows="10"></textarea>
                </div>
                <div class="mb-1">
                    <div class="row">
                        <div class="col">
                            <?php if ($_GET['questionID'] == 1): ?>
                                <a href="index2.php"
                                    class="btn btn-danger w-100">หน้าหลัก</a>
                            <?php endif; ?>
                            <?php if ($_GET['questionID'] > 1): ?>
                                <a href="grader_question2.php?questionID=<?php echo $_GET['questionID'] - 1; ?>"
                                    class="btn btn-danger w-100">ก่อนหน้า</a>
                            <?php endif; ?>
                        </div>
                        <div class="col-7">
                            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-send"></i> ส่งคำตอบ</button>
                        </div>
                        <div class="col">
                            <?php if ($_GET['questionID'] < mysqli_num_rows($result)): ?>
                                <a href="grader_question2.php?questionID=<?php echo $_GET['questionID'] + 1; ?>"
                                    class="btn btn-success w-100">ต่อไป</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </form>
            </div>
            </div>
        </div>
    </section>

    <script src="scipt.js"></script>
</body>

</html>