<?php
session_start();
include_once "../dbconnect.php";

if (!isset($_SESSION['userid']) && $_SESSION['level'] != 2) {
    header("Location: ../system/logout_system.php");
} else if (!isset($_GET['quizId'])) {
    header("Location: view-quiz.php");
} else {
    $quizId = $_GET['quizId'];
    $sqlStudent = "SELECT * FROM score INNER JOIN user ON score.userid = user.userid WHERE quizid = $quizId";
    $queryStudent = $conn->query($sqlStudent);
    ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Grader</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        </head>

        <body>
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
                                    <th scope="col">คะแนน</th>
                                    <th scope="col">รายละเอียดนักเรียน</th>
                                    <th scope="col">ลบ</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php $count = 1;
                            while ($rowStudent = $queryStudent->fetch_assoc()): ?>
                                    <tr>
                                        <td scope="row">
                                        <?php echo $count; ?>
                                        </td>
                                        <td>
                                        <?php echo $rowStudent['username']; ?>
                                        </td>
                                        <td scope="row">
                                        <?php echo $rowStudent['email']; ?>
                                        </td>
                                        <td scope="row">
                                        <?php echo $rowStudent['score']; ?>/2
                                        </td>
                                        <td scope="row">
                                            <a href="view-student.php?userId=<?php echo $rowStudent['userid']; ?>"
                                                class="btn btn-sm btn-primary">รายละเอียด</a>
                                        </td>
                                        <td scope="row">
                                            <a href="delete_student-score_system.php?quizId=<?php echo $quizId; ?>"
                                                data-id="<?php echo $rowStudent['userid']; ?>"
                                                class="btn btn-sm btn-danger delete-btn">ลบ</a>
                                        </td>
                                    </tr>
                                <?php $count++;
                            endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                $('.delete-btn').click(function (e) {
                    var userId = $(this).data('id');
                    e.preventDefault();
                    deleteConfirm(userId);
                });

                function deleteConfirm(userId) {
                    Swal.fire({
                        icon: 'info',
                        title: 'แน่ใจหรือไม่',
                        text: 'คุณต้องการลบนักเรียนคนนี้หรือไม่',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'ใช่',
                        showCancelButton: true,
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'ไม่'
                    }).then(function (r) {
                        if (r.isConfirmed) {
                            $.ajax({
                                url: 'system/delete_student-score_system.php?quizId=<?php echo $quizId; ?>',
                                method: 'GET',
                                data: {
                                    userId: userId
                                },
                                success: function (data) {
                                    let jsonData = JSON.parse(data);

                                    if (jsonData.status == "success") {
                                        Swal.fire({
                                            icon: jsonData.status,
                                            title: jsonData.title,
                                            text: jsonData.text,
                                            showConfirmButton: false,
                                            timer: 1000
                                        }).then(() => {
                                            document.location.reload();
                                        });
                                    } else {

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