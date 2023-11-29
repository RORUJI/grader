<!DOCTYPE html>
<html class="bg-primary" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Grader</title>
</head>

<body>
    <div class="position-absolute top-50 start-50 translate-middle">
        <form action="system/login_system.php" method="post" id="signinForm" class="signin-form bg-body rounded shadow-lg">
            <div class="p-3">
                <h2 class="fw-bold text-center">L o g i n</h2>
                <hr>
                <div class="mb-3">
                    <label for="email" class="fw-bold form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
                </div>
                <div class="mb-3">
                    <label for="password" class="fw-bold form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Enter your password">
                </div>
                <div class="mb-3 text-center">
                    You don't have an account?
                    <a href="register.php" class="signin-link text-primary">Register!</a>
                </div>
                <button type="submit" name="signin-btn" id="signin-btn" class="btn btn-primary fw-bold w-100">LOGIN</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
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
                            }).then(function() {
                                if (result.levelID == 1) {
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