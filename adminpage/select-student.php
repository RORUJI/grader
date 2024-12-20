<?php
session_start();
include_once "../dbconnect.php";

if (!isset($_SESSION['userid']) && $_SESSION['level'] != 2) {
    header("Location: ../system/logout_system.php");
} else if (!isset($_GET['quizId'])) {
    header("Location: view-quiz.php");
} else {
    $quizId = $_GET['quizId'];
    $sqlUser = "SELECT * FROM user INNER JOIN level ON user.levelID = level.levelID WHERE user.levelID = 1 ORDER BY userid";
    $queryUser = $conn->query($sqlUser);
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
        <title>เลือกนักเรียน</title>
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
            <form action="system/insert_student_system.php" method="POST" class="p-2" id="insertStudentForm">
                <input type="hidden" name="quizId" value="<?php echo $quizId; ?>">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col">เลือกนักเรียน</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($rowUser = $queryUser->fetch_assoc()): ?>
                                <tr>
                                    <td scope="row">
                                        <?php echo $rowUser['userid']; ?>
                                    </td>
                                    <td scope="row">
                                        <?php echo $rowUser['username']; ?>
                                    </td>
                                    <td scope="row">
                                        <?php echo $rowUser['email']; ?>
                                    </td>
                                    <td scope="row">
                                        <?php echo $rowUser['levelname']; ?>
                                    </td>
                                    <td scope="row">
                                        <input type="checkbox" class="form-check-input" name="userId[]"
                                            data-id="<?php echo $rowUser['userid']; ?>"
                                            value="<?php echo $rowUser['userid']; ?>">
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td scope="row"></td>
                                <td scope="row"></td>
                                <td scope="row"></td>
                                <td scope="row"></td>
                                <td scope="row">
                                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </form>
        </div>
                </div>
            </div>
        </section>

        <script src="../change-mode.js?"></script>

        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {
                var quizId = "<?php echo $_GET['quizId']; ?>";

                $.ajax({
                    url: 'system/check_disabled.php',
                    type: 'POST',
                    data: {
                        quizId: quizId
                    },
                    dataType: 'json',
                    success: function(disabledItems) {
                        $('.form-check-input').each(function() {
                            var checkboxId = $(this).data('id');
                            if (disabledItems.includes(checkboxId)) {
                                $(this).prop('disabled', true);
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });

                $('#insertStudentForm').submit(function(e) {
                    e.preventDefault();
                    let formUrl = $(this).attr('action');
                    let reqMethod = $(this).attr('method');
                    let formData = $(this).serialize();

                    $.ajax({
                        type: reqMethod,
                        url: formUrl,
                        data: formData,
                        success: function(data) {
                            let results = JSON.parse(data);

                            if (results.status == "success") {
                                Swal.fire({
                                    icon: results.status,
                                    title: results.title,
                                    text: results.text,
                                    showConfirmButton: false,
                                    timer: 1000
                                }).then(function() {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: results.status,
                                    title: results.title,
                                    text: results.text,
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                            }
                        }
                    });
                });
            });
        </script>
    </body>

    </html>

<?php } ?>