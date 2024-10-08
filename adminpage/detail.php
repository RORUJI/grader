<?php
session_start();

include_once "../dbconnect.php";

if ($_SESSION['level'] != 2) {
    header("location: ../index.php");
} else if (!isset($_GET['quizId'])) {
    header("location: view-quiz.php");
} else {
    $quizId = $_GET['quizId'];
    $sql = "SELECT * FROM user INNER JOIN level ON user.levelid = level.levelid WHERE user.levelid = '1'";
    $query = $conn->query($sql);

    $sqlQuiz = "SELECT * FROM quiz INNER JOIN type ON quiz.typeid = type.typeid WHERE quizid = '$quizId' LIMIT 1";
    $queryQuiz = $conn->query($sqlQuiz);
    $resultQuiz = $queryQuiz->fetch_assoc();
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
                    <div class="div-text p-2">
                        <div class="quiz-detail p-2">
                            <div class="row mb-2">
                                <div class="col-auto rounded-4 p-2 type-select mx-2">
                                    <label for="" class="form-label">ข้อที่</label>
                                    <span class="form-control form-control-sm">
                                    <?php echo $resultQuiz['quizid']; ?>
                                    </span>
                                </div>

                                <div class="col rounded-4 p-2 type-select mx-2">
                                    <label for="" class="form-label">สิ่งที่โจทย์ปัญหาต้องการ</label>
                                    <span class="form-control form-control-sm">
                                    <?php echo $resultQuiz['quiz']; ?>
                                    </span>
                                </div>

                                <div class="col-auto rounded-4 p-2 type-select mx-2">
                                    <label for="" class="form-label">ประเภทของโจทย์ปัญหา</label>
                                    <span class="form-control form-control-sm">
                                    <?php echo $resultQuiz['type']; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive p-2">
                            <form action="system/insert_student.php" method="post" id="insertStudentForm">
                                <input type="hidden" name="quizId" value="<?php echo $_GET['quizId']; ?>">
                                <table class="table" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Status</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        while ($row = $query->fetch_assoc()):
                                            ?>
                                            <tr>
                                                <td scope="row">
                                                <?php echo $count++; ?>
                                                </td>
                                                <td scope="row">
                                                <?php echo $row['email']; ?>
                                                </td>
                                                <td scope="row">
                                                <?php echo $row['username']; ?>
                                                </td>
                                                <td scope="row">
                                                <?php echo $row['levelname']; ?>
                                                </td>
                                                <td scope="row">
                                                    <input type="checkbox" class="form-check-input" name="userId[]"
                                                        data-id="<?php echo $row['userid']; ?>"
                                                        value="<?php echo $row['userid']; ?>">
                                                </td>
                                            </tr>
                                    <?php endwhile; ?>
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-primary btn-sm float-end">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            <script src="../change-mode.js"></script>
            <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
            <script>
                let table = new DataTable('#dataTable');

                $(document).ready(function () {
                    var quizId = "<?php echo $_GET['quizId']; ?>";

                    $.ajax({
                        url: 'system/check_disabled.php',
                        type: 'POST',
                        data: { quizId: quizId },
                        dataType: 'json',
                        success: function (disabledItems) {
                            $('.form-check-input').each(function () {
                                var checkboxId = $(this).data('id');
                                if (disabledItems.includes(checkboxId)) {
                                    $(this).prop('disabled', true);
                                }
                            });
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX Error:', status, error);
                        }
                    });

                    $('#insertStudentForm').submit(function (e) {
                        e.preventDefault();
                        let formUrl = $(this).attr('action');
                        let reqMethod = $(this).attr('method');
                        let formData = $(this).serialize();

                        $.ajax({
                            type: reqMethod,
                            url: formUrl,
                            data: formData,
                            success: function (data) {
                                let results = JSON.parse(data);

                                if (results.status == "success") {
                                    Swal.fire({
                                        icon: results.status,
                                        title: results.title,
                                        text: results.text,
                                        showConfirmButton: false,
                                        timer: 1000
                                    }).then(function () {
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