<?php
session_start();

include_once "dbconnect.php";

$sql = "SELECT * FROM question";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css?v<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <title>Grader</title>
</head>

<body class="">
    <div class="container-fluid">
        <div class="row" style="height: 100vh;">
            <div class="col-2 bg-primary">
                <div class="row" style="height:10vh; width: auto; background:bisque;"></div>
                <a href="#" class="link-a"><i class="bi bi-house-fill"></i> Home</a>
                <a href="#" class="link-a">Home</a>
                <a href="#" class="link-a">Home</a>
                <a href="#" class="link-a">Home</a>
            </div>
            <div class="col bg-success">
                <div class="row" style="height:10vh; width: auto; background:blueviolet;"></div>
                <div class="graph col bg-danger"></div>
                <div class="row row-cols-6 d-flex justify-content-center">
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <a href="grader_question.php?questionID=<?php echo $row['questionID']; ?>" class="btn btn-primary mx-2 mb-2">ข้อที่ <?php echo $row['questionID']; ?></a>
                    <?php endwhile; ?>
                </div>
            </div>
            <div class="col-2 bg-danger">
                <div class="row" style="height:10vh; width: auto; background:aquamarine;"></div>
                <div class="container">
                    <div class="hexagon">
                        <div class="shape">
                            <img src="User.jpg" alt="">
                        </div>
                        <p class="name">User Test</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>