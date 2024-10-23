<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css?v<?php echo time(); ?>">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Grader</title>
</head>
<style>

</style>

<body>
    <section class="home">
        <div class="text">
            <div class="div-text-login">
                <img src="IconGrader.png" alt="" style="padding-bottom: 2.5vw; padding-left:4vw; margin-right: 1vw;">
                <div class="timeline">
                    <div class="div-login">
                        <form action="system/login_system.php" method="post" id="signinForm">
                            <h1>LOGIN</h1>
                            <hr>
                            <div>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Enter your email">
                            </div>
                            <p></p>
                            <div>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Enter your password">
                            </div>
                            <div>
                                <button type="submit" name="signin-btn" id="signin-btn"
                                    class="btn btn-primary fw-bold w-100">LOGIN</button>
                            </div>
                            <hr>
                            <div class="Register-text">
                                You don't have an account?
                                <a href="register2.php">Register!</a>
                            </div>
                        </form>
                    </div>
                </div><br>
            </div>
        </div>
    </section>

    <script src="change-mode.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('#signinForm').submit(function (e) {
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
                            }).then(function () {
                                if (result.level == 1) {
                                    window.location.href = 'index.php';
                                } else {
                                    window.location.href = 'adminpage/home.php';
                                }
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
                });
            });
        });
    </script>
</body>

</html>