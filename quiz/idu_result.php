<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Grader</title>
</head>

<body>
    <?php
    session_start();
    include_once "../dbconnect.php";

    if (isset($_POST['delete_temporarily_table'])) {
        // ตรวจสอบว่ามี session user id หรือไม่
        if (!isset($_SESSION['userid'])) {
            header("Location: ../index.php");
            exit;
        }

        $delete_temptable = $_POST['delete_temporarily_table'];
        $table_name = "temp" . $_SESSION['userid'];

        // ตรวจสอบว่าตารางมีอยู่จริงหรือไม่
        $checkTableSQL = "SHOW TABLES LIKE '$table_name'";
        $checkTableQuery = $conn->query($checkTableSQL);

        if ($checkTableQuery->num_rows == 0) {
            header("Location: ../index.php");
            exit;
        }

        // Query แสดงข้อมูลตารางชั่วคราว
        $sql = "SELECT * FROM $table_name";
        $query = $conn->query($sql);
        ?>
        <table class="table">
            <thead>
                <tr>
                    <?php
                    $fields = $query->fetch_fields();
                    foreach ($fields as $field):
                        ?>
                        <th scope="col"><?php echo $field->name; ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $query->fetch_assoc()): ?>
                    <tr>
                        <?php foreach ($row as $data): ?>
                            <td><?php echo $data; ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <?php
        // ลบข้อมูลออกจากตาราง
        $stmt = $conn->prepare($delete_temptable);
        if ($stmt->execute()) {
            $stmt->close();
        }
    } else {
        header("Location: all_quiz.php");
        exit;
    }
    ?>

</body>

</html>