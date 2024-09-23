<?php
session_start();

include_once "../dbconnect.php";

if (!isset($_SESSION['userid']) && $_SESSION['level'] != 2) {
    header("Location: ../system/logout_system.php");
} else if (!isset($_GET['quizId'])) {
    header("Location: view-quiz.php");
} else {
    $quizId = $_GET['quizId'];
    $sqlQuiz = "SELECT * FROM quiz
                INNER JOIN type ON quiz.typeid = type.typeid
                WHERE quizid = $quizId";
    $queryQuiz = $conn->query($sqlQuiz);
    $resultQuiz = $queryQuiz->fetch_assoc();

    $sqlType = "SELECT * FROM type";
    $queryType = $conn->query($sqlType);
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
                <form action="system/edit_system.php" class="p-2" id="editQuizForm" method="POST">
                    <div class="text-center">
                        <h3 class="fw-bold">แก้ไขโจทย์ปัญหา</h3>
                        <hr>
                    </div>

                    <div class="row mb-2">
                        <div class="col-auto">
                            <label for="" class="form-label">ข้อที่</label>
                            <span class="form-control form-control-sm"><?php echo $quizId; ?></span>
                            <input type="hidden" name="quizId" id="quizId" value="<?php echo $quizId; ?>">
                        </div>

                        <div class="col">
                            <label for="" class="form-label">โจทย์ปัญหากำหนดให้</label>
                            <input type="text" name="quiz" id="quiz" class="form-control form-control-sm"
                                value="<?php echo $resultQuiz['quiz']; ?>">
                        </div>

                        <div class="col-auto">
                            <label for="" class="form-label">ประเภทของโจทย์ปัญหา</label>
                            <select name="type" id="type" class="form-select form-select-sm">
                                <?php
                                while ($resultType = $queryType->fetch_assoc()) {
                                    if ($resultType['typeID'] == $resultQuiz['typeID']) {
                                        ?>
                                        <option value="<?php echo $resultType['typeID']; ?>" selected>
                                        <?php echo $resultType['type']; ?>
                                        </option>
                                    <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo $resultType['typeID']; ?>">
                                        <?php echo $resultType['type']; ?>
                                        </option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col">
                            <label for="" class="form-label">โค้ดสำหรับคำตอบ</label>
                            <textarea name="answerCode" id="answerCode" class="form-control form-control-sm"
                                style="height: 12vw;"><?php echo $resultQuiz['answercode']; ?></textarea>
                        </div>

                        <div class="col">
                            <label for="" class="form-label">โค้ดสำหรับตรวจผลลัพธ์</label>
                            <textarea name="resultCode" id="resultCode" class="form-control form-control-sm"
                                style="height: 12vw;"><?php echo $resultQuiz['resultcode']; ?></textarea>
                        </div>

                        <div class="col">
                            <label for="" class="form-label">โค้ดสำหรับสร้างตารางข้อมูลชั่วคราว</label>
                            <textarea name="temptableCode" id="temptableCode" class="form-control form-control-sm"
                                style="height: 12vw;"><?php echo $resultQuiz['temptablecode']; ?></textarea>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-auto">
                            <a href="quiz-detail.php?quizId=<?php echo $quizId; ?>" class="btn btn-danger btn-sm">กลับ</a>
                            <button type="submit" class="btn btn-success btn-sm">แก้ไข</button>
                        </div>
                    </div>
                </form>
            </div>

            <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                $(document).ready(function () {
                    $('#editQuizForm').submit(function (e) {
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
                                        showConfirmButton: false,
                                        timer: 1000
                                    }).then(function () {
                                        window.location.href = "quiz-detail.php?quizId=<?php echo $quizId; ?>";
                                    });
                                } else {
                                    Swal.fire({
                                        icon: jsonData.status,
                                        title: jsonData.title,
                                        text: jsonData.text,
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