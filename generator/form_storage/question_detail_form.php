<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="system_storage/insertion_question.php" method="post" id="insert-form" class="w-100">
        <input type="hidden" name="type" id="type" value=<?php echo $_POST['type']; ?>>
        <input type="hidden" name="quiz" value="<?php echo $_POST['question']; ?>">
        <div class="row p-2">
            <div class="col p-2 me-2 type-select rounded">
                <label for="question" class="form-label fw-bold">โจทย์ปัญหา</label>
                <span class="form-control form-control-sm">
                    <?php echo $_POST['question']; ?>
                </span>
            </div>
        </div>
        <div class="row p-2">
            <div class="col p-2 me-2 type-select rounded">
                <label for="answer-code" class="form-label fw-bold">ANSWER CODE</label>
                <textarea name="answercode" class="form-control" cols="30"
                    rows="10"><?php echo $_POST['answercode']; ?></textarea>
            </div>
            <div class="col p-2 me-2 type-select rounded">
                <label for="result-code" class="form-label fw-bold">RESULT CODE</label>
                <textarea name="resultcode" class="form-control" cols="30"
                    rows="10"><?php echo $_POST['resultcode']; ?></textarea>
            </div>
            <div class="col p-2 me-2 type-select rounded">
                <label for="temptable-code" class="form-label fw-bold">TEMPTABLE CODE</label>
                <textarea name="temptablecode" class="form-control" cols="30"
                    rows="10"><?php echo $_POST['temptablecode']; ?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col p-2 ms-2 me-3 type-select rounded">
                <button type="submit" id="btn-create" class="btn btn-primary btn-sm">สร้างโจทย์</button>
                <button type="button" id="btn-return" class="btn btn-danger btn-sm">ย้อนกลับ</button>
            </div>
        </div>
    </form>
</body>

</html>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function () {
        $('#btn-return').on('click', function (e) {
            window.location.reload();
        });
    });

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
                        }).then(function (r) {
                            window.location.reload();
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