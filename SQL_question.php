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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css?v<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <title>Grader</title>
</head>

<body class="">
    <div class="container-fluid">
        <div class="row" style="height: 100vh;">
            <div class="col-2 sidebar">
                <div class="row" style="height:7vh; width: auto; background-color:rgb(193, 192, 192);"></div>
                <div class="container">
                        <div class="User">
                            <div class="div-user">
                                <img src="User.jpg" alt="">
                            </div> 
                        </div>
                    </div>
                    <p class="name">
                        <?php if (isset($_SESSION['userID'])) : ?>
                            <?php echo $_SESSION['username']; ?>
                            <br/>
                            <a href="system/logout_system.php" class="btn btn-danger">Logout</a>
                        <?php endif; ?>
                        <?php if (!isset($_SESSION['userID'])) : ?>
                            Guest
                            <br/>
                            <a href="login.php" class="btn btn-secondary">Login</a>
                        <?php endif; ?>
                    </p>
                <a href="#" class="link-a"><i class="bi bi-house-fill"></i> Home</a>
                
            </div>
            <div class="col bannerbackground">
                <div class="row" style="height:7vh; width: auto; background-color:rgb(193, 192, 192);">
                    <div class="d-flex justify-content-center"><input type="text" class="search" placeholder="&#xF002; Search" style="font-family:Arial, FontAwesome"></div>
                </div>
                <div class="graph col banner"></div>
                <div class="graph banner2 row row-cols-6" style="padding: 2vh;">
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <div class="graph3 col mx-1">
                            <a href="grader_question.php?questionID=<?php echo $row['questionID']; ?>" class="graph3-text">ข้อที่ <?php echo $row['questionID']; ?></a>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
            
        </div>
    </div>
</body>

</html>