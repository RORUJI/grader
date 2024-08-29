<?php
include_once "../../dbconnect.php";

$sql = "SELECT * FROM quiz";
$results = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="system_storage/resultcheck.php" method="post" class="col p-2 mx-2 rounded type-select"
        id="insert-form">
        <input type="hidden" name="quizid" value="<?php echo $_POST['quizid']; ?>">
        <input type="hidden" name="table" value="<?php echo $_POST['table']; ?>">
        <input type="hidden" name="type" id="type" value=<?php echo $_POST['type']; ?>>
        <div class="mb">
            <label for="select-SQL-code" class="form-label fw-bold">CODE</label>
            <?php if (isset($_POST['code'])): ?>
                <textarea name="code" class="form-control form-control-sm" cols="30"
                    rows="10"><?php echo $_POST['code']; ?></textarea>
            <?php endif; ?>
            <?php if (!isset($_POST['code'])): ?>
                <textarea name="code" class="form-control form-control-sm bg-body" cols="30"
                    rows="10">NOT SELECT SQL CODE.</textarea>
            <?php endif; ?>
        </div>
        <div class="row p-2">
            <div class="col p-2 rounded type-select">
                <?php if ($_POST['quizid'] > 1): ?>
                    <a href="quiz.php?quizid=<?php echo $quizid - 1; ?>" class="btn btn-danger btn-sm w-100" id="back-btn">
                        <--Back--- </a>
                        <?php endif; ?>
            </div>
            <div class="col p-2 mx-2 rounded type-select">
                <button type="submit" class="btn btn-primary btn-sm w-100" id="submit-btn">Submit</button>
            </div>
            <div class="col p-2 rounded type-select">
                <?php if ($_POST['quizid'] < $results->num_rows): ?>
                    <a href="quiz.php?quizid=<?php echo $_POST['quizid'] + 1; ?>" class="btn btn-success btn-sm w-100"
                        id="next-btn">
                        ---Next--> </a>
                <?php endif; ?>
            </div>
        </div>
    </form>
</body>

</html>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function () {
        $('#insert-form').submit(function (e) {
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

                    if (result.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ!',
                            text: result.msg,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function () {
                            $.ajax({
                                type: 'POST',
                                url: 'system_storage/enterscore.php',
                                data: {
                                    score: result.score,
                                    userid: result.userid,
                                    quizid: result.quizid
                                },
                                success: function (data) {
                                    window.location.reload();
                                }
                            })
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