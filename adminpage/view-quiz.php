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
        <title>Grader</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
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
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
        <script>
            let myDataTable = new DataTable('#myDataTable');
        </script>

    </body>

    </html>

<?php } ?>