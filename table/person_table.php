<?php
    session_start();

    include_once '../dbconnect.php';

    $sql = "SELECT * FROM person";
    $result = mysqli_query($conn, $sql);
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <title>Grader</title>
</head>

<body class="bg-primary">
    <nav class="navbar navbar-expand-lg bg-body">
        <div class="container">
            <a class="navbar-brand" href="home.php">
                <h2 class="text-primary fw-bold">G r a d e r</h2>
            </a>
            <div class="justify-content-end align-items-center">
                <?php if (!isset($_SESSION['levelID'])): ?>
                    <a href="../login.php" class="btn btn-primary ms-3">Login</a>
                <?php endif; ?>
                <?php if (isset($_SESSION['levelID'])): ?>
                    <span class="text-primary fw-bold">Username:&nbsp;</span>
                    <span>
                        <?php echo $_SESSION['username']; ?>
                    </span>
                    <a href="../system/logout_system.php" id="signout-btn" class="btn btn-danger ms-3">Logout</a>
                <?php endif; ?>
                <button type="button" class="btn btn-danger" id="btnBack">Back</button>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-center text-light my-2">
            <h2>ตาราง Person</h2>
        </div>
        <table class="table table-striped table-bordered shadow-lg">
            <tr>
                <th scope="row">personID</th>
                <th scope="row">firstname</th>
                <th scope="row">lastname</th>
                <th scope="row">birthday</th>
                <th scope="row">weight</th>
                <th scope="row">height</th>
                <th scope="row">genderID</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $row['personID']; ?></td>
                    <td><?php echo $row['firstname']; ?></td>
                    <td><?php echo $row['lastname']; ?></td>
                    <td><?php echo $row['birthday']; ?></td>
                    <td><?php echo $row['weight']; ?></td>
                    <td><?php echo $row['height']; ?></td>
                    <td><?php echo $row['genderID']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

<script>
    $(document).ready(function() {
        $('#btnBack').click(function() {
            history.back();
        });
    });
</script>

</html>