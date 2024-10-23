<?php
session_start();

include_once "../dbconnect.php";

if (!isset($_SESSION['userid']) && $_SESSION['level'] != 2) {
    header("Location: ../system/logout_system.php");
} else {
    $sqlQuiz = "SELECT * FROM quiz INNER JOIN type ON quiz.typeid = type.typeid ORDER BY quizid ASC";
    $queryQuiz = $conn->query($sqlQuiz);
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
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
        <title>Grader</title>
    </head>

    <style>
        * {
            font-family: "Poppins", sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
    </style>

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
                        <div class="table-responsive">
                            <table class="table table-sm table-striped" id="myDataTable">
                                <thead>
                                    <tr>
                                        <th scope="col" style="text-align: center;">ข้อ</th>
                                        <th scope="col">โจทย์ปัญหา</th>
                                        <th scope="col" style="text-align: center;">ประเภท</th>
                                        <th scope="col" style="text-align: center;">รายละเอียด</th>
                                        <th scope="col" style="text-align: center;">กำหนดนักเรียน</th>
                                        <th scope="col" style="text-align: center;">ลบโจทย์</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($rowQuiz = $queryQuiz->fetch_assoc()): ?>
                                        <tr>
                                            <td scope="row" style="width: 3vw; text-align: center;">
                                                <?php echo $rowQuiz['quizid']; ?>
                                            </td>
                                            <td scope="row" style="width: 30vw;">
                                                <?php echo $rowQuiz['quiz']; ?>
                                            </td>
                                            <td scope="row" style="width: 3vw; text-align: center;">
                                                <?php echo $rowQuiz['type']; ?>
                                            </td>
                                            <td scope="row" style="width: 15vw; text-align: center;">
                                                <a href="quiz-detail.php?quizId=<?php echo $rowQuiz['quizid']; ?>"
                                                    class="btn btn-sm btn-primary">
                                                    รายละเอียด
                                                </a>
                                            </td>
                                            <td scope="row" style="width: 15vw; text-align: center;">
                                                <a href="select-student.php?quizId=<?php echo $rowQuiz['quizid']; ?>"
                                                    class="btn btn-sm btn-success">
                                                    กำหนดนักเรียน
                                                </a>
                                            </td>
                                            <td scope="row" style="width: 5vw; text-align: center;">
                                                <a data-id="<?php echo $rowQuiz['quizid']; ?>"
                                                    href="delete_quiz_system.php?quizId=<?php echo $rowQuiz['quizid']; ?>"
                                                    class="btn btn-sm btn-danger delete-btn">
                                                    ลบ
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="../change-mode.js?"></script>

        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            let myDataTable = new DataTable('#myDataTable');

            $('.delete-btn').click(function(e) {
                var quizId = $(this).data('id');
                e.preventDefault();
                deleteConfirm(quizId);
            });

            function deleteConfirm(quizId) {
                Swal.fire({
                    icon: 'info',
                    title: 'แน่ใจหรือไม่',
                    text: 'คุณต้องการลบโจทย์ข้อนี้หรือไม่',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ใช่',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'ไม่'
                }).then(function(r) {
                    if (r.isConfirmed) {
                        $.ajax({
                            url: 'system/check_quizInfo_system.php',
                            method: 'POST',
                            data: {
                                quizId: quizId
                            },
                            success: function(data) {
                                let result = JSON.parse(data);

                                if (result.status == "success") {
                                    $.ajax({
                                        url: 'system/delete_quiz_system.php',
                                        method: 'POST',
                                        data: {
                                            quizId: quizId
                                        },
                                        success: function(data) {
                                            let result = JSON.parse(data);

                                            if (result.status == "success") {
                                                Swal.fire({
                                                    icon: result.status,
                                                    title: result.title,
                                                    text: result.text,
                                                    showConfirmButton: false,
                                                    timer: 1000
                                                }).then(() => {
                                                    document.location.reload();
                                                });
                                            } else {
                                                Swal.fire({
                                                    icon: result.status,
                                                    title: result.title,
                                                    text: result.text,
                                                    showConfirmButton: false,
                                                    timer: 1000
                                                });
                                            }
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        icon: result.status,
                                        title: result.title,
                                        html: result.text,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'ใช่',
                                        showCancelButton: true,
                                        cancelButtonColor: '#d33',
                                        cancelButtonText: 'ไม่'
                                    }).then(function(r) {
                                        if (r.isConfirmed) {
                                            $.ajax({
                                                url: 'system/delete_quiz_system.php',
                                                method: 'POST',
                                                data: {
                                                    quizId: quizId
                                                },
                                                success: function(data) {
                                                    let result = JSON.parse(data);

                                                    if (result.status == "success") {
                                                        Swal.fire({
                                                            icon: result.status,
                                                            title: result.title,
                                                            text: result.text,
                                                            showConfirmButton: false,
                                                            timer: 1000
                                                        }).then(() => {
                                                            document.location.reload();
                                                        });
                                                    } else {
                                                        Swal.fire({
                                                            icon: result.status,
                                                            title: result.title,
                                                            text: result.text,
                                                            showConfirmButton: false,
                                                            timer: 1000
                                                        });
                                                    }
                                                }
                                            });
                                        } else {

                                        }
                                    });
                                }
                            }
                        });
                    } else {

                    }
                });
            }
        </script>

    </body>

    </html>

<?php } ?>