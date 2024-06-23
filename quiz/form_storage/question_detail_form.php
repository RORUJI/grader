<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="system_storage/resultcheck.php" method="post" id="insert-form" class="w-100">
        <input type="hidden" name="quizid" value="<?php echo $_POST['quizid']; ?>">
        <input type="hidden" name="table" value="<?php echo $_POST['table']; ?>">
        <input type="hidden" name="type" id="type" value=<?php echo $_POST['type']; ?>>
        <div class="row px-2 mb-3">
            <div class="col p-2 me-3 type-select rounded">
                <label for="select-SQL-code" class="form-label fw-bold">CODE</label>
                <?php if (isset($_POST['code'])): ?>
                    <textarea name="code" class="form-control" cols="30"
                        rows="10"><?php echo $_POST['code']; ?></textarea>
                <?php endif; ?>
                <?php if (!isset($_POST['code'])): ?>
                    <textarea name="code" class="form-control bg-body" cols="30"
                        rows="10">NOT SELECT SQL CODE.</textarea>
                <?php endif; ?>
            </div>
        </div>
        <button type="submit" id="btn-create" class="btn btn-primary">สร้างโจทย์</button>
        <button type="button" id="btn-return" class="btn btn-danger">ย้อนกลับ</button>
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