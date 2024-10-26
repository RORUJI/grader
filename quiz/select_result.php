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
    include_once "../dbconnect.php";

    if (isset($_POST['user_code'])) {
        $user_code = $_POST['user_code'];

        $sql = $user_code;
        $query = $conn->query($sql);
    } else {
        header('../index.php');
    }
    ?>

    <table class="table">
        <thead>
            <tr>
                <?php
                $fields = $query->fetch_fields();
                foreach ($fields as $field) :
                ?>
                <th scope="col"><?php echo $field->name; ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $query->fetch_assoc()) : ?>
                <tr>
                    <?php foreach ($row as $data) : ?>
                        <td><?php echo $data; ?></td>
                    <?php endforeach; ?> 
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>

</html>