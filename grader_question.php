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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css?v<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <i class="bi bi-door-closed-fill"></i>Logout</a>
                <?php endif; ?>
                <button type="button" class="btn btn-danger" id="btnBack">Back</button>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="position-absolute top-50 start-50 translate-middle">
            <form action="check_question.php" method="post"
                id="codeForm" class="bg-body rounded p-3 shadow-lg">
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
                                <a href="index.php"
                                    class="btn btn-danger w-100">หน้าหลัก</a>
                            <?php endif; ?>
                            <?php if ($_GET['questionID'] > 1): ?>
                                <a href="grader_question.php?questionID=<?php echo $_GET['questionID'] - 1; ?>"
                                    class="btn btn-danger w-100">ก่อนหน้า</a>
                            <?php endif; ?>
                        </div>
                        <div class="col-7">
                            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-send"></i> ส่งคำตอบ</button>
                        </div>
                        <div class="col">
                            <?php if ($_GET['questionID'] < mysqli_num_rows($result)): ?>
                                <a href="grader_question.php?questionID=<?php echo $_GET['questionID'] + 1; ?>"
                                    class="btn btn-success w-100">ต่อไป</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#btnBack').click(function () {
                history.back();
            });
        });

        $(document).ready(function () {
            $('#codeForm').submit(function (e) {
                e.preventDefault();
                let formUrl = $(this).attr('action');
                let reqMethod = $(this).attr('method');
                let formData = $(this).serialize();

                $.ajax({
                    type: reqMethod,
                    url: formUrl,
                    data: formData,
                    success: function (data) {
                        let result = JSON.parse(data);

                        if (result.status == 'noscore_success') {
                            Swal.fire({
                                icon: 'success',
                                title: result.msg,
                                text: 'คุณต้องการบันทึกคะแนนของคุณหรือไม่?',
                                showConfirmButton: true,
                                showCancelButton: true,
                                confirmButtonText: 'บันทึก',
                                cancelButtonText: 'ไม่ล่ะ',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33'
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    let questionID = <?php echo $_GET['questionID']; ?>;

                                    $.ajax({
                                        type: 'POST',
                                        url: 'enter_score.php',
                                        data: {
                                            questionID: questionID
                                        },
                                        success: function (data) {
                                            let score = JSON.parse(data);

                                            if (score.status == 'success') {
                                                Swal.fire({
                                                    icon: score.status,
                                                    title: 'สำเร็จ!',
                                                    text: score.msg,
                                                    showConfirmButton: true,
                                                    showCancelButton: true,
                                                    confirmButtonText: 'ดูคะแนน',
                                                    cancelButtonText: 'ไว้ทีหลัง',
                                                    confirmButtonColor: '#3085d6',
                                                    cancelButtonColor: '#d33'
                                                }).then(function (result) {
                                                    if (result.isConfirmed) {
                                                        window.location.href = 'history.php';
                                                    } else {
                                                        window.location.reload();
                                                    }
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
                                } else {
                                    window.location.reload();
                                }
                            });
                        } else if (result.status == 'score_success') {
                            Swal.fire({
                                icon: 'success',
                                title: result.msg,
                                text: 'คุณมีคะแนนอยู่แล้ว',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else if (result.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: result.msg,
                                text: 'หากคุณต้องการบันทึกคะแนนของคุณ คุณต้องทำการ Login',
                                showConfirmButton: true,
                                showCancelButton: true,
                                confirmButtonText: 'ล็อคอิน',
                                cancelButtonText: 'ไม่ล่ะ',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33'
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    window.location.href = 'login.php';
                                } else {
                                    window.location.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'ล้มเหลว!',
                                text: result.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>