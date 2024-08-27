<?php
session_start();
include_once "../../dbconnect.php";

$tableName = $_POST['tableName'];
$sql = "SELECT column_name FROM information_schema.columns WHERE table_schema = 'grader' AND table_name = '$tableName'";
$query = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php while ($row = $query->fetch_array()): ?>
        <div class="mb-2">
            <input type="checkbox" name="data[]" id="requestData" class="form-check-input requestData"
                value="<?php echo $row[0]; ?>">
            <label for="select-data" class="form-check-label">
                <?php echo $row[0]; ?>
            </label>
        </div>
    <?php endwhile; ?>
    <div class="mb">
        <input class="form-check-input" id="requestAll" name="data" type="checkbox" value="*">
        <label for="select-all-data" class="form-check-label">Select All</label>
    </div>

    <script src="request-data.js"></script>
</body>

</html>