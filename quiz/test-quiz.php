<?php
session_start();
include_once "../dbconnect.php";

if (!isset($_SESSION['userid'])) {
    header("Location: ../system/logout_system.php");
} else if (!isset($_GET['quizId'])) {
    header("Location: ../index.php");
} else {
    $quizId = $_GET['quizId'];
    $sqlStudentCheck = "SELECT * FROM score WHERE userid = " . $_SESSION['userid'] . " AND quizid = $quizId LIMIT 1";
    $queryStudentCheck = $conn->query($sqlStudentCheck);

    if ($queryStudentCheck->num_rows != 1) {
        header("Location: ../all_quiz.php");
    } else {
        $sqlQuiz = "SELECT * FROM quiz WHERE quizid = $quizId";
        $queryQuiz = $conn->query($sqlQuiz);
        $resultQuiz = $queryQuiz->fetch_assoc();
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
                    <form action="system_storage/result_check_system.php" method="post" class="p-2" id="testQuizForm">
                        <input type="hidden" name="quizId" value="<?php echo $resultQuiz['quizid']; ?>">
                        <input type="hidden" name="typeId" value="<?php echo $resultQuiz['typeID']; ?>">
                        <div class="text-center">
                            <h3 class="fw-bold">แก้ไขโจทย์ปัญหา</h3>
                            <hr>
                        </div>

                        <div class="row mb-2">
                            <div class="col-auto">
                                <label for="" class="form-label">ข้อที่</label>
                                <span class="form-control form-control-sm">
                                <?php echo $resultQuiz['quizid']; ?>
                                </span>
                            </div>

                            <div class="col">
                                <label for="" class="form-label">โจทย์กำหนดให้</label>
                                <span class="form-control form-control-sm">
                                <?php echo $resultQuiz['quiz']; ?>
                                </span>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col">
                                <label for="" class="form-label">SQL CODE</label>
                                <textarea name="code" id="" class="form-control form-control-sm" cols="30" rows="10"></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                    </form>
                </div>

                <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    $(document).ready(function () {
                        $('#testQuizForm').submit(function (e) {
                            e.preventDefault();
                            let formUrl = $(this).attr('action');
                            let reqMethod = $(this).attr('method');
                            let formData = $(this).serialize();

                            $.ajax({
                                type: reqMethod,
                                url: formUrl,
                                data: formData,
                                success: function (data) {
                                    let jsonData = JSON.parse(data);

                                    if (jsonData.status == "success") {
                                        Swal.fire({
                                            icon: jsonData.status,
                                            title: jsonData.title,
                                            text: jsonData.text,
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'ดูคะแนน',
                                            showCancelButton: true,
                                            cancelButtonColor: '#d33',
                                            cancelButtonText: 'ภายหลัง'
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: jsonData.status,
                                            title: jsonData.title,
                                            text: jsonData.text
                                        });
                                    }
                                }
                            });
                        });
                    });
                </script>

            </body>

            </html>

    <?php }
}
?>