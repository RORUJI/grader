<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="system/insert_question_system.php" method="post" id="insert-form" class="w-100">
        <input type="hidden" name="type" value="<?php echo $_POST['type']; ?>">
        <div class="row p-2">
            <div class="col p-2 bg-secondary-subtle rounded">
                <label for="question" class="form-label fw-bold">โจทย์ปัญหา</label>
                <input type="hidden" name="question" value="<?php echo $_POST['question']; ?>">
                <span class="form-control">
                    <?php echo $_POST['question']; ?>
                </span>
            </div>
        </div>
        <div class="row p-2">
            <div class="col p-2 me-3 bg-secondary-subtle rounded">
                <label for="select-SQL-code" class="form-label fw-bold">SELECT CODE</label>
                <span class="form-control" style="height: 30vh;">
                    <?php if (isset($_POST['selectSQL'])): ?>
                        <input type="hidden" name="select_code" value="<?php echo $_POST['selectSQL']; ?>">
                        <?php echo $_POST['selectSQL']; ?>
                    <?php endif; ?>
                    <?php if (!isset($_POST['selectSQL'])): ?>
                        <input type="hidden" name="select_code" value="">
                        NOT SELECT SQL CODE.
                    <?php endif; ?>
                </span>
            </div>
            <div class="col p-2 bg-secondary-subtle rounded">
                <label for="insert-SQL-code" class="form-label fw-bold">INSERT CODE</label>
                <span class="form-control" style="height: 30vh;">
                    <?php if (isset($_POST['insertSQL'])): ?>
                        <input type="hidden" name="insert_code" value=<?php echo $_POST['insertSQL']; ?>>
                        <?php echo $_POST['insertSQL']; ?>
                    <?php endif; ?>
                    <?php if (!isset($_POST['insertSQL'])): ?>
                        <input type="hidden" name="insert_code" value="">
                        NOT INSERT SQL CODE.
                    <?php endif; ?>
                </span>
            </div>
        </div>
        <div class="row p-2">
            <div class="col p-2 me-3 bg-secondary-subtle rounded">
                <label for="delete-SQL-code" class="form-label fw-bold">DELETE CODE</label>
                <span class="form-control" style="height: 30vh;">
                    <?php if (isset($_POST['deleteSQL'])): ?>
                        <input type="hidden" name="delete_code" value=<?php echo $_POST['deleteSQL']; ?>>
                        <?php echo $_POST['deleteSQL']; ?>
                    <?php endif; ?>
                    <?php if (!isset($_POST['deleteSQL'])): ?>
                        <input type="hidden" name="delete_code" value="">
                        NOT DELETE SQL CODE.
                    <?php endif; ?>
                </span>
            </div>
            <div class="col p-2 bg-secondary-subtle rounded">
                <label for="update-SQL-code" class="form-label fw-bold">UPDATE CODE</label>
                <span class="form-control" style="height: 30vh;">
                    <?php if (isset($_POST['updateSQL'])): ?>
                        <input type="hidden" name="updateSQL" value=<?php echo $_POST['updateSQL']; ?>>
                        <?php echo $_POST['updateSQL']; ?>
                    <?php endif; ?>
                    <?php if (!isset($_POST['updateSQL'])): ?>
                        <input type="hidden" name="updateSQL" value="">
                        NOT UPDATE SQL CODE.
                    <?php endif; ?>
                </span>
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