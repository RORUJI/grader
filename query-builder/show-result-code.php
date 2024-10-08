<?php
include_once "../dbconnect.php";

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
    <div class="row p-2">
        <div class="col p-2 mx-2 rounded type-select" id="insert-form">
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
        </div>
    </div>
</body>

</html>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>