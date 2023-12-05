<?php
    session_start();

    include_once 'dbconnect.php';

    if (!isset($_SESSION['userID'])) {
        header('location: login.php');
    } else {
        $count = 1;
        $userID = $_SESSION['userID'];
        $sql = "SELECT * FROM score JOIN question ON score.questionID = question.questionID WHERE userID = '$userID'";
        $result = mysqli_query($conn, $sql);
    }
?>

<!DOCTYPE html>
<html class="bg-primary" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <title>Grader</title>
</head>

<body class="bg-primary">
    <nav class="navbar navbar-expand-lg bg-body">
        <div class="container">
            <a class="navbar-brand" href="home.php">
                <h2 class="text-primary fw-bold">G r a d e r</h2>
            </a>
            <div class="justify-content-end align-items-center">
                <?php if (!isset($_SESSION['levelID'])): ?>
                    <a href="login.php" class="btn btn-primary ms-3">Login</a>
                <?php endif; ?>
                <?php if (isset($_SESSION['levelID'])): ?>
                    <span class="text-primary fw-bold"><i class="bi bi-person-fill"></i> Username:&nbsp;</span>
                    <span>
                        <?php echo $_SESSION['username']; ?>
                    </span>
                    <a href="system/logout_system.php" id="signout-btn" class="btn btn-danger ms-3">
                        <i class="bi bi-door-closed-fill"></i> Logout</a>
                <?php endif; ?>
                <button type="button" class="btn btn-danger" id="btnBack">Back</button>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-center text-light my-3">
            <h2>คะแนนของคุณ</h2>
        </div>
        <table class="table table-striped table-bordered shadow-lg">
            <thead>
                <tr>
                    <th scope="row">#</th>
                    <th scope="row">แบบทดสอบ</th>
                    <th scope="row">คะแนน</th>
                    <th scope="row">รีเซ็ตคะแนน</th>
                </tr>
            </thead>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tbody>
                    <tr>
                        <td>
                            <?php echo $count++; ?>
                        </td>
                        <td>
                            <?php echo $row['question']; ?>
                        </td>
                        <td>
                            <?php echo $row['score']; ?>/1
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger"
                                onclick="resetScore(<?php echo $row['scoreID']; ?>)">รีเซ็ตคะแนน</button>
                        </td>
                    </tr>
                </tbody>
            <?php endwhile; ?>
        </table>

        <div class="d-flex justify-content-center text-light my-3">
            <h2>แบบฝึกหัดทั้งหมด</h2>
        </div>

        <?php
            $count = 1;
            $sql = "SELECT * FROM question";
            $result = mysqli_query($conn, $sql);
        ?>

        <table class="table table-striped table-bordered shadow-lg">
            <tr>
                <th scope="row">#</th>
                <th scope="row">แบบทดสอบ</th>
                <th scope="row"></th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td>
                        <?php echo $count++; ?>
                    </td>
                    <td>
                        <?php echo $row['question']; ?>
                    </td>
                    <td>
                        <a href="grader_question.php?questionID=<?php echo $row['questionID']; ?>"
                            class="btn btn-success">ทำแบบทดสอบ</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('#btnBack').click(function () {
                history.back();
            });
        });

        function resetScore(scoreID) {
            $(document).ready(function () {
                Swal.fire({
                    icon: 'info',
                    title: 'คุณต้องการรีเซ็ตคะแนนหรือไม่?',
                    text: 'หากคุณรีเซ็ต คะแนนของแบบทดสอบนี้จะหายไป!',
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'รีเซ็ต',
                    cancelButtonText: 'ไม่ล่ะ',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: 'system/reset_score.php',
                            data: {
                                scoreID: scoreID
                            },
                            success: function (data) {
                                result = JSON.parse(data);
                                if (result.status == 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'สำเร็จ!',
                                        text: result.msg,
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(function() {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: score.status,
                                        title: 'ล้มเหลว!',
                                        text: score.msg,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                            }
                        })
                    }
                })
            });
        }
    </script>
</body>

</html>