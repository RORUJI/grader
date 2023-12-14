<?php
session_start();

include_once('../dbconnect.php');

$sql = "SELECT * FROM type";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../style.css?v<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Grader</title>
</head>

<body class="bg-primary">
    <nav class="navbar navbar-expand-lg bg-body">
        <div class="container">
            <a class="navbar-brand" href="home.php">
                <h2 class="text-primary fw-bold">G r a d e r</h2>
            </a>
            <div class="justify-content-end align-items-center">
                <?php if(!isset($_SESSION['levelID'])): ?>
                    <a href="../login.php" class="btn btn-primary ms-3">Login</a>
                <?php endif; ?>
                <?php if(isset($_SESSION['levelID'])): ?>
                    <span class="text-primary fw-bold"><i class="bi bi-person-fill"></i> Username:&nbsp;</span>
                    <span>
                        <?php echo $_SESSION['username']; ?>
                    </span>
                    <a href="../system/logout_system.php" id="signout-btn" class="btn btn-danger ms-3">
                        <i class="bi bi-door-closed-fill"></i>Logout</a>
                <?php endif; ?>
                <button type="button" class="btn btn-danger" id="btnBack">Back</button>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="position-absolute top-50 start-50 translate-middle" style="margin-top: 20rem;">
            <form action="system/insert_question_system.php" method="post" id="insertForm"
                class="insert-form bg-body rounded p-3 shadow-lg">
                <h2 class="fw-bold text-center">สร้างโจทย์ปัญหา</h2>
                <hr>
                <div class="mb-3">
                    <label for="question" class="form-label fw-bold">Question</label>
                    <input type="text" name="question" id="question" cols="30" rows="10" class="form-control"
                        placeholder="กรอกโจทย์ปัญหา">
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label fw-bold">Type</label>
                    <select name="type" id="type" class="form-select">
                        <option value="">เลือกประเภท</option>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <option value="<?php echo $row['typeID']; ?>">
                                <?php echo $row['type']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label for="select" class="form-label fw-bold">Select Code</label>
                        <textarea name="select_code" id="select_code" cols="30" rows="10"
                            class="form-control"></textarea>
                    </div>
                    <div class="col">
                        <label for="insert" class="form-label fw-bold">Insert Code</label>
                        <textarea name="insert_code" id="insert_code" cols="30" rows="10"
                            class="form-control"></textarea>
                    </div>
                    <div class="col">
                        <label for="delete" class="form-label fw-bold">Delete Code</label>
                        <textarea name="delete_code" id="delete_code" cols="30" rows="10"
                            class="form-control"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">สร้างโจทย์ปัญหา</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#insertForm').submit(function (e) {
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
                                icon: result.status,
                                title: 'สำเร็จ!',
                                text: result.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            Swal.fire({
                                icon: result.status,
                                title: 'ล้มเหลว!',
                                text: result.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                })
            });
        });
    </script>
</body>

</html>